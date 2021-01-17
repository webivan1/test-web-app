<form
    method="get"
    action="{{ route('client.index') }}"
    class="row mb-4"
>
    @if (request('sort'))
        <input type="hidden" name="sort" value="{{ request('sort') }}" />
    @endif
    @if (request('direction'))
        <input type="hidden" name="direction" value="{{ request('direction') }}" />
    @endif

    <div class="col-md">
        <input type="text" name="id" placeholder="Id" class="form-control" value="{{ request('id', '') }}" />
    </div>
    <div class="col-md">
        <input type="text" name="name" placeholder="Name" class="form-control" value="{{ request('name', '') }}" />
    </div>
    <div class="col-md">
        <input type="text" name="email" placeholder="Email" class="form-control" value="{{ request('email', '') }}" />
    </div>
    <div class="col-auto">
        <div class="btn-group">
            <a href="{{ route('client.index', \Request::only('sort', 'direction')) }}" class="btn btn-danger">
                <i class="fas fa-sync"></i>
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>
</form>
