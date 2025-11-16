<?php

namespace App\Services\Url;

use App\Models\ShortUrl;
use App\Models\ShortUrlStat;

class UrlStatsService
{
    public function recordVisit(ShortUrl $url): void
    {
        ShortUrlStat::create([
            'short_url_id' => $url->id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    public function list(ShortUrl $url)
    {
        return $url->stats()
                   ->latest()
                   ->get();
    }
}
