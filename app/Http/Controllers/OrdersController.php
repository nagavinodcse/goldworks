<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;

class OrdersController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    public function index()
    {
        $user = auth()->user();
        $orders = $user->orders()->orderBy('id','desc')->with('item')->with('order')->get();
//        $orders = response()->json($orders);
        return view('orders.index',compact('orders'))->withUser($user);
    }
}
