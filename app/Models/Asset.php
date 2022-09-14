<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $fillable = [
        'amount',
        'user_id',
        'asset_id',
    ];

    use HasFactory;

    /**
     * > The users() function returns a collection of all the users that belong to the current role
     * 
     * @return A collection of users.
     */
    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot(['amount']);
    }
    
    /**
     * > The `prices()` function returns a collection of `Price` objects that are associated with the
     * `Product` object
     * 
     * @return A collection of Price objects
     */
    public function prices()
    {
        return $this->hasMany(Price::class);
    }


}

