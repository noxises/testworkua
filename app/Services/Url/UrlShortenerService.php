<?php

namespace App\Services\Url;

use App\Models\ShortUrl;
use Illuminate\Support\Str;

class UrlShortenerService
{
    public function generateCode(): string
    {
        do {
            $code = Str::random(7);
        } while (ShortUrl::where('short_code', $code)
                         ->exists());

        return $code;
    }

    public function create(string $originalUrl, ?int $expiresIn = null): ShortUrl
    {
        return ShortUrl::create([
            'original_url' => $originalUrl,
            'short_code' => $this->generateCode(),
            'expires_at' => $expiresIn ? now()->addMinutes($expiresIn) : null,
        ]);
    }
}
