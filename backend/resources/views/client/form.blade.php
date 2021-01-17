@extends('layouts.dashboard')

@section('content')
    <div class="container pt-5">
        <h3 class="mb-4">
            {{ $isNew ? 'Create a client' : 'Update the client' }}
        </h3>

        @parent

        <form
            method="post"
            action="{{ $isNew ? route('client.store') : route('client.update', $client) }}"
            class="card"
            enctype="multipart/form-data"
        >
            @csrf
            @method($isNew ? 'POST' : 'PUT')

            <div class="card-body">
                <div class="form-group">
                    <label>First name *</label>
                    <input
                        type="text"
                        name="first_name"
                        value="{{ old('first_name', $client->first_name) }}"
                        class="form-control {{ $errors->has('first_name') ? 'is-invalid' : '' }}"
                    />
                    @if ($errors->has('first_name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('first_name') }}
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label>Last name *</label>
                    <input
                        type="text"
                        name="last_name"
                        value="{{ old('last_name', $client->last_name) }}"
                        class="form-control {{ $errors->has('last_name') ? 'is-invalid' : '' }}"
                    />
                    @if ($errors->has('last_name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('last_name') }}
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label>Email *</label>
                    <input
                        type="text"
                        name="email"
                        value="{{ old('email', $client->email) }}"
                        class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                    />
                    @if ($errors->has('email'))
                        <div class="invalid-feedback">
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label>Avatar *</label>

                    @if ($client->avatar)
                        <div class="mb-2">
                            <img
                                width="100"
                                class="img-thumbnail"
                                src="{{ $client->avatarUrl }}"
                            />
                        </div>
                    @endif

                    <input
                        type="file"
                        name="avatar"
                        class="form-control {{ $errors->has('avatar') ? 'is-invalid' : '' }}"
                    />
                    @if ($errors->has('avatar'))
                        <div class="invalid-feedback">
                            {{ $errors->first('avatar') }}
                        </div>
                    @endif
                </div>
            </div>
            <div class="card-footer text-right">
                <button class="btn btn-success">
                    {{ $isNew ? 'Create' : 'Update' }}
                </button>
            </div>
        </form>
    </div>
@endsection
