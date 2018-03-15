<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    public function index(){
        $users = User::where('role','USER')->get();
        return view('users.index')->withUsers($users);
    }
    public function destroy(User $user)
    {
       $user->delete();
    }
}
