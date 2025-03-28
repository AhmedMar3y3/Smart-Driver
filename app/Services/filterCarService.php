<?php

namespace App\Services;

use App\Enums\Status;
use App\Models\Car;

class filterCarService
{

    public function getFilteredCarsQuery(array $filters)
    {
        $query = Car::where('status', Status::PENDING->value);

        $query->when(isset($filters['price_from']), function ($q) use ($filters) {
            return $q->where('price', '>=', $filters['price_from']);
        });

        $query->when(isset($filters['price_to']), function ($q) use ($filters) {
            return $q->where('price', '<=', $filters['price_to']);
        });

        $query->when(isset($filters['brand_id']), function ($q) use ($filters) {
            return $q->where('brand_id', $filters['brand_id']);
        });

        $query->when(isset($filters['year_from']), function ($q) use ($filters) {
            return $q->where('year', '>=', $filters['year_from']);
        });

        $query->when(isset($filters['year_to']), function ($q) use ($filters) {
            return $q->where('year', '<=', $filters['year_to']);
        });

        $query->when(isset($filters['type']), function ($q) use ($filters) {
            return $q->where('type', $filters['type']);
        });

        return $query;
    }
}