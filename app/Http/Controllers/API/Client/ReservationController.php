<?php

namespace App\Http\Controllers\API\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Client\Reservation\ReserveCaptainRequest;
use App\Http\Resources\API\Client\CaptainsResource;
use App\Http\Resources\API\Client\ReviewsResource;
use App\Models\Captain;
use App\Models\CaptainAvailability;
use App\Models\Reservation;
use App\Traits\HttpResponses;

class ReservationController extends Controller
{
    use HttpResponses;

    //TODO number of completed reservations and ratings with reviews and make resources for availabilities

    public function captains()
    {
        $captains = Captain::where('is_subscribed', true)->get();
        return $this->successWithDataResponse(CaptainsResource::collection($captains));
    }

    public function captain($id)
    {
        $captain = Captain::find($id);
        if (!$captain) {
            return $this->failureResponse('لا يوجد كابتن بهذا المعرف');
        }
        return $this->successWithDataResponse($captain->load(['info']));
    }

    public function captainAvailabilities($id)
    {
        $captain = Captain::findOrFail($id);
        $captainAvailabilities = $captain->availabilities()->where('is_reserved', false)->get();
        return $this->successWithDataResponse($captainAvailabilities);
    }

    public function captainReviews($id)
    {
        $captain = Captain::findOrFail($id);
        $captainReviews = $captain->reviews()->get();
        return $this->successWithDataResponse(ReviewsResource::collection($captainReviews));
    }

    public function reserveCaptain(ReserveCaptainRequest $request)
    {
        try {
            $captain = CaptainAvailability::findOrFail($request->availability_id);
            Reservation::create($request->validated() + ['captain_id' => $captain->captain_id]);
            return $this->successResponse('تم الحجز بنجاح');
        } catch (\Exception $e) {
            return $this->failureResponse('حدث خطأ أثناء الحجز');
        }
    }
}
