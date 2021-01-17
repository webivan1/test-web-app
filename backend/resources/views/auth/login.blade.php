@extends('layouts.app')

@section('title', 'Login page')

@section('content')
    <div class="login-container container-fluid vue-init">
        <div class="row w-100 justify-content-center align-content-center">
            <div class="col-md-auto col-sm-12">
                <login-form
                    submit-url="{{ route('login') }}"
                    dashboard-url="{{ route('home') }}"
                ></login-form>
            </div>
        </div>
    </div>
@endsection
