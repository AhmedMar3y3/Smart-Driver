<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Car;
use App\Traits\HttpResponses;
use App\Services\filterCarService;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\Client\CarsResource;
use App\Http\Resources\API\Client\CarDetailsResource;
use App\Http\Requests\API\Client\Car\FilterCarsRequest;


class CarController extends Controller
{
    use HttpResponses;
    public function index(FilterCarsRequest $request)
    {
        $filters = $request->validated();
        $query = (new filterCarService)->getFilteredCarsQuery($filters);
        $cars = $query->get();
        return $this->successWithDataResponse(CarsResource::collection($cars));
    }

    public function show($id)
    {
        $car = Car::find($id);
        if (!$car) {
            return $this->failureResponse('هذه السيارة غير موجودة');
        }
        return $this->successWithDataResponse(new CarDetailsResource($car));
    }
    public function destroy($id)
    {
        $car = Car::find($id);
        if (!$car) {
            return $this->failureResponse('هذه السيارة غير موجودة');
        }
        $car->delete();
        return $this->successResponse('تم حذف السيارة بنجاح');
    }
}
