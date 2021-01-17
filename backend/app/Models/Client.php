<?php

namespace App\Models;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Expression;
use Illuminate\Http\UploadedFile;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Kyslik\ColumnSortable\Sortable;

/**
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $avatar
 * @property string $avatarUrl
 *
 * @property-read Transaction[]|Collection $transactions
 */
class Client extends Model
{
    use HasFactory, Notifiable, Sortable;

    /**
     * @var array
     */
    public $fillable = [
        'first_name',
        'last_name',
        'email',
        'avatar'
    ];

    public $sortable = [
        'id',
        'first_name',
        'email'
    ];

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'client_id');
    }

    public static function getList(array $params, int $pageSize = 10): LengthAwarePaginator
    {
        /** @var Builder $query */
        $query = self::query()->sortable([
            'created_at' => 'desc'
        ]);

        $query->select([
            '*',
            new Expression('CONCAT(first_name, " ", last_name) AS name')
        ]);

        empty($params['id']) ?: $query->whereId((int) $params['id']);
        empty($params['name']) ?: $query->having('name', 'like', "%{$params['name']}%");
        empty($params['email']) ?: $query->where('email', 'like', "%{$params['email']}%");

        return $query->paginate($pageSize);
    }

    public function getNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getAvatarUrlAttribute(): ?string
    {
        return $this->avatar ? Storage::url($this->avatar) : null;
    }
}
