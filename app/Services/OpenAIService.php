<?php

namespace App\Services;

use OpenAI;

class OpenAIService
{
    public function chat($message)
    {
        $client = OpenAI::client(env('OPENAI_API_KEY'));

        $response = $client->chat()->create([
            'model' => 'gpt-4',
            'messages' => [
                ['role' => 'user', 'content' => $message],
            ],
        ]);

        return $response->choices[0]->message->content ?? 'Tidak ada respons.';
    }
}