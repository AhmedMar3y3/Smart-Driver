<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        $carPackages = [
            [
                'type' => 'car',
                'price' => 50.00,
                'ad_duration' => 30,
                'allowed_ads_per_month' => 5,
                'title_en' => 'Basic Car Package',
                'title_ar' => 'باقة السيارات الأساسية',
                'title_ur' => 'بنیادی کار پیکیج',
                'description_en' => 'Post up to 5 car ads per month for 30 days each.',
                'description_ar' => 'انشر ما يصل إلى 5 إعلانات سيارات شهريًا لمدة 30 يومًا لكل إعلان.',
                'description_ur' => 'ہر ماہ 5 کار اشتہارات 30 دن کے لئے پوسٹ کریں۔',
            ],
            [
                'type' => 'car',
                'price' => 100.00,
                'ad_duration' => 45,
                'allowed_ads_per_month' => 10,
                'title_en' => 'Standard Car Package',
                'title_ar' => 'باقة السيارات القياسية',
                'title_ur' => 'معیاری کار پیکیج',
                'description_en' => 'Post up to 10 car ads per month for 45 days each.',
                'description_ar' => 'انشر ما يصل إلى 10 إعلانات سيارات شهريًا لمدة 45 يومًا لكل إعلان.',
                'description_ur' => 'ہر ماہ 10 کار اشتہارات 45 دن کے لئے پوسٹ کریں۔',
            ],
            [
                'type' => 'car',
                'price' => 200.00,
                'ad_duration' => 60,
                'allowed_ads_per_month' => 20,
                'title_en' => 'Premium Car Package',
                'title_ar' => 'باقة السيارات المميزة',
                'title_ur' => 'پریمیم کار پیکیج',
                'description_en' => 'Post up to 20 car ads per month for 60 days each.',
                'description_ar' => 'انشر ما يصل إلى 20 إعلان سيارة شهريًا لمدة 60 يومًا لكل إعلان.',
                'description_ur' => 'ہر ماہ 20 کار اشتہارات 60 دن کے لئے پوسٹ کریں۔',
            ],
            [
                'type' => 'car',
                'price' => 75.00,
                'ad_duration' => 30,
                'allowed_ads_per_month' => 8,
                'title_en' => 'Economy Car Package',
                'title_ar' => 'باقة السيارات الاقتصادية',
                'title_ur' => 'اقتصادی کار پیکیج',
                'description_en' => 'Post up to 8 car ads per month for 30 days each.',
                'description_ar' => 'انشر ما يصل إلى 8 إعلانات سيارات شهريًا لمدة 30 يومًا لكل إعلان.',
                'description_ur' => 'ہر ماہ 8 کار اشتہارات 30 دن کے لئے پوسٹ کریں۔',
            ],
            [
                'type' => 'car',
                'price' => 150.00,
                'ad_duration' => 45,
                'allowed_ads_per_month' => 15,
                'title_en' => 'Advanced Car Package',
                'title_ar' => 'باقة السيارات المتقدمة',
                'title_ur' => 'ایڈوانسڈ کار پیکیج',
                'description_en' => 'Post up to 15 car ads per month for 45 days each.',
                'description_ar' => 'انشر ما يصل إلى 15 إعلان سيارة شهريًا لمدة 45 يومًا لكل إعلان.',
                'description_ur' => 'ہر ماہ 15 کار اشتہارات 45 دن کے لئے پوسٹ کریں۔',
            ],
        ];

        $platePackages = [
            [
                'type' => 'plate',
                'price' => 30.00,
                'duration' => 30,
                'allowed_ads' => 3,
                'title_en' => 'Basic Plate Package',
                'title_ar' => 'باقة اللوحات الأساسية',
                'title_ur' => 'بنیادی پلیٹ پیکیج',
                'description_en' => 'List up to 3 plate ads for 30 days.',
                'description_ar' => 'قائمة تصل إلى 3 إعلانات لوحات لمدة 30 يومًا.',
                'description_ur' => '30 دن کے لئے 3 پلیٹ اشتہارات کی فہرست بنائیں۔',
            ],
            [
                'type' => 'plate',
                'price' => 60.00,
                'duration' => 60,
                'allowed_ads' => 6,
                'title_en' => 'Standard Plate Package',
                'title_ar' => 'باقة اللوحات القياسية',
                'title_ur' => 'معیاری پلیٹ پیکیج',
                'description_en' => 'List up to 6 plate ads for 60 days.',
                'description_ar' => 'قائمة تصل إلى 6 إعلانات لوحات لمدة 60 يومًا.',
                'description_ur' => '60 دن کے لئے 6 پلیٹ اشتہارات کی فہرست بنائیں۔',
            ],
            [
                'type' => 'plate',
                'price' => 100.00,
                'duration' => 90,
                'allowed_ads' => 10,
                'title_en' => 'Premium Plate Package',
                'title_ar' => 'باقة اللوحات المميزة',
                'title_ur' => 'پریمیم پلیٹ پیکیج',
                'description_en' => 'List up to 10 plate ads for 90 days.',
                'description_ar' => 'قائمة تصل إلى 10 إعلانات لوحات لمدة 90 يومًا.',
                'description_ur' => '90 دن کے لئے 10 پلیٹ اشتہارات کی فہرست بنائیں۔',
            ],
            [
                'type' => 'plate',
                'price' => 45.00,
                'duration' => 30,
                'allowed_ads' => 4,
                'title_en' => 'Economy Plate Package',
                'title_ar' => 'باقة اللوحات الاقتصادية',
                'title_ur' => 'اقتصادی پلیٹ پیکیج',
                'description_en' => 'List up to 4 plate ads for 30 days.',
                'description_ar' => 'قائمة تصل إلى 4 إعلانات لوحات لمدة 30 يومًا.',
                'description_ur' => '30 دن کے لئے 4 پلیٹ اشتہارات کی فہرست بنائیں۔',
            ],
            [
                'type' => 'plate',
                'price' => 80.00,
                'duration' => 60,
                'allowed_ads' => 8,
                'title_en' => 'Advanced Plate Package',
                'title_ar' => 'باقة اللوحات المتقدمة',
                'title_ur' => 'ایڈوانسڈ پلیٹ پیکیج',
                'description_en' => 'List up to 8 plate ads for 60 days.',
                'description_ar' => 'قائمة تصل إلى 8 إعلانات لوحات لمدة 60 يومًا.',
                'description_ur' => '60 دن کے لئے 8 پلیٹ اشتہارات کی فہرست بنائیں۔',
            ],
        ];

        $captainPackages = [
            [
                'type' => 'captain',
                'price' => 25.00,
                'duration' => 30,
                'title_en' => 'Basic Captain Package',
                'title_ar' => 'باقة الكابتن الأساسية',
                'title_ur' => 'بنیادی کپتان پیکیج',
                'description_en' => 'Subscription for captains for 30 days.',
                'description_ar' => 'اشتراك للكباتن لمدة 30 يومًا.',
                'description_ur' => '30 دن کے لئے کپتانوں کے لئے رکنیت۔',
            ],
            [
                'type' => 'captain',
                'price' => 50.00,
                'duration' => 60,
                'title_en' => 'Standard Captain Package',
                'title_ar' => 'باقة الكابتن القياسية',
                'title_ur' => 'معیاری کپتان پیکیج',
                'description_en' => 'Subscription for captains for 60 days.',
                'description_ar' => 'اشتراك للكباتن لمدة 60 يومًا.',
                'description_ur' => '60 دن کے لئے کپتانوں کے لئے رکنیت۔',
            ],
            [
                'type' => 'captain',
                'price' => 100.00,
                'duration' => 90,
                'title_en' => 'Premium Captain Package',
                'title_ar' => 'باقة الكابتن المميزة',
                'title_ur' => 'پریمیم کپتان پیکیج',
                'description_en' => 'Subscription for captains for 90 days.',
                'description_ar' => 'اشتراك للكباتن لمدة 90 يومًا.',
                'description_ur' => '90 دن کے لئے کپتانوں کے لئے رکنیت۔',
            ],
            [
                'type' => 'captain',
                'price' => 40.00,
                'duration' => 30,
                'title_en' => 'Economy Captain Package',
                'title_ar' => 'باقة الكابتن الاقتصادية',
                'title_ur' => 'اقتصادی کپتان پیکیج',
                'description_en' => 'Subscription for captains for 30 days.',
                'description_ar' => 'اشتراك للكباتن لمدة 30 يومًا.',
                'description_ur' => '30 دن کے لئے کپتانوں کے لئے رکنیت۔',
            ],
            [
                'type' => 'captain',
                'price' => 75.00,
                'duration' => 60,
                'title_en' => 'Advanced Captain Package',
                'title_ar' => 'باقة الكابتن المتقدمة',
                'title_ur' => 'ایڈوانسڈ کپتان پیکیج',
                'description_en' => 'Subscription for captains for 60 days.',
                'description_ar' => 'اشتراك للكباتن لمدة 60 يومًا.',
                'description_ur' => '60 دن کے لئے کپتانوں کے لئے رکنیت۔',
            ],
        ];

        $packages = array_merge($carPackages, $platePackages, $captainPackages);

        foreach ($packages as $packageData) {
            $translations = [
                'en' => [
                    'title' => $packageData['title_en'],
                    'description' => $packageData['description_en'],
                ],
                'ar' => [
                    'title' => $packageData['title_ar'],
                    'description' => $packageData['description_ar'],
                ],
                'ur' => [
                    'title' => $packageData['title_ur'],
                    'description' => $packageData['description_ur'],
                ],
            ];

            unset(
                $packageData['title_en'],
                $packageData['title_ar'],
                $packageData['title_ur'],
                $packageData['description_en'],
                $packageData['description_ar'],
                $packageData['description_ur']
            );

            Package::create($packageData + ['translations' => $translations]);
        }
    }
}