<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {

    }

    public function create()
    {
        return view('message.create', [
            'users' => User::get()
        ]);
    }

    public function store(MessageRequest $request)
    {

    }

}
