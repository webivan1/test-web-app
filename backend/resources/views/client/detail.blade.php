<div class="card mb-5">
    <div class="card-header">
        <a href="{{ route('client.index') }}">
            <b>Client list</b>
        </a>
    </div>
    <form method="post" onsubmit="return confirm('Are you sure?')" class="card-footer text-right" action="{{ route('client.destroy', $client) }}">
        @csrf
        @method('DELETE')

        <a href="{{ route('client.edit', $client) }}" class="btn btn-primary">Edit</a>
        <button type="submit" class="btn btn-danger">Delete</button>
    </form>
    <div class="list-group">
        <div class="list-group-item">
            Id: <b>{{ $client->id }}</b>
        </div>
        <div class="list-group-item">
            Name: <b>{{ $client->name }}</b>
        </div>
        <div class="list-group-item">
            Email: <b>{{ $client->email }}</b>
        </div>
    </div>
</div>
