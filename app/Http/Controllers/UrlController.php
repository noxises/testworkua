<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUrlRequest;
use App\Models\ShortUrl;
use App\Services\Url\UrlRedirectService;
use App\Services\Url\UrlShortenerService;
use App\Services\Url\UrlStatsService;
use Illuminate\Routing\Controller;

class UrlController extends Controller
{
    public function __construct(
        private UrlShortenerService $shortener,
        private UrlRedirectService $redirectService,
        private UrlStatsService $statsService
    ) {
    }

    public function index()
    {
        $links = ShortUrl::query()
                         ->whereNull('expires_at')
                         ->orWhere('expires_at', '>', now())
                         ->latest()
                         ->get();

        return view('index', compact('links'));
    }

    public function store(StoreUrlRequest $request)
    {
        $short = $this->shortener->create(
            originalUrl: $request->input('url'),
            expiresIn: (int) $request->input('expires_in')
        );

        return redirect()
            ->back()
            ->with('short', url('/s/'.$short->short_code));
    }

    public function redirect($code)
    {
        $url = $this->redirectService->resolve($code);

        $this->statsService->recordVisit($url);

        return redirect()->away($url->original_url);
    }

    public function stats($code)
    {
        $url = ShortUrl::where('short_code', $code)
                       ->firstOrFail();

        $stats = $this->statsService->list($url);

        return view('stats', compact('url', 'stats'));
    }
}
