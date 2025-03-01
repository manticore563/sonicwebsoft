<?php

namespace App\Tools;

use App\Models\Tool;
use Faker\Factory as Faker;
use Illuminate\Http\Request;
use App\Contracts\ToolInterface;

class CreditCardGenerator implements ToolInterface
{
    public function render(Request $request, Tool $tool)
    {
        return view('tools.credit-card-generator', compact('tool'));
    }

    public function handle(Request $request, Tool $tool)
    {
        // Validation rules
        $request->validate([
            'card_type' => 'required|in:random,visa,mastercard,ae,discover,jcb',
            'exp_month' => 'required|in:random,1,2,3,4,5,6,7,8,9,10,11,12',
            'exp_year' => 'required|in:random,' . implode(',', range(now()->year, now()->year + 8)),
            'cvv' => 'nullable|digits_between:3,4',
            'quantity' => 'required|in:random,5,10,15,20,25,30,35,40,45,50',
        ]);

        $faker = Faker::create();

        // Determine the quantity
        $quantity = $request->input('quantity') === 'random' ? $faker->numberBetween(5, 50) : (int)$request->input('quantity');

        // Initialize the cards collection
        $results = collect([]);

        // Generate the specified quantity of cards
        $results = collect(range(1, $quantity))->map(function ($index) use ($request, $faker) {
            // Generate card based on the card type
            $cardType = $request->input('card_type') === 'random' ? $faker->creditCardType : $this->getCardType($request->input('card_type'));

            // Generate a card number for the selected type
            $cardNumber = $this->generateCardNumber($cardType, $faker);

            // Expiration year (at least the current year or greater)
            $currentYear = (int)now()->format('Y');
            $expYear = $this->getValidExpirationYear($request, $faker, $currentYear);

            // Expiration month
            $expMonth = $this->getValidExpirationMonth($request, $faker, $expYear, $currentYear);

            // CVV (For Visa, MasterCard it's 3 digits; for American Express it's 4 digits)
            $cvv = $request->input('cvv') ?: ($cardType === 'American Express' ? $faker->numerify('####') : $faker->numerify('###'));

            // Generate cardholder name
            $cardHolderName = $faker->name;

            // Return a card array
            return [
                'card_type' => $cardType,
                'card_number' => $cardNumber,
                'exp_month' => $expMonth,
                'exp_year' => $expYear,
                'cvv' => $cvv,
                'image' =>  $this->getCardImage($cardType),
                'holder_name' => $cardHolderName,
            ];
        });

        return view('tools.credit-card-generator', compact('results', 'tool'));
    }

    /**
     * Get a valid expiration year (no earlier than the current year).
     */
    private function getValidExpirationYear(Request $request, $faker, $currentYear)
    {
        if ($request->input('exp_year') === 'random') {
            return $faker->numberBetween($currentYear, $currentYear + 8);  // Random year within next 9 years
        }

        return (int)$request->input('exp_year');  // Use the year provided in the form
    }

    /**
     * Get a valid expiration month, considering the year.
     */
    private function getValidExpirationMonth(Request $request, $faker, $expYear, $currentYear)
    {
        $currentMonth = (int)now()->format('m');

        if ($request->input('exp_month') === 'random') {
            // If expiration year is the current year, the month should not be before the current month
            if ((int)$expYear === $currentYear) {
                return $faker->numberBetween($currentMonth, 12);
            } else {
                return $faker->numberBetween(1, 12);  // Any month if the year is in the future
            }
        }

        return (int)$request->input('exp_month');
    }

    /**
     * Map card type selection to the Faker library's card type names.
     */
    private function getCardType($type)
    {
        switch ($type) {
            case 'visa':
                return 'Visa';
            case 'mastercard':
                return 'MasterCard';
            case 'ae':
                return 'American Express';
            case 'discover':
                return 'Discover Card';
            case 'jcb':
                return 'JCB';
            default:
                return 'Visa';
        }
    }

    /**
     * Map Faker library's card type names back to form input values.
     */
    private function reverseCardType($type)
    {
        switch ($type) {
            case 'Visa':
                return 'visa';
            case 'MasterCard':
                return 'mastercard';
            case 'American Express':
                return 'ae';
            case 'Discover Card':
                return 'discover';
            case 'JCB':
                return 'jcb';
            default:
                return 'visa'; // Default to visa if no match
        }
    }

    /**
     * Map card type selection to the Faker library's card type names.
     */
    private function getCardImage($type)
    {
        $type = $this->reverseCardType($type);

        return url("themes/default/images/{$type}.svg");
    }

    /**
     * Generate card number for the specific card type.
     */
    private function generateCardNumber($cardType, $faker)
    {
        // Use Faker's creditCardNumber method based on the card type
        switch ($cardType) {
            case 'Visa':
                $cardNumber = $faker->creditCardNumber('Visa');
                break;
            case 'MasterCard':
                $cardNumber = $faker->creditCardNumber('MasterCard');
                break;
            case 'American Express':
                $cardNumber = $faker->creditCardNumber('American Express');
                break;
            case 'Discover Card':
                $cardNumber = $faker->creditCardNumber('Discover Card');
                break;
            case 'JCB':
                $cardNumber = $faker->creditCardNumber('JCB');
                break;
            default:
                $cardNumber = $faker->creditCardNumber;
                break;
        }

        // Remove any non-digit characters (like spaces or dashes) before formatting
        $cardNumber = preg_replace('/\D/', '', $cardNumber);

        // Format the card number with dashes (groups of 4 digits)
        if ($cardType === 'American Express') {
            // For American Express, format as #### ###### ##### (15 digits)
            return substr($cardNumber, 0, 4) . '-' . substr($cardNumber, 4, 6) . '-' . substr($cardNumber, 10);
        } else {
            // For other card types (Visa, MasterCard, etc.), format as #### #### #### #### (16 digits)
            return substr($cardNumber, 0, 4) . '-' . substr($cardNumber, 4, 4) . '-' . substr($cardNumber, 8, 4) . '-' . substr($cardNumber, 12);
        }
    }
}
