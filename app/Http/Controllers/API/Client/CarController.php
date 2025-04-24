<?php

namespace App\Http\Controllers\API\Client;

use App\Models\Car;
use App\Enums\Status;
use App\Traits\HttpResponses;
use App\Services\StoreCarService;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\Client\Car\FilterCarsRequest;
use App\Http\Resources\API\Client\CarsResource;
use App\Http\Requests\API\Client\Car\StoreCarRequest;
use App\Http\Resources\API\Client\CarDetailsResource;
use App\Services\filterCarService;

class CarController extends Controller
{
    use HttpResponses;

    protected StoreCarService $carService;

    public function __construct(StoreCarService $carService)
    {
        $this->carService = $carService;
    }

    public function index(FilterCarsRequest $request)
    {
        $filters = $request->validated();
        $query = (new filterCarService)->getFilteredCarsQuery($filters);
        $cars = $query->get();
        $count = $cars->count();
        return response()->json([
            "key"=> "success",
            "msg"=> "تم بنجاح",
            'data' => CarsResource::collection($cars),
            'count' => $count
        ]);
    }

    public function show($id)
    {
        $car = Car::find($id);
        if (!$car || $car->status == Status::SOLD->value) {
            return $this->failureResponse('هذه السيارة غير موجودة او تم بيعها');
        }
        return $this->successWithDataResponse(new CarDetailsResource($car));
    }

    public function store(StoreCarRequest $request)
    {
        $validatedData = $request->validated();
        $files = $request->file('images');

        try {
            $this->carService->createCarWithImages($validatedData, $files);
            return $this->successResponse('تم اضافة السيارة بنجاح');
        } catch (\Exception $e) {
            return $this->failureResponse($e->getMessage());
        }
    }
}
