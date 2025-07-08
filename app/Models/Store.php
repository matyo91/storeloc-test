<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'lat',
        'lng',
        'address',
        'city',
        'zipcode',
        'country_code',
        'hours',
    ];

    protected $casts = [
        'hours' => 'array',
        'lat' => 'float',
        'lng' => 'float',
    ];

    public function services()
    {
        return $this->belongsToMany(Service::class);
    }

    public function isOpen(): bool
    {
        $now = Carbon::now();
        $dayOfWeek = $now->format('l'); // Monday, Tuesday, etc.

        if (!isset($this->hours[$dayOfWeek])) {
            return false;
        }

        $currentTime = $now->format('H:i');

        foreach ($this->hours[$dayOfWeek] as $timeSlot) {
            [$open, $close] = explode('-', $timeSlot);
            if ($currentTime >= $open && $currentTime <= $close) {
                return true;
            }
        }

        return false;
    }

    public function getFullAddressAttribute(): string
    {
        return "{$this->address}, {$this->zipcode} {$this->city}";
    }

    public function scopeWithinBounds($query, $north, $south, $east, $west)
    {
        return $query->whereBetween('lat', [$south, $north])
                    ->whereBetween('lng', [$west, $east]);
    }

    public function scopeWithServices($query, $serviceIds, $operator = 'OR')
    {
        if (empty($serviceIds)) {
            return $query;
        }

        if ($operator === 'AND') {
            foreach ($serviceIds as $serviceId) {
                $query->whereHas('services', function ($q) use ($serviceId) {
                    $q->where('services.id', $serviceId);
                });
            }
        } else {
            $query->whereHas('services', function ($q) use ($serviceIds) {
                $q->whereIn('services.id', $serviceIds);
            });
        }

        return $query;
    }
}
