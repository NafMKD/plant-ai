@extends('layouts.main')

@section('page-title')
    PlantAI | Home
@endsection

@section('content')
    @include('layouts.nav')
<div class="container-fluid mt-3" style="margin-bottom: 140px;">
    <div class="row">
        <div class="col-2"></div>
        <div class="col-8">
            <div class="vstack gap-2" id="messageViewer">
                @if(count($chats) == 0)
                    <div class="text-center" style="margin-top: 30%;" id="noMessagesDiv">
                        <h1>{{ __("Welcome to") }} <b>{{ __("Plant") }}</b><em>{{ __("AI") }}</em></h1>
                        <p>{{ __("Ask me anything about plants") }} 😊</p>
                    </div>
                @endif
                @foreach($chats as $chat)
                <div class="direct-chat-msg right">
                    <div class="direct-chat-infos clearfix">
                        <span class="direct-chat-timestamp float-left">{{ $chat->formatted_time_created }}</span>
                    </div>
                    <img class="direct-chat-img" src="{{ asset("assets/user36.png") }}" alt="message user image">
                    <div class="direct-chat-text bg-gray-dark">
                        {{ $chat->message }}
                        @if($chat->image)
                        <div class="row">
                            <div class="col-2"></div>
                            <img src="{{ asset("uploads/images/" . $chat->image) }}" class=" col-8 img-fluid mt-3 mb-2">
                            <div class="col-2"></div>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="direct-chat-msg">
                    <div class="direct-chat-infos clearfix">
                        <span class="direct-chat-timestamp float-right">{{ $chat->formatted_time_updated }}</span>
                    </div>
                    <img class="direct-chat-img" src="{{ asset("assets/logo36.png") }}" alt="message user image">
                    <div class="direct-chat-text bg-gray-dark">
                        {!! $chat->response ?: '<p class="text-danger">No response</p>' !!}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="col-2"></div>
    </div>
    <div class="fixed-bottom bg-light">
        <div class="row">
            <hr>
            <div class="col-2"></div>
            <div class="col-8">
                <form method="POST" id="messageForm">
                    <div class="hstack gap-3  mb-3">
                        <textarea class="form-control" name="message" type="text" rows="1" placeholder="{{ __("Send a message") }}"></textarea>
                        <label id="labelImage" class="btn btn-secondary mt-2" for="image" data-bs-toggle="tooltip" data-bs-title="No file selected" data-bs-placement="top"><i class="fas fa-file-circle-plus"></i></label>
                        <input type="file" id="image" name="image" class="btn btn-secondary" accept="image/*" hidden>
                        <div class="vr"></div>
                        <button id="btnSubmit" type="submit" class="btn btn-secondary"><i class="far fa-paper-plane"></i></button>
                    </div>
                </form>
                <span class="mt-2">
                    <b>{{ __("Plant") }}</b><em>{{ __("AI") }}</em> {{ __("is designed to help farmers diagnose and manage plant diseases effectively") }}</p>
                </span>
            </div>
            <div class="col-2"></div>
        </div>
    </div>
</div>
@endsection
