<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    public $timestamps = false;
    protected $fillable = ['item_id','order_id','budget','due_date','delivered_on','delivered','quantity','user_id'];
    public function order(){
        return $this->belongsTo(Order::class);
    }
    public function item(){
        return $this->belongsTo(Item::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
