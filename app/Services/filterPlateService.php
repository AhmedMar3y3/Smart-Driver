<?php

namespace App\Services;

use App\Enums\Status;
use App\Models\Plate;

class filterPlateService
{

    public function getFilteredPlatesQuery(array $filters)
    {
        $query = Plate::where('status', Status::PENDING->value);

        // $query->when(isset($filters['price_from']), function ($q) use ($filters) {
        //     return $q->where('price', '>=', $filters['price_from']);
        // });

        // $query->when(isset($filters['price_to']), function ($q) use ($filters) {
        //     return $q->where('price', '<=', $filters['price_to']);
        // });

        $query->when(!empty($filters['emirate_id']), function ($q) use ($filters) {
            return $q->where('emirate_id', $filters['emirate_id']);
        });

        return $query;
    }
}
