<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
 protected $fillable = [
    'name',
    'username',         
    'email',
    'password',
    'role',
    'wallet_balance',   
    'is_admin', 
    'otp',
    'otp_expires_at',
    'delivery_status',

];



    public function carts()
{
    return $this->hasMany(Cart::class);
}

public function wishlists()
{
    return $this->hasMany(Wishlist::class);
}

public function orders()
{
    return $this->hasMany(Order::class, 'delivery_partner_id');
}


}
