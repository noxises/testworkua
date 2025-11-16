<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShortUrl extends Model
{
    use HasFactory;

    protected $fillable = ['original_url', 'short_code', 'expires_at'];

    protected $dates = ['expires_at'];

    public function stats(): HasMany
    {
        return $this->hasMany(ShortUrlStat::class);
    }
}
