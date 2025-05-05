<?php

namespace App\Observers;

use App\Models\CaptainReview;
use App\Models\Captain;

class CaptainReviewObserver
{
    public function created(CaptainReview $review)
    {
        $this->updateCaptainRating($review->captain_id);
    }

    public function deleted(CaptainReview $review)
    {
        $this->updateCaptainRating($review->captain_id);
    }
    
    protected function updateCaptainRating($captainId)
    {
        $captain = Captain::find($captainId);
        if ($captain) {
            $averageRating = CaptainReview::where('captain_id', $captain->id)->avg('rating');
            $captain->rating = $averageRating ? round($averageRating, 2) : null;
            $captain->save();
        }
    }
}
