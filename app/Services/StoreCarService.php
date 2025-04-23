<?php

namespace App\Services;

use App\Models\Car;
use App\Helpers\ImageUploadHelper;
use App\Traits\HttpResponses;
use Illuminate\Http\UploadedFile;
use Exception;

class StoreCarService
{
    use HttpResponses;

    /**
     * Create a new car along with its images.
     *
     * @param array $validatedData
     * @param array $files
     * @return \App\Models\Car
     * @throws \Exception
     */
    public function createCarWithImages(array $validatedData, array $files): Car
    {
        $client = Auth('client')->user();

        // if (!$client->isSubscriped && $client->cars()->count() >= 2) {
        //     throw new Exception('لا يمكنك اضافة سيارة جديدة, يجب عليك الاشتراك في باقة مميزة');
        // }

        $car = Car::create($validatedData + ['client_id' => $client->id]);

        $data = [];
        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                $uploadedImagePath = ImageUploadHelper::uploadImage($file, 'CarImage');
                $data[] = ['image' => $uploadedImagePath];
            }
        }

        if (!empty($data)) {
            $car->images()->createMany($data);
        }

        return $car;
    }
}