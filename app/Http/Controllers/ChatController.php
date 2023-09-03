<?php

namespace App\Http\Controllers;

use App\Http\Resources\ChatResource;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
     * @return mixed
     */
    public function store(Request $request): mixed
    {
        $request->validate([
            'message' => 'required|string',
            'image' => 'image|nullable'
        ]);

        $data = [
            'message' => $request->get('message')
        ];

        try {
            return DB::transaction( function () use ($request, $data) {
                $prediction = null;
                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $file_name = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
                    $destination = public_path('/uploads/images');
                    $file->move($destination, $file_name);
                    $data['image'] = $file_name;
                    // get prediction
                    $prediction = Http::attach('image', file_get_contents(public_path('/uploads/images/' . $file_name)), 'image.jpg')
                        ->post('http://localhost:5000/predict', $request->all());

                }
                $data = $request->user()->chats()->create($data);

                if ($prediction !== null && $prediction !== "Unknown") {
                    $explode = explode('__', $prediction['predicted_class_label']);
                    $disease = str_replace('_', ' ', $explode[1]);
                    $message = $data['message'] . '\n';
                    $message .= "Tell me about {$disease} disease in {$explode[0]}";
                    $gpt = $this->generativeAI($message);
                } else {
                    $gpt = $this->generativeAI($data['message']);
                }

                $data->update([
                    'response' => $gpt['choices'][0]['message']['content'],
                    'response_metadata' => $gpt,
                    'disease' => $prediction['predicted_class_label'] ?? null,
                    'probability' => $prediction['probability'] ?? null
                ]);

                return new ChatResource($data);
            });
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
     * @return Response
     */
    public function generativeAI(string $message): Response
    {
        // choices  0 message content
        return Http::post("http://localhost:5000/gpt", [
            "message" => $message
        ]);
    }
}
