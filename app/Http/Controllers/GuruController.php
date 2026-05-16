<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GuruController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500',
            'context' => 'nullable|string|max:1000',
        ]);

        $systemPrompt = "You are Guru, a friendly AI news assistant for Nepal News Australia — a bilingual news platform serving the Nepali-Australian community. You help users with: summarising and explaining news articles, answering questions about Nepal and Australia, translating between English and Nepali, providing context about Nepali culture and community matters in Australia. Keep responses concise (2-4 sentences). Be warm and culturally aware. Respond in the same language the user writes in.";

        $messages = [
            ['role' => 'system', 'content' => $systemPrompt],
        ];

        if ($request->context) {
            $messages[] = ['role' => 'system', 'content' => 'Current page context: ' . $request->context];
        }

        $messages[] = ['role' => 'user', 'content' => $request->message];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.groq.key'),
            'Content-Type' => 'application/json',
        ])->post('https://api.groq.com/openai/v1/chat/completions', [
            'model' => 'llama-3.1-8b-instant',
            'messages' => $messages,
            'max_tokens' => 300,
            'temperature' => 0.7,
        ]);

        if ($response->successful()) {
            return response()->json([
                'reply' => $response->json('choices.0.message.content')
            ]);
        }

        return response()->json([
            'reply' => 'Guru is taking a short break. Please try again! 🙏'
        ], 200);
    }
}
