<?php

namespace App\Http\Controllers\API\Captain;

use App\Traits\HttpResponses;
use App\Enums\ReservationStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\Captain\ReservationsResource;

class ReservationController extends Controller
{
    use HttpResponses;

    public function pendingReservations()
    {
        $reservations = auth('captain')->user()->reservations()->where('status', ReservationStatus::PENDING->value)->paginate(9);
        return $this->successWithDataResponse(ReservationsResource::collection($reservations));
    }

    public function acceptedReservations()
    {
        $reservations = auth('captain')->user()->reservations()->where('status', ReservationStatus::CONFIRMED->value)->paginate(9);
        return $this->successWithDataResponse(ReservationsResource::collection($reservations));
    }

    public function rejectedReservations()
    {
        $reservations = auth('captain')->user()->reservations()->where('status', ReservationStatus::CANCELLED->value)->paginate(9);
        return $this->successWithDataResponse(ReservationsResource::collection($reservations));
    }

    public function completedReservations()
    {
        $reservations = auth('captain')->user()->reservations()->where('status', ReservationStatus::COMPLETED->value)->paginate(9);
        return $this->successWithDataResponse(ReservationsResource::collection($reservations));
    }

    public function approveReservation($id)
    {
        $reservation = auth('captain')->user()->reservations()->find($id);
        if(!$reservation) {
            return $this->failureResponse('لم يتم العثور على الحجز');
        }
        $reservation->update(['status' => ReservationStatus::CONFIRMED->value]);
        return $this->successResponse('تم قبول الحجز بنجاح');
    }

    public function rejectReservation($id)
    {
        $reservation = auth('captain')->user()->reservations()->find($id);
        if(!$reservation) {
            return $this->failureResponse('لم يتم العثور على الحجز');
        }
        $reservation->update(['status' => ReservationStatus::CANCELLED->value]);
        return $this->successResponse('تم رفض الحجز بنجاح');
    }

    public function completeReservation($id)
    {
        $reservation = auth('captain')->user()->reservations()->findOrFail($id);
        if(!$reservation) {
            return $this->failureResponse('لم يتم العثور على الحجز');
        }
        $reservation->update(['status' => ReservationStatus::COMPLETED->value]);
        return $this->successResponse('تم إكمال الحجز بنجاح');
    }
}
