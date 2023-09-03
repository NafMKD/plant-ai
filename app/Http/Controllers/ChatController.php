<?php

namespace App\Http\Controllers;

use App\Http\Resources\ChatResource;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
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
     * @return ResponseFactory|Application|Response|\Illuminate\Foundation\Application|\ChatResource
     */
    public function store(Request $request): ResponseFactory|Application|Response|\Illuminate\Foundation\Application|\ChatResource
    {
        $request->validate([
            'message' => 'required|string',
            'image' => 'image|nullable'
        ]);

        $data = [
            'message' => $request->get('message')
        ];

        try {
            if($request->file('image')) {
                $file = $request->file('image');
                $file_name = time().'_'.str_replace(' ', '_', $file->getClientOriginalName());
                $destination = public_path('/uploads/images');
                $file->move($destination, $file_name);
                $data['image'] = $file_name;
            }

            $data = $request->user()->chats()->create($data);

            $gpt = $this->generativeAI($data['message']);

            $data->update([
                'response' => $gpt['choices'][0]['message']['content'],
                'response_metadata' => $gpt
            ]);

            if($data) return new ChatResource($data);

            return response([
                'message' => 'Failed to save chat!'
            ], 422);
        } catch (\Exception $e) {
            return response([
                'message' => 'Internal server error occurred!'
            ], 422);
        }



    }

    /**
     * Request GPT data
     *
     * @param string $message
     * @return \Illuminate\Http\Client\Response
     */
    public function generativeAI(string $message): \Illuminate\Http\Client\Response
    {
        // choices  0 message content
        // dd($response['choices'][0]['message']['content']);
        return Http::post("http://localhost:8001?message=$message");
    }
}
