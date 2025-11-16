<?php

namespace App\Services\Url;

use App\Models\ShortUrl;

class UrlRedirectService
{
    public function resolve(string $code): ShortUrl
    {
        $url = ShortUrl::where('short_code', $code)->firstOrFail();

        if ($url->expires_at && now()->greaterThan($url->expires_at)) {
            abort(410, 'Link expired');
        }

        return $url;
    }
}
