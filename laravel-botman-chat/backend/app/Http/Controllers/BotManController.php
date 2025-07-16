<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faq;
use App\Models\Question;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BotManController extends Controller
{
    /**
     * Main chatbot handler
     */
   
    public function handle(Request $request)
{
    $text = trim(strtolower($request->input('message', '')));
    $language = $request->input('language', 'en');

    // Basic keyword match for quick language test
    $isSwahili = fn($str) => preg_match('/\b(habari|msaada|tafadhali|kwaheri|karibu|nisaidie|nimesahau|akaunti|agizo)\b/i', $str);
    $isEnglish = fn($str) => preg_match('/\b(hi|hello|help|please|goodbye|reset|password|account|order)\b/i', $str);

    // BLOCK if language does not match input
    if (
        ($language === 'sw' && $isEnglish($text)) ||
        ($language === 'en' && $isSwahili($text))
    ) {
        return response()->json([
            'messages' => [[
                'type' => 'text',
                'text' => $language === 'sw'
                    ? "Samahani, tafadhali tumia Kiswahili kwa mazungumzo haya."
                    : "Sorry, please use English for this conversation."
            ]]
        ]);
    }

    // STEP 1: Match FAQ in correct language
    $faq = Faq::where('language', $language)
              ->where('question', 'LIKE', '%' . $text . '%')
              ->first();

    if ($faq) {
        return response()->json([
            'messages' => [[
                'type' => 'text',
                'text' => $faq->answer
            ]]
        ]);
    }

    // STEP 2: Keyword matching in FAQ (same language only)
    $keywords = array_filter(explode(' ', $text), fn($w) => strlen($w) > 2);
    $faqMatch = null;
    $maxScore = 0;

    foreach (Faq::where('language', $language)->get() as $f) {
        $score = collect($keywords)->filter(fn($k) => stripos($f->question, $k) !== false)->count();
        if ($score > $maxScore) {
            $maxScore = $score;
            $faqMatch = $f;
        }
    }

    if ($faqMatch && $maxScore > 0) {
        return response()->json([
            'messages' => [['type' => 'text', 'text' => $faqMatch->answer]]
        ]);
    }

    // STEP 3: Fallback message in selected language
    $fallback = $language === 'sw'
        ? "Samahani, sikuweza kuelewa swali lako. Tafadhali jaribu tena kwa maneno tofauti."
        : "I'm sorry, I couldn't understand your question. Could you try rephrasing it?";

    return response()->json([
        'messages' => [['type' => 'text', 'text' => $fallback]]
    ]);
}


    /**
     * Autocomplete suggestions for React frontend
     */
    public function autocomplete(Request $request)
    {
        $query = strtolower($request->query('query', ''));
        $language = $request->query('language', 'en');

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        // Autocomplete from FAQs by language
        $direct = Faq::where('language', $language)
            ->where('question', 'LIKE', '%' . $query . '%')
            ->limit(5)
            ->pluck('question')
            ->toArray();

        return response()->json($direct);
    }

    /**
     * Autocorrect individual word suggestions
     */
    public function correct(Request $request)
    {
        $input = strtolower($request->input('text', ''));
        $language = $request->input('language', 'en');

        if (strlen($input) < 2) {
            return response()->json(['suggestions' => []]);
        }

        // Gather words only from FAQs of selected language
        $faqWords = Faq::where('language', $language)
            ->pluck('question')
            ->flatMap(fn($q) => preg_split('/\s+/', strtolower($q)));

        $allWords = $faqWords
            ->map(fn($w) => preg_replace('/[^a-z]/', '', $w))
            ->filter(fn($w) => strlen($w) > 1)
            ->unique()
            ->values()
            ->all();

        $distances = [];
        foreach ($allWords as $word) {
            $distances[$word] = levenshtein($input, $word);
        }

        asort($distances);
        $suggestions = array_keys(array_slice($distances, 0, 3, true));

        return response()->json(['suggestions' => $suggestions]);
    }

    /**
     * Generate custom .dic file (for Typo.js)
     */
    public function generateCustomDic()
    {
        $faqWords = Faq::pluck('question')->implode(' ');
        $questionWords = Question::pluck('question')->implode(' ');
        $allText = strtolower($faqWords . ' ' . $questionWords);

        $words = array_unique(preg_split('/[\s\W]+/', $allText, -1, PREG_SPLIT_NO_EMPTY));
        $validWords = array_filter($words, fn($w) => strlen($w) > 1 && ctype_alpha($w));

        $dicContent = count($validWords) . "\n" . implode("\n", $validWords);

        return response($dicContent, 200)->header('Content-Type', 'text/plain');
    }

    /**
     * Generate custom .aff file (for Typo.js)
     */
    public function generateCustomAff()
    {
        $affContent = <<<AFF
SET UTF-8
TRY esianrtolcdugmphbyfvkwzxjq
AFF;

        return response($affContent, 200)->header('Content-Type', 'text/plain');
    }
}
