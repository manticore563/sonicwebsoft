<?php

namespace App\Components\Drivers;

use GuzzleHttp\Client;
use App\Contracts\ToolDriverInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;

class OpenAiRewriter implements ToolDriverInterface
{
    private array $prompts = [
        'en' => [
            'default' => "Please rewrite the following text in a clear and concise manner while keeping the original meaning:\n\n%s",
            'formal' => "Rewrite the following text in a formal tone while keeping the meaning intact:\n\n%s",
            'casual' => "Rewrite the following text in a casual and friendly tone:\n\n%s",
            'simplify' => "Simplify the following text for easier understanding:\n\n%s"
        ]
    ];

    protected $apikey;
    protected $model;
    protected $systemMessage;
    protected $endpoint = "https://api.openai.com/v1/chat/completions";

    public function __construct(string $apikey, $systemMessage = 'You are an assistant who rewrites text.', string $model = "gpt-3.5-turbo", array $prompts = [])
    {
        $this->apikey = $apikey;
        $this->model = $model;
        $this->systemMessage = $systemMessage;
        if (!blank($prompts)) {
            $this->prompts = $prompts;
        }
    }

    public function parse($article, $prompt = null)
    {
        try {
            $client = new Client();

            // Create the message format required by chat-based models
            $messages = [
                [
                    'role' => 'system',
                    'content' => $this->systemMessage,
                ],
                [
                    'role' => 'user',
                    'content' => $prompt == null ? $this->get_prompt($article) : $prompt
                ]
            ];

            // Send the request to the OpenAI API
            $response = $client->request('POST', $this->endpoint, [
                'body' => json_encode([
                    'model' => $this->model,
                    'messages' => $messages,
                    "temperature" => 0,
                    'max_tokens' => min(
                        $this->calculate_max_tokens($article),
                        $this->get_max_tokens_for_model($this->model)
                    ),
                ]),
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apikey,
                    'Content-Type' => 'application/json',
                ],
            ]);

            $body = $response->getBody();
            $json = json_decode($body, true);
        } catch (ClientException $e) {
            $error = json_decode($e->getResponse()->getBody()->getContents());

            return ['success' => false, 'message' => $error->error->message];
        } catch (GuzzleException $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }

        // Extract response text from the chat model format
        $choices = $json['choices'];
        if (count($choices) == 0) {
            return ['success' => false, 'message' => __('common.somethingWentWrong')];
        }

        // For chat models, the result text is in the 'message' part
        $resultText = trim($choices[0]['message']['content']);

        return ['success' => true, 'text' => $resultText];
    }

    protected function get_prompt($inputText, $style = 'default')
    {
        $language = app()->getLocale();
        if (!isset($this->prompts[$language])) {
            $language = 'en';
        }

        $selectedPrompt = $this->prompts[$language][$style] ?? $this->prompts[$language]['default'];

        return sprintf($selectedPrompt, $inputText);
    }

    protected function calculate_max_tokens($inputText)
    {
        return 4000 - intval(get_number_of_words_in_text($inputText) * 1.3);
    }

    protected function get_max_tokens_for_model($model)
    {
        if ($model == 'gpt-3.5-turbo' || $model == 'gpt-4') {
            return 4096;
        }

        return 1700;
    }
}
