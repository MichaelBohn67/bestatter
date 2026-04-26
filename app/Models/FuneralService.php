<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class FuneralService extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'deceased_id',
        'customer_id',
        'graveyard_id',
        'chapel_id',
        'order_number',
        'status',
        'funeral_type',
        'funeral_date',
        'funeral_location',
        'notes',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'funeral_date' => 'date',
            'deleted_at' => 'datetime',
        ];
    }

    public function deceased(): BelongsTo
    {
        return $this->belongsTo(Deceased::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function graveyard(): BelongsTo
    {
        return $this->belongsTo(Graveyard::class);
    }

    public function chapel(): BelongsTo
    {
        return $this->belongsTo(Chapel::class);
    }

    public function billing(): HasOne
    {
        return $this->hasOne(Billing::class);
    }
}
