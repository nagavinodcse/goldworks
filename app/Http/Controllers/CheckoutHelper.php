<?php
namespace App\Http\Controllers;
use App\Order;
use App\OrderItem;
use Carbon\Carbon;
use Validator;
trait CheckoutHelper
{
    public function show(){
        if($this->cart->count()<1){
            return redirect('/');
        }
        return view('checkout');
    }
    public function save(){
        $this->validate(request(),['name'=>'required|string|min:3','mobile'=>'required|digits:10']);
        $order = Order::create(['name'=>request('name'),'mobile'=>request('mobile'),'address'=>request('address')]);
        $this->addOrderItems($order->id);
    }
    public function addOrderItems($order){
        $order = Order::find($order);
        $cart = $this->cart->items();
        if(!empty($cart)):
        foreach ($cart as $item):
            $order->order_items()->create(['item_id'=>$item->id,
                'quantity'=>$item->quantity,
                'budget'=>$item->price,
                'due_date'=> !empty($item->due_date) ? Carbon::parse($item->due_date)->format('Y-m-d') : NULL,
            ]);
        endforeach;
        endif;
        $this->cart->clear();
        request()->session()->flash('success','Order Added Successfully..!');
//        return redirect('/');
    }
}