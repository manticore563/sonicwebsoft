<?php

namespace App\Tools;

use App\Models\Tool;
use Faker\Factory as Faker;
use Illuminate\Http\Request;
use App\Contracts\ToolInterface;

class FakeAddressGenerator implements ToolInterface
{
    public function render(Request $request, Tool $tool)
    {
        return view('tools.fake-address-generator', compact('tool'));
    }

    public function handle(Request $request, Tool $tool)
    {
        // Validate the request with all locales
        $request->validate([
            'country' => 'required|in:ar_SA,hy_AM,az_AZ,zh_CN,zh_TW,hr_HR,cs_CZ,nl_NL,nl_BE,en_US,en_GB,en_AU,en_CA,en_IE,en_ZA,fi_FI,fr_FR,fr_CA,fr_CH,ka_GE,de_DE,de_AT,de_CH,id_ID,it_IT,ja_JP,ko_KR,ne_NP,nb_NO,fa_IR,pl_PL,pt_BR,pt_PT,ro_RO,ru_RU,sk_SK,es_ES,es_MX,sv_SE,tr_TR,uk_UA,vi_VN',
            'city' => 'nullable|string|max:100',
            'zipCode' => 'nullable|string|min:1',
        ]);

        // Get the selected locale directly from the form input
        $selectedLocale = $request->input('country');

        // Create Faker instance based on the selected locale
        $faker = Faker::create($selectedLocale);

        // Switch case handling for locales
        switch ($selectedLocale) {
            case 'ar_SA': // Saudi Arabia
                $states = ['Riyadh', 'Makkah', 'Eastern Province', 'Medina', 'Jizan', 'Tabuk'];
                $cities = ['Riyadh', 'Jeddah', 'Mecca', 'Dammam', 'Medina', 'Khobar'];
                $country = 'Saudi Arabia';
                break;
            case 'hy_AM': // Armenia
                $states = ['Yerevan', 'Shirak', 'Lori', 'Kotayk', 'Tavush', 'Ararat', 'Vayots Dzor'];
                $cities = ['Yerevan', 'Gyumri', 'Vanadzor', 'Hrazdan', 'Vagharshapat'];
                $country = 'Armenia';
                break;
            case 'az_AZ': // Azerbaijan
                $states = ['Absheron', 'Ganja-Gazakh', 'Shirvan', 'Lankaran', 'Nakhchivan', 'Shaki-Zaqatala'];
                $cities = ['Baku', 'Ganja', 'Sumqayit', 'Mingachevir', 'Shaki', 'Lankaran', 'Nakhchivan'];
                $country = 'Azerbaijan';
                break;
            case 'zh_CN': // China
                $states = ['Beijing', 'Shanghai', 'Guangdong', 'Zhejiang', 'Jiangsu', 'Sichuan'];
                $cities = ['Beijing', 'Shanghai', 'Guangzhou', 'Shenzhen', 'Hangzhou', 'Chengdu'];
                $country = 'China';
                break;
            case 'zh_TW': // Taiwan
                $states = ['Taipei', 'Kaohsiung', 'Taichung', 'Tainan'];
                $cities = ['Taipei', 'Kaohsiung', 'Taichung', 'Tainan', 'Hsinchu'];
                $country = 'Taiwan';
                break;
            case 'hr_HR': // Croatia
                $states = ['Zagreb', 'Split-Dalmatia', 'Istria', 'Primorje-Gorski Kotar', 'Dubrovnik-Neretva'];
                $cities = ['Zagreb', 'Split', 'Rijeka', 'Osijek', 'Zadar'];
                $country = 'Croatia';
                break;
            case 'cs_CZ': // Czech Republic
                $states = ['Prague', 'South Moravian', 'Moravian-Silesian', 'Central Bohemian'];
                $cities = ['Prague', 'Brno', 'Ostrava', 'Plzeň', 'Liberec'];
                $country = 'Czech Republic';
                break;
            case 'nl_NL': // Netherlands
                $states = ['North Holland', 'South Holland', 'Utrecht', 'Gelderland', 'North Brabant'];
                $cities = ['Amsterdam', 'Rotterdam', 'The Hague', 'Utrecht', 'Eindhoven'];
                $country = 'Netherlands';
                break;
            case 'nl_BE': // Belgium
                $states = ['Flanders', 'Wallonia', 'Brussels'];
                $cities = ['Brussels', 'Antwerp', 'Ghent', 'Bruges', 'Liège'];
                $country = 'Belgium';
                break;
            case 'en_US': // United States
                $state = $faker->state;
                $city = $request->input('city') ?: $faker->city;
                $cities = [$city];
                $states = [$state];
                $country = 'United States';
                break;
            case 'en_GB': // United Kingdom
                $state = $faker->county;
                $city = $request->input('city') ?: $faker->city;
                $cities = [$city];
                $states = [$state];
                $country = 'United Kingdom';
                break;
            case 'en_AU': // Australia
                $states = ['New South Wales', 'Victoria', 'Queensland', 'Western Australia', 'South Australia'];
                $cities = ['Sydney', 'Melbourne', 'Brisbane', 'Perth', 'Adelaide'];
                $country = 'Australia';
                break;
            case 'en_CA': // Canada
                $states = ['Ontario', 'Quebec', 'British Columbia', 'Alberta', 'Manitoba', 'Nova Scotia'];
                $cities = ['Toronto', 'Montreal', 'Vancouver', 'Calgary', 'Ottawa'];
                $country = 'Canada';
                break;
            case 'en_IE': // Ireland
                $states = ['Leinster', 'Munster', 'Connacht', 'Ulster'];
                $cities = ['Dublin', 'Cork', 'Galway', 'Limerick', 'Waterford'];
                $country = 'Ireland';
                break;
            case 'en_ZA': // South Africa
                $states = ['Gauteng', 'Western Cape', 'KwaZulu-Natal', 'Eastern Cape'];
                $cities = ['Johannesburg', 'Cape Town', 'Durban', 'Pretoria', 'Port Elizabeth'];
                $country = 'South Africa';
                break;
            case 'fi_FI': // Finland
                $states = ['Uusimaa', 'Southwest Finland', 'Pirkanmaa', 'North Ostrobothnia'];
                $cities = ['Helsinki', 'Espoo', 'Tampere', 'Oulu', 'Turku'];
                $country = 'Finland';
                break;
            case 'fr_FR': // France
                $states = ['Île-de-France', 'Provence-Alpes-Côte d\'Azur', 'Auvergne-Rhône-Alpes', 'Brittany'];
                $cities = ['Paris', 'Marseille', 'Lyon', 'Toulouse', 'Nice', 'Nantes'];
                $country = 'France';
                break;
            case 'fr_CA': // French (Canada)
                $states = ['Quebec', 'Ontario', 'British Columbia', 'Alberta', 'Manitoba'];
                $cities = ['Montreal', 'Toronto', 'Vancouver', 'Ottawa', 'Quebec City'];
                $country = 'Canada';
                break;
            case 'fr_CH': // French (Switzerland)
                $states = ['Zurich', 'Vaud', 'Geneva', 'Bern', 'Aargau'];
                $cities = ['Zurich', 'Geneva', 'Lausanne', 'Basel', 'Bern'];
                $country = 'Switzerland';
                break;
            case 'ka_GE': // Georgia
                $states = ['Tbilisi', 'Adjara', 'Imereti', 'Kvemo Kartli'];
                $cities = ['Tbilisi', 'Batumi', 'Kutaisi', 'Rustavi', 'Poti'];
                $country = 'Georgia';
                break;
            case 'de_DE': // Germany
                $states = ['Bavaria', 'Berlin', 'Hamburg', 'Saxony', 'Hesse', 'Baden-Württemberg'];
                $cities = ['Berlin', 'Munich', 'Hamburg', 'Frankfurt', 'Stuttgart'];
                $country = 'Germany';
                break;
            case 'de_AT': // Austria
                $states = ['Vienna', 'Salzburg', 'Styria', 'Tyrol', 'Carinthia'];
                $cities = ['Vienna', 'Salzburg', 'Innsbruck', 'Graz', 'Linz'];
                $country = 'Austria';
                break;
            case 'de_CH': // Switzerland
                $states = ['Zurich', 'Vaud', 'Geneva', 'Bern', 'Aargau'];
                $cities = ['Zurich', 'Geneva', 'Lausanne', 'Basel', 'Bern'];
                $country = 'Switzerland';
                break;
            case 'id_ID': // Indonesia
                $states = ['Jakarta', 'West Java', 'Central Java', 'East Java', 'Bali'];
                $cities = ['Jakarta', 'Surabaya', 'Bandung', 'Bekasi', 'Medan'];
                $country = 'Indonesia';
                break;
            case 'it_IT': // Italy
                $states = ['Lombardy', 'Lazio', 'Campania', 'Veneto', 'Piedmont'];
                $cities = ['Rome', 'Milan', 'Naples', 'Turin', 'Palermo'];
                $country = 'Italy';
                break;
            case 'ja_JP': // Japan
                $states = ['Tokyo', 'Osaka', 'Kanagawa', 'Hokkaido', 'Fukuoka', 'Aichi'];
                $cities = ['Tokyo', 'Osaka', 'Yokohama', 'Sapporo', 'Nagoya', 'Fukuoka'];
                $country = 'Japan';
                break;
            case 'ko_KR': // South Korea
                $states = ['Seoul', 'Busan', 'Incheon', 'Gwangju', 'Daegu'];
                $cities = ['Seoul', 'Busan', 'Incheon', 'Daegu', 'Daejeon'];
                $country = 'South Korea';
                break;
            case 'ne_NP': // Nepal
                $states = ['Bagmati', 'Lumbini', 'Gandaki', 'Karnali', 'Sudurpashchim'];
                $cities = ['Kathmandu', 'Pokhara', 'Lalitpur', 'Biratnagar', 'Bharatpur'];
                $country = 'Nepal';
                break;
            case 'nb_NO': // Norway
                $states = ['Oslo', 'Vestland', 'Viken', 'Rogaland', 'Trøndelag'];
                $cities = ['Oslo', 'Bergen', 'Trondheim', 'Stavanger', 'Drammen'];
                $country = 'Norway';
                break;
            case 'fa_IR': // Iran
                $states = ['Tehran', 'Fars', 'Isfahan', 'Khorasan', 'East Azerbaijan'];
                $cities = ['Tehran', 'Mashhad', 'Isfahan', 'Tabriz', 'Shiraz'];
                $country = 'Iran';
                break;
            case 'pl_PL': // Poland
                $states = ['Masovian', 'Lesser Poland', 'Silesian', 'Greater Poland'];
                $cities = ['Warsaw', 'Kraków', 'Łódź', 'Wrocław', 'Poznań'];
                $country = 'Poland';
                break;
            case 'pt_BR': // Brazil
                $states = ['São Paulo', 'Rio de Janeiro', 'Bahia', 'Minas Gerais', 'Paraná'];
                $cities = ['São Paulo', 'Rio de Janeiro', 'Salvador', 'Brasília', 'Fortaleza'];
                $country = 'Brazil';
                break;
            case 'pt_PT': // Portugal
                $states = ['Lisbon', 'Porto', 'Braga', 'Coimbra', 'Faro'];
                $cities = ['Lisbon', 'Porto', 'Braga', 'Coimbra', 'Funchal'];
                $country = 'Portugal';
                break;
            case 'ro_RO': // Romania
                $states = ['Bucharest', 'Cluj', 'Timiș', 'Iași', 'Constanța'];
                $cities = ['Bucharest', 'Cluj-Napoca', 'Timișoara', 'Iași', 'Constanța'];
                $country = 'Romania';
                break;
            case 'ru_RU': // Russia
                $states = ['Moscow', 'Saint Petersburg', 'Novosibirsk', 'Sverdlovsk', 'Tatarstan'];
                $cities = ['Moscow', 'Saint Petersburg', 'Novosibirsk', 'Yekaterinburg', 'Kazan'];
                $country = 'Russia';
                break;
            case 'sk_SK': // Slovakia
                $states = ['Bratislava', 'Košice', 'Nitra', 'Trnava'];
                $cities = ['Bratislava', 'Košice', 'Prešov', 'Nitra', 'Žilina'];
                $country = 'Slovakia';
                break;
            case 'es_ES': // Spain
                $states = ['Andalusia', 'Catalonia', 'Madrid', 'Valencia', 'Galicia', 'Basque Country'];
                $cities = ['Madrid', 'Barcelona', 'Valencia', 'Seville', 'Zaragoza'];
                $country = 'Spain';
                break;
            case 'es_MX': // Mexico
                $states = ['Mexico City', 'Jalisco', 'Nuevo León', 'Yucatán', 'Puebla'];
                $cities = ['Mexico City', 'Guadalajara', 'Monterrey', 'Mérida', 'Puebla'];
                $country = 'Mexico';
                break;
            case 'sv_SE': // Sweden
                $states = ['Stockholm', 'Västra Götaland', 'Skåne', 'Uppsala', 'Östergötland'];
                $cities = ['Stockholm', 'Gothenburg', 'Malmö', 'Uppsala', 'Linköping'];
                $country = 'Sweden';
                break;
            case 'tr_TR': // Turkey
                $states = ['Istanbul', 'Ankara', 'Izmir', 'Bursa', 'Antalya'];
                $cities = ['Istanbul', 'Ankara', 'Izmir', 'Bursa', 'Adana'];
                $country = 'Turkey';
                break;
            case 'uk_UA': // Ukraine
                $states = ['Kyiv', 'Lviv', 'Odessa', 'Kharkiv', 'Dnipro'];
                $cities = ['Kyiv', 'Lviv', 'Odessa', 'Kharkiv', 'Dnipro'];
                $country = 'Ukraine';
                break;
            case 'vi_VN': // Vietnam
                $states = ['Hanoi', 'Ho Chi Minh City', 'Da Nang', 'Hai Phong', 'Can Tho'];
                $cities = ['Hanoi', 'Ho Chi Minh City', 'Da Nang', 'Nha Trang', 'Can Tho'];
                $country = 'Vietnam';
                break;
            default:
                $states = [$faker->state];  // Fallback to Faker's state method
                $cities = [$faker->city];   // Fallback to Faker's city method
                $country = $faker->country; // Fallback to Faker's country method
                break;
        }

        // Generate city: Use input if provided, otherwise randomly select from the defined cities
        $city = $request->input('city') ?: $faker->randomElement($cities);

        // Generate state/region: Randomly select from the defined states
        $state = $faker->randomElement($states);

        // Generate zipcode: Use input if provided, otherwise generate a random one
        $zipCode = $request->input('zipCode') ?: $faker->postcode;

        // Generate telephone and mobile numbers relevant to the locale
        $telephone = $this->generateTelephoneNumber($faker, $selectedLocale);
        $mobile = $this->generateMobileNumber($faker, $selectedLocale);

        // Generate the rest of the address
        $results = [
            'street_address' => $faker->streetAddress,
            'city' => $city,
            'state' => $state,
            'zipCode' => $zipCode,
            'country' => $country,
            'telephone' => $telephone,   // Generated landline number
            'mobile' => $mobile          // Generated mobile number
        ];

        return view('tools.fake-address-generator', compact('results', 'tool', 'selectedLocale'));
    }

