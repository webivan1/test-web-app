<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Http\Requests\TransactionRequest;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function index(Client $client): View
    {
        return view('transaction.index', [
            'client' => $client,
            'models' => Transaction::getList($client->id)
        ]);
    }

    public function create(Client $client): View
    {
        return view('transaction.form', [
            'client' => $client,
            'transaction' => new Transaction(),
            'isNew' => true
        ]);
    }

    public function store(Client $client, TransactionRequest $request): RedirectResponse
    {
        $model = $client->transactions()
            ->create($request->only('amount', 'transaction_date'));

        if (!$model) {
            return back()->with('error', 'Error save a new transaction');
        }

        return redirect()->route('client.transaction.index', [
            'client' => $client->id
        ])->with('success', 'You have successfully created a new transaction');
    }

    public function edit(Client $client, Transaction $transaction): View
    {
        $transaction->isClient($client) ?: abort(404);

        return view('transaction.form', [
            'client' => $client,
            'transaction' => $transaction,
            'isNew' => false
        ]);
    }

    public function update(TransactionRequest $request, Client $client, Transaction $transaction): RedirectResponse
    {
        $transaction->isClient($client) ?: abort(404);

        if (!$transaction->update($request->only('amount', 'transaction_date'))) {
            return back()->with('error', 'Error update the transaction');
        }

        return redirect()->route('client.transaction.index', [
            'client' => $client->id
        ])->with('success', 'You have successfully updated the transaction #' . $transaction->id);
    }

    public function destroy(Client $client, Transaction $transaction): RedirectResponse
    {
        $transaction->isClient($client) ?: abort(404);

        $transaction->delete();

        return back()->with('success', 'You have successfully deleted the transaction');
    }
}
