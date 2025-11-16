<?php

namespace Tests\Feature;

use App\Models\ShortUrl;
use App\Models\ShortUrlStat;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StatsViewTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_shows_stats_page()
    {
        $url = ShortUrl::factory()
                       ->create([
                           'short_code' => 'CODE777',
                       ]);

        ShortUrlStat::factory()
                    ->count(3)
                    ->create([
                        'short_url_id' => $url->id,
                    ]);

        $response = $this->get('/stats/CODE777');

        $response->assertStatus(200);
        $response->assertViewIs('stats');
        $response->assertViewHas('stats', function ($stats) {
            return $stats->count() === 3;
        });
    }

    /** @test */
    public function it_returns_404_for_unknown_code()
    {
        $response = $this->get('/stats/UNKNOWN');

        $response->assertStatus(404);
    }
}
