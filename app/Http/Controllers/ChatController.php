<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class ChatController extends Controller
{
    /**
     * show home page
     *
     * @return View
     */
    public function index(): View
    {
        return view('chat', ['chats' => auth()->user()->chats()]);
    }
}
