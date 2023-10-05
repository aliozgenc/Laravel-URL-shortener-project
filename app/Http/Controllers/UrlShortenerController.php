<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UrlMapping;

class UrlShortenerController extends Controller
{

    public function index()
    {
        $latestUrls = UrlMapping::latest()->take(3)->get();
        return view('index', compact('latestUrls'));
    }


    public function shorten(Request $request)
    {
        $request->validate([
            'url' => 'required|url',
        ]);

        try {
            $shortUrl = $this->generateShortUrl();
        } catch (\Exception $e) {
            return view('shortage_error', ['error' => $e->getMessage()]);
        }

        $originalUrl = $request->input('url');

        UrlMapping::create([
            'short_url' => $shortUrl,
            'original_url' => $originalUrl,
        ]);

        return view('shortened', compact('shortUrl'));
    }

    public function redirect($shortUrl)
    {
        $urlMapping = UrlMapping::where('short_url', $shortUrl)->first();

        if (!$urlMapping) {
            return view('url_not_found');
        }

        return redirect($urlMapping->original_url);
    }

    private function generateShortUrl()
    {
        $colors = ['red', 'green', 'blue', 'yellow', 'purple', 'orange', 'pink'];
        $adjectives = ['calm', 'clever', 'energetic', 'friendly', 'happy', 'mysterious'];
        $nouns = ['car', 'desk', 'koala', 'tv', 'panda', 'penguin', 'dragon'];

        $maxAttempts = 10;

        do {
            $color = $colors[array_rand($colors)];
            $adjective = $adjectives[array_rand($adjectives)];
            $noun = $nouns[array_rand($nouns)];

            $shortUrl = $color . '-' . $adjective . '-' . $noun;

            // Short URL duplicate check
            $existing = UrlMapping::where('short_url', $shortUrl)->first();
            $maxAttempts--;
        } while ($existing && $maxAttempts > 0);

        if ($maxAttempts <= 0) {
            throw new \Exception();
        }

        return $shortUrl;
    }
}
