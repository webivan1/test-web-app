@extends('layouts.dashboard')

@section('content')
    <div class="container pt-5 pb-4">
        <h3 class="mb-4">Clients</h3>

        @parent

        <div class="row justify-content-between mb-4">
            <div class="col-auto">
                Total {{ $models->total() }}
            </div>
            <div class="col-auto">
                <a href="{{ route('client.create') }}" class="btn btn-success">
                    Add item
                </a>
            </div>
        </div>

        @include('client.filter')

        <table class="table table-bordered shadow bg-white">
            <thead>
                <tr>
                    <th>@sortablelink('id', 'Id')</th>
                    <th>Avatar</th>
                    <th></th>
                    <th>@sortablelink('first_name', 'Name')</th>
                    <th>@sortablelink('email', 'Email')</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($models->items() as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>
                            @if ($item->avatarUrl)
                                <img
                                    width="80"
                                    class="img-fluid"
                                    src="{{ $item->avatarUrl }}"
                                />
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('client.transaction.index', ['client' => $item->id]) }}#transactions">
                                See transactions ({{ $item->transactions->count() }})
                            </a>
                        </td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->email }}</td>
                        <td>
                            <form onsubmit="return confirm('Are you sure?')" method="post" action="{{ route('client.destroy', $item) }}">
                                @csrf
                                @method('DELETE')

                                <div class="btn-group">
                                    <a class="btn btn-sm btn-link" href="{{ route('client.edit', $item) }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a class="btn btn-sm btn-link" href="{{ route('client.transaction.index', ['client' => $item->id]) }}">
                                        <i class="fas fa-eye"></i>
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
