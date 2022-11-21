<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cart;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'address',
        'email',
        'note',
        'active',
        'user_id'
    ];

    public function carts()
    {
        return $this->hasMany(Cart::class,'customer_id','id');
    }

    public function scopeSearch($query)
    {
        if ($key = request()->input('key-search')) {
            $query = $query
                ->where('phone', 'like',  $key);
        }
        return $query;
    }
}
