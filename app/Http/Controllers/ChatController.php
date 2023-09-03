<?php

namespace App\Http\Controllers;

use App\Http\Resources\ChatResource;
use App\Models\Chat;
use App\Models\User;
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
        return view('chat', ['chats' => auth()->user()->chats]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'image' => 'image|nullable'
        ]);

        $data = [
            'message' => $request->get('message')
        ];

        if($request->file('image')) {
            $file = $request->file('image');
            $file_name = time().'_'.str_replace(' ', '_', $file->getClientOriginalName());
            $destination = public_path('/uploads/images');
            $file->move($destination, $file_name);
            $data['image'] = $file_name;
        }

        $data = $request->user()->chats()->create($data);
        if($data) return new ChatResource($data);

        return response([
            'message' => 'Failed to save chat!'
        ], 422);
    }
}
