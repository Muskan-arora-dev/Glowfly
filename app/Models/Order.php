<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_id',
        'awb_id',
        'name',
        'address',
        'city',
        'phone',
        'payment_method',
        'total',
        'status',
        'payment_id',
        'delivery_partner_id',
        'delivery_otp',
        'otp_verified',  
        'delivery_charge', 
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function deliveryPartner()
    {
        return $this->belongsTo(User::class, 'delivery_partner_id');
    }
}
