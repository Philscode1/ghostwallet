<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mail;
use App\Mail\RecommendationMail;

class Recommendation extends Model
{
    use HasFactory;

    public $fillable = ['name', 'email', 'asset_name', 'asset_symbol'];

    /**
     * Write code on Method
     *
     * @return response()
     */
    public static function boot() {
  
        parent::boot();
  
        static::created(function ($item) {
                
            $adminEmail = "service@ghostwallet.net";
            Mail::to($adminEmail)->send(new RecommendationMail($item));
        });
    }
}
