<?php

namespace App\Models;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'priority',
        'status',
    ];

    protected $casts = [
        'status' => TicketStatus::class,
        'priority' => TicketPriority::class,
    ];

    /**
     * Scope to get the tickets that were created after a date
     *
     * @param Builder $query
     * @param string $date
     * @return Builder
     */
    public function scopeSubmittedFrom(Builder $query, string $date)
    {
        return $query->whereDate('created_at', '>=', $date);
    }

    /**
     * Scope to get the tickets that were created before a date
     *
     * @param Builder $query
     * @param string $date
     * @return Builder
     */
    public function scopeSubmittedTo(Builder $query, string $date)
    {
        return $query->whereDate('created_at', '<=', $date);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function responses(): HasMany
    {
        return $this->hasMany(Response::class);
    }
}
