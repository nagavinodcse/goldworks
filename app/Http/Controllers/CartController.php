<?php

namespace App\Http\Controllers;

use Anam\Phpcart\Cart;
use App\Item;
use Carbon\Carbon;
use Illuminate\Http\Request;
class CartController extends Controller
{
    protected $cart;
    public function __construct() {
        $this->cart = new Cart();
    }
    use CheckoutHelper;
    public function index(){
        return view('cart');
    }
    public function getCart(){
        $cart = $this->cart->items();
        $cart = $cart->each(function ($item){
            if($item->due_date) {
                $item->due_date = !empty($item->due_date) ? Carbon::parse($item->due_date)->format('d-m-Y') : null;
            }
        });
        return $cart;
    }
    public function addToCart(Item $item) {
        $this->cart->add([
            'id'=>$item->id,
            'name'=>$item->item_name,
            'quantity'=> 1,
            'price'=> 0,
            'due_date'=> null,
            'description'=>"",
            'item'=>$item
        ]);
        return json_encode($this->cart->get($item->id));
    }
    public function updateCart(){
        $item = request()->all();
        $changed = !empty($item['due_date']) ? Carbon::parse($item['due_date'])->toDateString() : null ;
        $this->cart->update([
            'id'=>$item['id'],
            'quantity'=>$item['quantity'],
            'price'=>$item['price'],
            'due_date'=>$changed
        ]);
    }
    public function delCartItem($item){
        $this->cart->remove($item);
    }
    public function emptyCart() {
        $this->cart->clear();
    }
}
