<?php

namespace App\Http\Controllers\API\Client;

use App\Models\Car;
use App\Enums\Status;
use App\Traits\HttpResponses;
use App\Services\StoreCarService;
use App\Services\filterCarService;
use App\Http\Controllers\Controller;
use App\Services\SubscriptionService;
use App\Http\Resources\API\Client\CarsResource;
use App\Http\Requests\API\Client\Car\StoreCarRequest;
use App\Http\Resources\API\Client\CarDetailsResource;
use App\Http\Requests\API\Client\Car\FilterCarsRequest;

class CarController extends Controller
{
    use HttpResponses;

    protected StoreCarService $carService;
    protected SubscriptionService $subscriptionService;

    public function __construct(StoreCarService $carService, SubscriptionService $subscriptionService)
    {
        $this->carService = $carService;
        $this->subscriptionService = $subscriptionService;
    }

    public function index(FilterCarsRequest $request)
    {
        $filters = $request->validated();
        $query = (new filterCarService)->getFilteredCarsQuery($filters);
        $cars = $query->active()->get();
        $count = $cars->count();
        return response()->json([
            "key" => "success",
            "msg" => "تم بنجاح",
            'data' => CarsResource::collection($cars),
            'count' => $count
        ]);
    }

    public function show($id)
    {
        $car = Car::find($id);
        if (!$car || $car->status == Status::SOLD->value || $car->expiry_status == 'expired') {
            return $this->failureResponse('هذه السيارة غير موجودة او تم بيعها');
        }
        return $this->successWithDataResponse(new CarDetailsResource($car));
    }

    public function store(StoreCarRequest $request)
    {
        $postInfo = $this->subscriptionService->canPostCarAd(auth('client')->user());
        if (!$postInfo['can_post']) {
            return $this->failureResponse('تخطيت الحد الأقصي للأضافة');
        }

        $validatedData = $request->validated();
        $files = $request->file('images');

        try {
            $this->carService->createCarWithImages($validatedData, $files, $postInfo['expires_in_days']);
            return $this->successResponse('تم اضافة السيارة بنجاح');
        } catch (\Exception $e) {
            return $this->failureResponse('حدث خطأ أثناء إضافة السيارة: ' . $e->getMessage());
        }
    }

    public function relatedCars($brandId)
    {
        $cars = Car::where('brand_id', $brandId)
            ->where('status', Status::PENDING->value)
            ->latest()
            ->take(6)
            ->get();

        if ($cars->isEmpty()) {
            return $this->successResponse('لا توجد سيارات متاحة لهذا الماركة');
        }

        return $this->successWithDataResponse(CarsResource::collection($cars));
    }
}
