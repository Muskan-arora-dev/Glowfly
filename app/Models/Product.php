<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
    'subcategory_id',
    'supplier_id',
    'name',
    'slug',
    'image',
    'price',
    'quantity',
    'status',
    'description'
];


    public function subcategory(){
        return $this->belongsTo(Subcategory::class);
    }

    public function wishlistedBy()
{
    return $this->belongsToMany(User::class, 'wishlists')->withTimestamps();
}

public function supplier()
{
    return $this->belongsTo(User::class, 'supplier_id');
}


}
