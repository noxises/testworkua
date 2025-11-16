<?php

namespace Database\Factories;

use App\Models\ShortUrl;
use App\Models\ShortUrlStat;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShortUrlStatFactory extends Factory
{
    protected $model = ShortUrlStat::class;

    public function definition()
    {
        return [
            'short_url_id' => ShortUrl::factory(),
            'ip_address' => $this->faker->ipv4(),
            'user_agent' => $this->faker->userAgent(),
        ];
    }
}
