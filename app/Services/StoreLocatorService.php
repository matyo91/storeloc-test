<?php

namespace App\Services;

use App\Models\Store;
use Illuminate\Support\Facades\Cache;

class StoreLocatorService
{
    public function searchStores(array $bounds, array $serviceIds = [], string $operator = 'OR')
    {
        $cacheKey = $this->generateCacheKey($bounds, $serviceIds, $operator);

        return Cache::remember($cacheKey, 3600, function () use ($bounds, $serviceIds, $operator) {
            return Store::with('services')
                ->withinBounds($bounds['n'], $bounds['s'], $bounds['e'], $bounds['w'])
                ->withServices($serviceIds, $operator)
                ->get();
        });
    }

    public function getStore(int $storeId)
    {
        $cacheKey = "store_{$storeId}";

        return Cache::remember($cacheKey, 3600, function () use ($storeId) {
            return Store::with('services')->findOrFail($storeId);
        });
    }

    private function generateCacheKey(array $bounds, array $serviceIds, string $operator): string
    {
        $boundsString = implode('_', $bounds);
        $servicesString = implode('_', $serviceIds);

        return "stores_search_{$boundsString}_{$servicesString}_{$operator}";
    }
}