    /**
     * Generate a valid mobile number, ensuring it's actually a mobile number if possible.
     */
    private function generateMobileNumber($faker, $locale)
    {
        // Some locales provide mobile number patterns, handle that
        switch ($locale) {
            case 'ar_SA': // Saudi Arabia
                return $faker->numerify('05# ### ####'); // Mobile numbers in Saudi Arabia start with 05
            case 'hy_AM': // Armenia
                return $faker->numerify('09## #####'); // Armenian mobile numbers start with 09
            case 'az_AZ': // Azerbaijan
                return $faker->numerify('050 ### ## ##'); // Azerbaijani mobile numbers start with 050 or 051
            case 'zh_CN': // China
                return $faker->numerify('1##########'); // Chinese mobile numbers start with 1
            case 'zh_TW': // Taiwan
                return $faker->numerify('09## ### ###'); // Taiwanese mobile numbers start with 09
            case 'hr_HR': // Croatia
                return $faker->numerify('09# ### ###'); // Croatian mobile numbers start with 09
            case 'cs_CZ': // Czech Republic
                return $faker->numerify('### ### ###'); // Czech mobile numbers start with 6 or 7
            case 'nl_NL': // Netherlands
                return $faker->numerify('06 ########'); // Dutch mobile numbers start with 06
            case 'nl_BE': // Belgium
                return $faker->numerify('04## ## ## ##'); // Belgian mobile numbers start with 04
            case 'en_US': // US
                return $faker->numerify('(###) ###-####'); // US mobile numbers don't have a distinct pattern
            case 'en_AU': // Australia
                return $faker->numerify('04## ### ###'); // Australian mobile numbers start with 04
            case 'en_GB': // United Kingdom
                return $faker->numerify('+44 7#### ######'); // UK mobile numbers start with 07
            case 'en_CA': // Canada
                return $faker->numerify('(###) ###-####'); // Canadian mobile numbers are similar to US format
            case 'en_IN': // India
                return $faker->numerify('9#########'); // Indian mobile numbers start with 9
            case 'fi_FI': // Finland
                return $faker->numerify('04# ### ####'); // Finnish mobile numbers start with 04 or 05
            case 'fr_FR': // France
                return $faker->numerify('06 ## ## ## ##'); // French mobile numbers start with 06 or 07
            case 'fr_CA': // Canada (French)
                return $faker->numerify('(###) ###-####'); // Canadian mobile numbers in French format (same as US)
            case 'fr_CH': // Switzerland
                return $faker->numerify('07# ### ## ##'); // Swiss mobile numbers start with 07
            case 'de_DE': // Germany
                return $faker->numerify('015# ### #####'); // German mobile numbers start with 015 or 016
            case 'de_AT': // Austria
                return $faker->numerify('06## #######'); // Austrian mobile numbers start with 06
            case 'de_CH': // Switzerland (German)
                return $faker->numerify('07# ### ## ##'); // Swiss mobile numbers start with 07
            case 'id_ID': // Indonesia
                return $faker->numerify('08## #### ####'); // Indonesian mobile numbers start with 08
            case 'it_IT': // Italy
                return $faker->numerify('3## ### ####'); // Italian mobile numbers start with 3
            case 'ja_JP': // Japan
                return $faker->numerify('090-####-####'); // Japanese mobile numbers start with 090 or 080
            case 'ko_KR': // South Korea
                return $faker->numerify('010-####-####'); // South Korean mobile numbers start with 010
            case 'ne_NP': // Nepal
                return $faker->numerify('98########'); // Nepali mobile numbers start with 98 or 97
            case 'nb_NO': // Norway
                return $faker->numerify('4## ## ###'); // Norwegian mobile numbers start with 4 or 9
            case 'fa_IR': // Iran
                return $faker->numerify('09## ### ####'); // Iranian mobile numbers start with 09
            case 'pl_PL': // Poland
                return $faker->numerify('6## ### ###'); // Polish mobile numbers start with 6
            case 'pt_BR': // Brazil
                return $faker->numerify('(##) 9####-####'); // Brazilian mobile numbers start with 9 and have an area code
            case 'pt_PT': // Portugal
                return $faker->numerify('9## ### ###'); // Portuguese mobile numbers start with 9
            case 'ro_RO': // Romania
                return $faker->numerify('07## ### ###'); // Romanian mobile numbers start with 07
            case 'ru_RU': // Russia
                return $faker->numerify('+7 9## ### ## ##'); // Russian mobile numbers start with +7 9
            case 'sk_SK': // Slovakia
                return $faker->numerify('09## ### ###'); // Slovak mobile numbers start with 09
            case 'es_ES': // Spain
                return $faker->numerify('6## ### ###'); // Spanish mobile numbers start with 6
            case 'es_MX': // Mexico
                return $faker->numerify('55 ## ## ####'); // Mexican mobile numbers typically start with 55 (Mexico City)
            case 'sv_SE': // Sweden
                return $faker->numerify('07# ### ## ##'); // Swedish mobile numbers start with 07
            case 'tr_TR': // Turkey
                return $faker->numerify('05## ### ####'); // Turkish mobile numbers start with 05
            case 'uk_UA': // Ukraine
                return $faker->numerify('+380 ## ### ## ##'); // Ukrainian mobile numbers start with +380
            case 'vi_VN': // Vietnam
                return $faker->numerify('09## ### ###'); // Vietnamese mobile numbers start with 09 or 03
            default:
                // Fallback to using Faker's phoneNumber as mobile number
                return $faker->phoneNumber;
        }
    }


