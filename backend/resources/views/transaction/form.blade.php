@extends('layouts.dashboard')

@section('content')
    <div class="container pt-5">
        @parent

        @include('client.detail', compact('client'))

        <h3 class="mb-4">
            {{ $isNew ? 'Create a transaction' : 'Update the transaction' }}
        </h3>

        <form
            method="post"
            action="{{ $isNew ? route('client.transaction.store', ['client' => $client->id]) : route('client.transaction.update', ['client' => $client->id, 'transaction' => $transaction->id]) }}"
            class="card"
            enctype="multipart/form-data"
        >
            @csrf
            @method($isNew ? 'POST' : 'PUT')

            <div class="card-body">
                <div class="form-group">
                    <label>Amount *</label>
                    <input
                        type="text"
                        name="amount"
                        value="{{ old('amount', $transaction->amount) }}"
                        class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}"
                    />
                    @if ($errors->has('amount'))
                        <div class="invalid-feedback">
                            {{ $errors->first('amount') }}
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label>Transaction date *</label>
                    <input
                        type="date"
                        name="transaction_date"
                        value="{{ old('transaction_date', $transaction->transaction_date ? $transaction->transaction_date->format('Y-m-d') : '') }}"
                        class="form-control {{ $errors->has('transaction_date') ? 'is-invalid' : '' }}"
                        max="{{ now()->format('Y-m-d') }}"
                    />
                    @if ($errors->has('transaction_date'))
                        <div class="invalid-feedback">
                            {{ $errors->first('transaction_date') }}
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
