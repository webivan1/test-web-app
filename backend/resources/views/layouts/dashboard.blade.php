@extends('layouts.app')

@section('nav')
    @include('layouts.nav')
@endsection

@section('content')
    <div class="mt-3 mb-4">
        @include('layouts.messages')
    </div>
@endsection

@section('footer')
    <nav class="navbar">
        <div class="container">
            <ul class="navbar-nav mr-auto">

            </ul>
        </div>
    </nav>
@endsection
