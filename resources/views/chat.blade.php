@extends('layouts.main')

@section('page-title')
    PlantAI | Home
@endsection

@section('content')
    @include('layouts.nav')
<div class="container-fluid mt-3">
    <div class="row">
        <div class="col-2"></div>
        <div class="col-8">
            <div class="vstack gap-2">
                <div class="p-2">First item</div>
                <div class="p-2">Second item</div>
                <div class="p-2">Third item</div>
            </div>
        </div>
        <div class="col-2"></div>
    </div>
    <div class="fixed-bottom bg-light">
        <div class="row">
            <hr>
            <div class="col-2"></div>
            <div class="col-8">
                <div class="hstack gap-3  mb-3">
                    <textarea class="form-control" type="text" rows="1" placeholder="{{ __("Send a message") }}"></textarea>
                    <button type="submit" class="btn btn-secondary"><i class="far fa-paper-plane"></i></button>
                </div>
                <span class="mt-2">
                        <b>{{ __("Plant") }}</b><em>{{ __("AI") }}</em> {{ __("is designed to help farmers diagnose and manage plant diseases effectively") }}</p>
                    </span>
            </div>
            <div class="col-2"></div>
        </div>
    </div>
</div>
@endsection
