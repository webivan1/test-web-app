@extends('layouts.dashboard')

@section('content')
    <div class="container pt-5 pb-4">
        @parent

        @include('client.detail', compact('client'))

        <h3 class="mb-4">Transactions</h3>

        <div class="row justify-content-between mb-4">
            <div class="col-auto">
                Total {{ $models->total() }}
            </div>
            <div class="col-auto">
                <a class="btn btn-primary" href="{{ route('client.transaction.create', ['client' => $client->id]) }}">
                    Create
                </a>
            </div>
        </div>

        <table id="transactions" class="table table-bordered shadow bg-white">
            <thead>
                <tr>
                    <th>@sortablelink('id', 'Id')</th>
                    <th>Client</th>
                    <th>@sortablelink('amount', 'Amount')</th>
                    <th>@sortablelink('transaction_date', 'Transaction date')</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($models->items() as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->client->name }}</td>
                        <td>{{ $item->amount }}</td>
                        <td>{{ $item->transaction_date->format('d.m.Y H:i') }}</td>
                        <td>
                            <form
                                onsubmit="return confirm('Are you sure?')"
                                method="post"
                                action="{{ route('client.transaction.destroy', ['client' => $client->id, 'transaction' => $item->id]) }}"
                            >
                                @csrf
                                @method('DELETE')

                                <div class="btn-group">
                                    <a class="btn btn-sm btn-link" href="{{ route('client.transaction.edit', ['client' => $client->id, 'transaction' => $item->id]) }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="submit" class="btn btn-sm btn-link">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {!! $models->appends(\Request::except('page'))->links() !!}
    </div>
@endsection
