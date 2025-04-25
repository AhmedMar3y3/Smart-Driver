<?php

namespace App\Http\Controllers\API\Client;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    use HttpResponses;
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:subscriptions,email',
        ]);

        Subscription::create([
            'email' => $request->email,
        ]);

        return $this->successResponse('تم الاشتراك بنجاح');
    }
}
