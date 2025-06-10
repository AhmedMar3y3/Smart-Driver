<?php

namespace App\Http\Controllers\API\Client;

use App\Models\Join;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Admin\Join\JoinsResource;

class JoinController extends Controller
{
    use HttpResponses;

    // user endpoints
    public function join(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:joins,email',
        ]);
        Join::create($request->only('email'));
        return $this->successResponse('You have successfully joined our mailing list.');
    }

    // admin endpoints
    public function index()
    {
        $joins = Join::paginate(20);
        return $this->successWithDataResponse(JoinsResource::collection($joins));
    }
}
