<?php

namespace App\Http\Controllers\API\Client;

use Exception;
use App\Enums\Status;
use App\Models\Plate;
use App\Models\PlateCode;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Services\filterPlateService;
use App\Services\SubscriptionService;
use App\Http\Resources\API\Client\PlatesResource;
use App\Http\Resources\API\Client\PlateDetailsResource;
use App\Http\Requests\API\Client\Plate\StorePlateRequest;
use App\Http\Requests\API\Client\Plate\FilterPlateRequest;

class PlateController extends Controller
{
    use HttpResponses;

    protected $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    public function index(FilterPlateRequest $request)
    {
        $filters = $request->validated();
        $query = (new filterPlateService)->getFilteredPlatesQuery($filters);
        $plates = $query->get();
        return $this->successWithDataResponse(PlatesResource::collection($plates));
    }

    public function show($id)
    {
        $plate = Plate::find($id);

        if (!$plate || $plate->status == Status::SOLD->value) {
            return $this->failureResponse('اللوحة غير موجودة أو تم بيعها');
        }

        return $this->successWithDataResponse(new PlateDetailsResource($plate));
    }
    public function store(StorePlateRequest $request)
    {
        $client = Auth('client')->user();
        try {
            // if (!$this->subscriptionService->canPostPlateAd($client)) {
            //     return $this->failureResponse('تخطيت الحد الأقصي للأضافة');
            // }
            Plate::create($request->validated() + ['client_id' => $client->id]);
            return $this->successResponse('تم اضافة اللوحة بنجاح');
        } catch (Exception $e) {
            return $this->failureResponse('حدث خطأ أثناء إضافة اللوحة: ');
        }
    }

    public function getPlateCodes($emirate_id)
    {
        $codes = PlateCode::where('emirate_id', $emirate_id)->get();
        return $this->successWithDataResponse($codes->map(function ($code) {
            return ['id' => $code->id, 'code' => $code->code];
        }));
    }
}
