<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShortUrlStat extends Model
{
    use HasFactory;

    protected $fillable = ['short_url_id', 'ip_address', 'user_agent'];

    public function url()
    {
        return $this->belongsTo(ShortUrl::class, 'short_url_id');
    }
}
