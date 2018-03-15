<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable=['name','mobile','address','delivered'];
    public function order_items(){
        return $this->hasMany(OrderItem::class);
    }
}
