<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Kyslik\ColumnSortable\Sortable;

/**
 * @property int $id
 * @property int $client_id
 * @property Carbon $transaction_date
 * @property-read Client $client
 */
class Transaction extends Model
{
    use HasFactory, Sortable;

    /**
     * @var array
     */
    protected $fillable = [
        'client_id',
        'transaction_date',
        'amount'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'transaction_date' => 'datetime'
    ];

    public $sortable = [
        'id',
        'amount',
        'transaction_date'
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public static function getList(int $clientId, int $pageSize = 10): LengthAwarePaginator
    {
        return self::query()
            ->sortable([
                'transaction_date' => 'desc'
            ])
            ->where('client_id', $clientId)
            ->paginate($pageSize);
    }

    public function isClient(Client $client): bool
    {
        return (int) $client->id === (int) $this->client_id;
    }
}
