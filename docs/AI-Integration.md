# AI Integration — Guru Chatbot
## Nepal News Australia | CPRO306 Capstone Project | Team 9

---

## 1. Overview

Nepal News Australia integrates artificial intelligence through **Guru**, a bilingual AI assistant embedded on every page of the application. Guru is powered by the Groq Cloud API using the `llama-3.1-8b-instant` language model.

Guru satisfies the AI API implementation requirement specified in Assessment Brief 4:
> *"You need to design a more intelligent and efficient web-based system by adding OpenAI into your project."*

While the brief mentions OpenAI, Groq provides an OpenAI-compatible API with the same interface, making it a direct and superior alternative due to its completely free tier and faster response times.

---

## 2. Technology Details

| Item | Detail |
|------|--------|
| Provider | Groq Cloud (https://console.groq.com) |
| Model | llama-3.1-8b-instant |
| API Endpoint | https://api.groq.com/openai/v1/chat/completions |
| API Standard | OpenAI-compatible REST API |
| Cost | Free (within Groq free tier limits) |
| Response Time | ~200-500ms average |
| Max Tokens | 300 per response |

---

## 3. Features

| Feature | Description |
|---------|-------------|
| Article Summarisation | Reads the current page article and provides a concise summary |
| English to Nepali Translation | Translates any text into Devanagari Nepali script |
| Nepal & Australia Q&A | Answers questions about news, culture, and community |
| Bilingual Responses | Detects input language and responds in the same language |
| Context Awareness | Passes current article title and summary as context |
| Quick Prompts | One-click buttons for Summarise, Translate, Nepal News |
| Typing Animation | Three-dot animated indicator while AI is responding |
| Fallback Handling | Graceful error message if API is unavailable |

---

## 4. Implementation Files

```
app/Http/Controllers/GuruController.php      ← API call logic
resources/views/components/guru-chat.blade.php ← Chat UI widget
config/services.php                           ← API key configuration
routes/web.php                                ← POST /guru/chat route
.env                                          ← GROQ_API_KEY variable
```

---

## 5. Controller Code

```php
<?php
// app/Http/Controllers/GuruController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GuruController extends Controller
{
    /**
     * Handle Guru AI chat request
     * Sends user message to Groq API and returns AI response
     */
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500',
            'context' => 'nullable|string|max:1000',
        ]);

        $systemPrompt = "You are Guru, a friendly AI news assistant for 
        Nepal News Australia — a bilingual platform for the Nepali-Australian 
        community. Help users summarise articles, translate between English 
        and Nepali, and answer questions about Nepal and Australia. 
        Respond in the same language the user writes in.";

        $messages = [
            ['role' => 'system', 'content' => $systemPrompt],
        ];

        if ($request->context) {
            $messages[] = [
                'role' => 'system',
                'content' => 'Current page context: ' . $request->context
            ];
        }

        $messages[] = ['role' => 'user', 'content' => $request->message];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.groq.key'),
            'Content-Type'  => 'application/json',
        ])->post('https://api.groq.com/openai/v1/chat/completions', [
            'model'       => 'llama-3.1-8b-instant',
            'messages'    => $messages,
            'max_tokens'  => 300,
            'temperature' => 0.7,
        ]);

        if ($response->successful()) {
            return response()->json([
                'reply' => $response->json('choices.0.message.content')
            ]);
        }

        return response()->json([
            'reply' => 'Guru is taking a short break. Please try again! 🙏'
        ]);
    }
}
```

---

## 6. Route Configuration

```php
// routes/web.php
Route::post('/guru/chat', [GuruController::class, 'chat'])
     ->name('guru.chat');
```

---

## 7. Environment Configuration

```env
# .env
GROQ_API_KEY=your-groq-api-key-here
```

```php
// config/services.php
'groq' => [
    'key' => env('GROQ_API_KEY'),
],
```

---

## 8. How to Get a Groq API Key

1. Go to https://console.groq.com/keys
2. Sign up for a free account
3. Click **Create API Key**
4. Copy the key and add it to your `.env` file as `GROQ_API_KEY`
5. Add to Render.com dashboard under Environment Variables

---

## 9. Example Interactions

| User Input | Guru Response Type |
|-----------|-------------------|
| "Summarise this article" | Reads page context, returns 3-sentence summary |
| "Translate: Good morning" | Returns "शुभ प्रभात" in Nepali |
| "What is Dashain?" | Explains the festival with cultural context |
| "नमस्ते, तपाईंलाई कस्तो छ?" | Responds in Nepali |
| "Latest news from Nepal?" | Provides general knowledge response |

---

## 10. Comparison: Groq vs OpenAI

| Feature | Groq (Used) | OpenAI |
|---------|------------|--------|
| Free Tier | Yes — generous limits | Limited ($5 credit only) |
| API Compatibility | OpenAI-compatible | OpenAI native |
| Response Speed | ~200-500ms | ~500-2000ms |
| Model Used | llama-3.1-8b-instant | gpt-4o-mini |
| Cost for Demo | $0 | ~$0.01 per conversation |
| Integration Effort | Identical to OpenAI | Standard |

Groq was selected over OpenAI because it provides completely free access with no credit card required, faster response times, and an identical API interface requiring zero code changes to switch.
