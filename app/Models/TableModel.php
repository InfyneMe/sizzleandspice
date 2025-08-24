<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TableModel extends Model
{
    protected $table = 'tables';

    // Allow mass-assigning these attributes
    protected $fillable = [
        'number',
        'status',
        'qr_link',
        'notes',
        'capacity',
    ];

    // Cast types for correctness
    protected $casts = [
        'number'   => 'integer',
        'capacity' => 'integer',
    ];

    // Status constants
    public const STATUS_ACTIVE   = 'active';
    public const STATUS_INACTIVE = 'inactive';

    // Capacity options (optional helper; enforce via validation)
    public const CAPACITIES = [2, 3, 4, 5, 6];

    /*
     |----------------------------------------------------------------------
     | Scopes
     |----------------------------------------------------------------------
     */

    // Only active tables
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    // Only inactive tables
    public function scopeInactive($query)
    {
        return $query->where('status', self::STATUS_INACTIVE);
    }

    // Filter by exact capacity
    public function scopeCapacity($query, int $capacity)
    {
        return $query->where('capacity', $capacity);
    }

    // Filter by table number
    public function scopeNumber($query, int $number)
    {
        return $query->where('number', $number);
    }

    /*
     |----------------------------------------------------------------------
     | Accessors
     |----------------------------------------------------------------------
     */

    // Display-friendly status badge classes for Tailwind
    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_ACTIVE   => 'bg-green-100 text-green-700',
            self::STATUS_INACTIVE => 'bg-gray-100 text-gray-700',
            default               => 'bg-slate-100 text-slate-700',
        };
    }

    // Human readable status
    public function getStatusDisplayAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_ACTIVE   => 'Active',
            self::STATUS_INACTIVE => 'Inactive',
            default               => ucfirst((string) $this->status),
        };
    }

    // Label like "#12"
    public function getDisplayNumberAttribute(): string
    {
        return '#' . $this->number;
    }

    // Capacity with suffix (e.g., "4 seats")
    public function getCapacityDisplayAttribute(): string
    {
        return $this->capacity . ' seats';
    }

    /*
     |----------------------------------------------------------------------
     | Static helpers (useful for forms)
     |----------------------------------------------------------------------
     */

    public static function getStatusOptions(): array
    {
        return [
            self::STATUS_ACTIVE   => 'Active',
            self::STATUS_INACTIVE => 'Inactive',
        ];
    }

    public static function getCapacityOptions(): array
    {
        // If you want to strictly offer 2–6 as per your note:
        return array_combine(self::CAPACITIES, array_map(fn($c) => "{$c} seats", self::CAPACITIES));
    }
}
