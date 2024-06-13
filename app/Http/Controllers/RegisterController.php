<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function create(){
        return view('auth.register');
    }


    public function store(Request $request){
        $validData = $request->validate([
            'name' => 'required|max:255',
            'email' => ['required','email','unique:users'],
            'password' => 'required|min:3|max:255'
        ]);

        User::create($validData);
        return redirect('login');
    }
}