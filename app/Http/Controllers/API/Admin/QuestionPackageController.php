<?php

namespace App\Http\Controllers\API\Admin;

use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Services\QuestionPackageService;
use App\Http\Resources\API\Admin\QuestionPackagesResource;
use App\Http\Requests\API\Admin\Exam\StoreQuestionPackageRequest;
use App\Http\Resources\API\Admin\DetailedQuestionPackagesResource;

class QuestionPackageController extends Controller
{
    use HttpResponses;
    protected $packageService;

    public function __construct(QuestionPackageService $packageService)
    {
        $this->packageService = $packageService;
    }

    public function index()
    {
        $packages = $this->packageService->getAllPackages();
        return $this->successWithDataResponse(QuestionPackagesResource::collection($packages));
    }

    public function show($id)
    {
        $package = $this->packageService->getPackageById($id);
        return $this->successWithDataResponse(new DetailedQuestionPackagesResource($package));
    }

    public function store(StoreQuestionPackageRequest $request)
    {
        $this->packageService->createPackage($request->validated());
        return $this->successResponse('تم إنشاء الحزمة بنجاح');
    }
    public function destroy($id)
    {
        $this->packageService->deletePackage($id);
        return $this->successResponse('تم حذف الحزمة بنجاح');
    }
}
