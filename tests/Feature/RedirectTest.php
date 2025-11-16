<?php

namespace Tests\Feature;

use App\Models\ShortUrl;
use App\Models\ShortUrlStat;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class RedirectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_redirects_to_original_url()
    {
        $url = ShortUrl::factory()->create([
            'short_code' => 'ABC1234',
            'original_url' => 'https://laravel.com',
            'expires_at' => now()->addHour(),
        ]);

        $response = $this->get('/s/ABC1234');

        $response->assertRedirect('https://laravel.com');
    }

    /** @test */
    public function it_saves_redirect_stats()
    {
        $url = ShortUrl::factory()->create([
            'short_code' => 'CLICKME',
            'expires_at' => now()->addHour(),
        ]);

        $this->get('/s/CLICKME');

        $this->assertDatabaseCount('short_url_stats', 1);
    }

    /** @test */
    public function it_fails_if_link_expired()
    {
        $url = ShortUrl::factory()->create([
            'short_code' => 'OLD123',
            'expires_at' => now()->subMinute(),
        ]);

        $response = $this->get('/s/OLD123');

        $response->assertStatus(410);
    }
}
