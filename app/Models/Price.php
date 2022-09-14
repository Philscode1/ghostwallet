<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;

    protected $fillable = ['price','price_24h', 'price_7d', 'price_30d'];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}
