<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Admin\Exam\StoreQuestionPackageRequest;
use App\Services\QuestionPackageService;

class QuestionPackageController extends Controller
{
    protected $packageService;

    public function __construct(QuestionPackageService $packageService)
    {
        $this->packageService = $packageService;
    }

    public function store(StoreQuestionPackageRequest $request)
    {
        $package = $this->packageService->createPackage($request->validated());
        return response()->json(['message' => 'Package created successfully', 'data' => $package], 201);
    }
}