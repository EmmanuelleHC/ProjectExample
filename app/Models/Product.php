<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'detail', 'price', 'stock', 'image', 'is_active'];

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class);
    }
}
