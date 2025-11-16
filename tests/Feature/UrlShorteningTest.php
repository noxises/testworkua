<?php

namespace Tests\Feature;

use App\Models\ShortUrl;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UrlShorteningTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_a_short_url()
    {
        $response = $this->post('/shorten', [
            'url' => 'https://google.com',
            'expires_in' => 10,
        ]);

        $response->assertRedirect();

        $this->assertDatabaseCount('short_urls', 1);

        $this->assertTrue(
            session()->has('short')
        );
    }

    /** @test */
    public function it_generates_unique_codes()
    {
        ShortUrl::factory()
                ->create(['short_code' => 'ABC12345']);

        $response = $this->post('/shorten', [
            'url' => 'https://google.com',
            'expires_in' => 10,
        ]);
        $response->assertRedirect();

        $newCode = ShortUrl::latest('id')
                           ->first()->short_code;

        $this->assertNotEquals('ABC12345', $newCode);
    }

    /** @test */
    public function it_allows_never_expiring_links()
    {
        $this->post('/shorten', [
            'url' => 'https://google.com',
            'expires_in' => null,
        ]);

        $short = ShortUrl::first();
        $this->assertNull($short->expires_at);
    }
}
