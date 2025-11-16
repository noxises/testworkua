<?php

namespace Database\Factories;

use App\Models\ShortUrl;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShortUrlFactory extends Factory
{
    protected $model = ShortUrl::class;

    public function definition()
    {
        return [
            'original_url' => $this->faker->url(),
            'short_code' => strtoupper($this->faker->lexify('??????')),
            'expires_at' => now()->addHour(),
        ];
    }
}
