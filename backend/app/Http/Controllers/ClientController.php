<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Http\Requests\ClientFilterRequest;
use App\Http\Requests\ClientRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    public function index(ClientFilterRequest $request): View
    {
        return view('client.index', [
            'models' => Client::getList($request->all())
        ]);
    }

    public function create(): View
    {
        return view('client.form', [
            'client' => new Client(),
            'isNew' => true
        ]);
    }

    public function store(ClientRequest $request): RedirectResponse
    {
        $avatar = Client::saveAvatar($request->file('avatar'));

        $client = new Client(
            array_merge($request->only('first_name', 'last_name', 'email'), compact('avatar'))
        );

        if (!$client->save()) {
            return back()->with('error', 'Error create a new client');
        }

        return redirect()->route('client.transaction.index', [
            'client' => $client->id
        ])->with('success', 'You have successfully created the new client');
    }

    public function edit(Client $client): View
    {
        return view('client.form', [
            'client' => $client,
            'isNew' => false
        ]);
    }

    public function update(ClientRequest $request, Client $client): RedirectResponse
    {
        $avatar = Client::saveAvatar($request->file('avatar'));

        $attrs = array_filter(
            array_merge($request->only('first_name', 'last_name', 'email'), compact('avatar'))
        );

        if (!$client->update($attrs)) {
            return back()->with('error', 'Error update the client');
        }

        return redirect()->route('client.transaction.index', [
            'client' => $client->id
        ])->with('success', 'You have successfully updated the client');
    }

    public function destroy(Client $client): RedirectResponse
    {
        Storage::delete($client->avatarUrl);

        $client->delete();

        return redirect()->route('client.index')
            ->with('success', 'You have successfully deleted the client');
    }
}
