<?php

namespace App\Http\Controllers\API\Client;

use App\Models\Captain;
use App\Models\Reservation;
use App\Traits\HttpResponses;
use App\Enums\SubscriptionStatus;
use App\Models\CaptainAvailability;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\Client\ReviewsResource;
use App\Http\Resources\API\Client\CaptainsResource;
use App\Http\Requests\API\Client\Reservation\ReserveCaptainRequest;

class ReservationController extends Controller
{
    use HttpResponses;

    public function captains()
    {
        $captains = Captain::whereHas('subscriptions', function ($query) {
            $query->where('status', SubscriptionStatus::ACTIVE->value);
        })->get();
        return $this->successWithDataResponse(CaptainsResource::collection($captains));
    }

    public function captain($id)
    {
        $captain = Captain::find($id);
        if (!$captain) {
            return $this->failureResponse('لا يوجد كابتن بهذا المعرف');
        }
        $captain->increment('views_count');
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
            Reservation::create($request->validated() + ['captain_id' => $captain->captain_id, 'client_id' => auth('client')->user()->id]);
            return $this->successResponse('تم الحجز بنجاح');
        } catch (\Exception $e) {
            return $this->failureResponse('حدث خطأ أثناء الحجز');
        }
    }
}