    private function generateTelephoneNumber($faker, $locale)
    {
        // Handle telephone number generation based on locale
        switch ($locale) {
            case 'fr_FR': // France
                return $faker->numerify('01 ## ## ## ##'); // French landline numbers start with 01, 02, etc.
            case 'en_AU': // Australia
                return $faker->numerify('(02) #### ####'); // Australian landlines start with 02, 03, 07, 08
            case 'en_US': // US
                return $faker->numerify('(###) ###-####'); // US landline format
            case 'en_GB': // UK
                return $faker->numerify('+44 20 #### ####'); // UK landlines start with 01 or 02
            case 'de_DE': // Germany
                return $faker->numerify('0### #######'); // German landlines start with 0
            case 'fr_CH': // Switzerland
                return $faker->numerify('0## ### ## ##'); // Swiss landlines start with 02 or 03
            case 'nl_NL': // Netherlands
                return $faker->numerify('0# ## ## ## ##'); // Dutch landlines start with 0
            case 'nl_BE': // Belgium
                return $faker->numerify('0# ### ## ##'); // Belgian landlines start with 0
            case 'it_IT': // Italy
                return $faker->numerify('0# #### ####'); // Italian landlines start with 0
            case 'ja_JP': // Japan
                return $faker->numerify('0#-####-####'); // Japanese landlines start with 0
            case 'es_ES': // Spain
                return $faker->numerify('9## ### ###'); // Spanish landlines start with 9
            case 'pt_BR': // Brazil
                return $faker->numerify('(##) ####-####'); // Brazilian landlines start with 2 to 5
            case 'pt_PT': // Portugal
                return $faker->numerify('2## ### ###'); // Portuguese landlines start with 2
            case 'pl_PL': // Poland
                return $faker->numerify('22 ### ####'); // Polish landlines start with 22 (Warsaw) or other 2-digit codes
            case 'ru_RU': // Russia
                return $faker->numerify('+7 (###) ###-##-##'); // Russian landlines start with +7 and area code
            case 'ro_RO': // Romania
                return $faker->numerify('02## ### ###'); // Romanian landlines start with 02 or 03
            case 'sk_SK': // Slovakia
                return $faker->numerify('02/### ### ###'); // Slovak landlines start with 02
            case 'fi_FI': // Finland
                return $faker->numerify('0# ### ####'); // Finnish landlines start with 0
            case 'sv_SE': // Sweden
                return $faker->numerify('0##-### ## ##'); // Swedish landlines start with 0
            case 'no_NO': // Norway
                return $faker->numerify('0# ## ## ## ##'); // Norwegian landlines start with 0
            case 'tr_TR': // Turkey
                return $faker->numerify('0### ### ## ##'); // Turkish landlines start with 0
            case 'id_ID': // Indonesia
                return $faker->numerify('(021) #### ####'); // Indonesian landlines start with (021) for Jakarta
            case 'kr_KR': // South Korea
                return $faker->numerify('0#-####-####'); // South Korean landlines start with 02 (Seoul) or other area codes
            case 'cn_CN': // China
                return $faker->numerify('(0##) #### ####'); // Chinese landlines start with an area code
            case 'tw_TW': // Taiwan
                return $faker->numerify('0#-####-####'); // Taiwanese landlines start with 0
            case 'vn_VN': // Vietnam
                return $faker->numerify('0## #### ###'); // Vietnamese landlines start with 0
            case 'ua_UA': // Ukraine
                return $faker->numerify('+380 ## ### ## ##'); // Ukrainian landlines start with +380 and area code
            case 'ar_SA': // Saudi Arabia
                return $faker->numerify('0# ### ####'); // Saudi Arabian landlines start with 01 or 02
            case 'hy_AM': // Armenia
                return $faker->numerify('0## ### ###'); // Armenian landlines start with 0
            case 'az_AZ': // Azerbaijan
                return $faker->numerify('(012) ### ## ##'); // Azerbaijani landlines start with (012) for Baku
            case 'ne_NP': // Nepal
                return $faker->numerify('0#-#######'); // Nepali landlines start with 01 for Kathmandu
            case 'fa_IR': // Iran
                return $faker->numerify('0## #### ####'); // Iranian landlines start with 021 for Tehran
            default:
                // Fallback to using Faker's phoneNumber as landline number
                return $faker->phoneNumber;
        }
    }
}
