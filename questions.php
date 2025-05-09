<?php

/*
- we have implemented the subscription to packages in the previous step
- now we need to implement or add another feature to the app
- we need to implement the questions feature
- first the admin creates a package for the questions levels each package has a level which can be the name of the package
- the package has a price also and questions with choices the number of questions is not fixed it's dynamic
- each question has 4 choices and one of them is the correct answer
- the user can select the package and pay for it and then he can start answering the questions
- the user cannot start answering the questions until he pays for the package so he must pay for the package first and then start the exam.
- each exam has a time limit and the user must finish the exam before the time is up
- there would be a button for the next question and the previous question
- the user can go back to the previous question but cannot change his answer
- the user can submit the exam once he has answered all questions or when the time is up (the exam is submitted by default), he cannot submit the exam before answering all questions
- the results will be displayed after submission, showing correct and incorrect answers
- the user will receive feedback on their performance after the exam is completed
- the user must complete the exam within the allotted time which is set by the admin when creating the package
- after the user completes the exam and submits it if the total score is less than 90% he cannot buy the next level package until he passes the current level and also if he got less than 90% he cannot take the exam again unless he buys the package again
- if the user passes the exam with a score of 90% or more he can buy the next level package and take it's exam and the previous package cannot be bought again cause he finished it
- after the user pays for the package, the package he bought should be saved that the user can access it later and start the exam later and should display if he already took the exam or not
- the questions can have Image file in the question itself but not in the choices.
- so the flow is going to be like this:
- 1. Admin creates a package with questions and choices
- 2. Client pays (using MyFatoorah payment we implemented together) for the first level package and starts the exam (immediately or later)
- 3. Client answers the questions and submits the exam
- 4. Client receives feedback on their performance and based on his score if it's less than 90% he cannot buy the next level package and take the exam again unless he buys the package of the same level again and pass the exam with 90% or more
- 5. If the client passes the exam with 90% or more he can buy the next level package and take it's exam and the previous package cannot be bought again cause he finished it
- 6. The client can see the packages he bought and the exams he took and the results of last attempt of each exam

- start make the code for the feature make everything needed migrations, models, controllers, routes, services.
- make the code clean and organized and use the same structure we used in the previous steps. and if the logic is complex use a service and call it in the controller to handle the logic.
now here is the refrences here is the client model "<?php

namespace App\Models;

use App\Traits\HasImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class Client extends Authenticatable
{
    use HasFactory, HasImage, HasApiTokens;

    protected $fillable = [
        'name',
        'image',
        'phone',
        'email',
        'password',
        'isSubscribed',
        'subscription_type',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'isSubscribed' => 'boolean',
        'subscription_type' => 'integer',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public static function createWithGoogle(array $googleData)
    {
        return static::create([
            'name' => $googleData['name'],
            'email' => $googleData['email'],
            'image' => $googleData['avatar'],
            'password' => Hash::make(uniqid()),
            'phone' => 'google',
        ]);
    }

    public function cars()
    {
        return $this->hasMany(Car::class);
    }

    public function plates()
    {
        return $this->hasMany(Plate::class);
    }
    public function changePassword(string $newPassword): void
    {
        $this->password = $newPassword;
        $this->save();
    }

    public function verifyPassword(string $password): bool
    {
        return Hash::check($password, $this->password);
    }

    public function subscriptions()
    {
        return $this->morphMany(Subscription::class, 'subscriber');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
"
and the package model "<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory, Translatable;
    protected $with = ['translations'];
    public $translatedAttributes = ['title', 'description'];
    protected $fillable = [
        'type',
        'price',
        'duration',
        'ad_duration',
        'allowed_ads',
        'allowed_ads_per_month',
    ];
    protected $casts = [
        'type' => 'string',
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
" and subscription model "<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'subscriber_id',
        'subscriber_type',
        'package_id',
        'start_date',
        'end_date',
        'status',
        'payment_status',
        'invoice_id',
        'invoice_url',
    ];

    public function subscriber()
    {
        return $this->morphTo();
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
" ah and the package title of course in three languages as seen in the controller and request of the previous feature "<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Package;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\Admin\PackageResource;
use App\Http\Requests\API\Admin\Package\StorePackageRequest;
use App\Http\Requests\API\Admin\Package\UpdatePackageRequest;

class PackageController extends Controller
{
    use HttpResponses;

    public function index()
    {
        $packages = Package::all();
        return $this->successWithDataResponse(PackageResource::collection($packages));
    }

    public function show(Package $package)
    {
        return $this->successWithDataResponse(new PackageResource($package));
    }

    public function store(StorePackageRequest $request)
    {
        $package = Package::create($request->validated());
        $this->updateTranslations($package, $request);
        return $this->successResponse('تم إضافة الباقة بنجاح');
    }

    public function update(UpdatePackageRequest $request, Package $package)
    {
        $package->update($request->validated());
        $this->updateTranslations($package, $request);
        return $this->successResponse('تم تعديل الباقة بنجاح');
    }

    public function destroy(Package $package)
    {
        $package->delete();
        return $this->successResponse('تم حذف الباقة بنجاح');
    }

    protected function updateTranslations(Package $package, $request)
    {
        $locales = ['en', 'ar', 'ur'];
        $fields = ['title', 'description'];

        foreach ($locales as $locale) {
            foreach ($fields as $field) {
                $inputKey = "{$field}_{$locale}";
                if ($request->has($inputKey)) {
                    $package->translateOrNew($locale)->$field = $request->input($inputKey);
                }
            }
        }
        $package->save();
    }
}" "<?php

namespace App\Http\Requests\API\Admin\Package;

use App\Http\Requests\BaseRequest;

class StorePackageRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'type' => 'required|in:car,plate,captain',
            'price' => 'required|numeric|min:0',
            'duration' => 'required_if:type,plate,captain|integer|min:1|nullable',
            'ad_duration' => 'required_if:type,car|integer|min:1|nullable',
            'allowed_ads' => 'required_if:type,plate|integer|min:0|nullable',
            'allowed_ads_per_month' => 'required_if:type,car|integer|min:0|nullable',
            'title_en' => 'required|string',
            'title_ar' => 'required|string',
            'title_ur' => 'required|string',
            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'description_ur' => 'nullable|string',
        ];
    }
}
" and here is the subscription controller and service of the previous feature "<?php

namespace App\Http\Controllers\API\Client;

use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Services\SubscriptionService;


class SubscriptionController extends Controller
{
    use HttpResponses;
    protected $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    public function subscribeClient(Request $request)
    {
        $client = auth('client')->user();
        $successUrl = $request->input('success_url');
        $errorUrl = $request->input('error_url');

        try {
            $subscription = $this->subscriptionService->subscribe($client, $request->input('package_id'), $successUrl, $errorUrl);
            return $this->successWithDataResponse([
                'invoice_url' => $subscription->invoice_url,
                'subscription_id' => $subscription->id,
            ]);
        } catch (\Exception $e) {
            return $this->failureResponse($e->getMessage());
        }
    }
} "   "<?php

namespace App\Services;

use App\Enums\PaymentStatus;
use App\Enums\SubscriptionStatus;
use App\Models\Package;
use App\Models\Subscription;
use Carbon\Carbon;
use App\Enums\Status;
use Illuminate\Support\Facades\Log;

class SubscriptionService
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function subscribe($user, $packageId, $successUrl, $errorUrl)
    {
        $package = Package::findOrFail($packageId);

        if ($user instanceof \App\Models\Client && !in_array($package->type, ['car', 'plate'])) {
            throw new \Exception('يمكن للعملاء الاشتراك فقط في باقات السيارات أو اللوحات.');
        }
        if ($user instanceof \App\Models\Captain && $package->type !== 'captain') {
            throw new \Exception('يمكن للكباتن الاشتراك فقط في باقات الكابتن.');
        }

        $existingSubscription = $user->subscriptions()
            ->where('status', SubscriptionStatus::ACTIVE->value)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->whereHas('package', fn($q) => $q->where('type', $package->type))
            ->first();

        if ($existingSubscription) {
            if ($user instanceof \App\Models\Captain) {
                throw new \Exception('لديك بالفعل اشتراك كابتن نشط.');
            } else {
                throw new \Exception("لديك بالفعل اشتراك نشط من نوع {$package->type}.");
            }
        }

        $startDate = Carbon::now();
        $endDate = $startDate->copy()->addDays($package->duration ?? 30);
        $subscription = Subscription::create([
            'start_date' => $startDate,
            'end_date' => $endDate,
            'subscriber_id' => $user->id,
            'subscriber_type' => get_class($user),
            'package_id' => $package->id,
            'status' => SubscriptionStatus::PENDING->value,
        ]);

        try {
            $paymentData = $this->paymentService->initiatePayment($subscription, $successUrl, $errorUrl);
            $subscription->update([
                'invoice_id' => $paymentData['InvoiceId'],
                'invoice_url' => $paymentData['InvoiceURL'],
                'payment_status' => PaymentStatus::INITIATED->value,
            ]);
        } catch (\Exception $e) {
            Log::error('فشل بدء الدفع عبر MyFatoorah', ['error' => $e->getMessage()]);
            $subscription->delete();
            throw $e;
        }

        return $subscription;
    }

    public function canPostCarAd($client)
    {
        $activeSubscription = $client->subscriptions()
            ->whereHas('package', fn($q) => $q->where('type', 'car'))
            ->where('status', SubscriptionStatus::ACTIVE->value)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();

        if ($activeSubscription) {
            $startOfMonth = Carbon::now()->startOfMonth();
            $endOfMonth = Carbon::now()->endOfMonth();
            $adsThisMonth = $client->cars()
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->count();

            return $adsThisMonth < $activeSubscription->package->allowed_ads_per_month;
        } else {
            $activeCars = $client->cars()
                ->where('status', '!=', Status::SOLD->value)
                ->count();

            return $activeCars < 1;
        }
    }

    public function canPostPlateAd($client)
    {
        $subscription = $client->subscriptions()
            ->whereHas('package', fn($q) => $q->where('type', 'plate'))
            ->where('status', SubscriptionStatus::ACTIVE->value)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();

        if (!$subscription) {
            return false;
        }

        $adsPosted = $client->plates()
            ->whereBetween('created_at', [$subscription->start_date, $subscription->end_date])
            ->count();

        return $adsPosted < $subscription->package->allowed_ads;
    }
}
" and the payment service "<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('MyFatoorah.token');
        $this->baseUrl = config('MyFatoorah.url');
    }

    public function initiatePayment($subscription, $successUrl, $errorUrl)
    {
        $user = $subscription->subscriber;
        $payload = [
            'CustomerName' => $user->name,
            'NotificationOption' => 'LNK',
            'InvoiceValue' => $subscription->package->price,
            'CurrencyCode' => 'AED',
            'DisplayCurrencyIso' => 'AED',
            'CallBackUrl' => route('subscription.payment.callback', [
                'subscription_id' => $subscription->id,
                'success_url' => $successUrl,
            ]),
            'ErrorUrl' => route('subscription.payment.error', [
                'subscription_id' => $subscription->id,
                'error_url' => $errorUrl,
            ]),
            'CustomerEmail' => $user->email,
            'CustomerMobile' => $user->phone ?? '+00000',
            'CustomerReference' => $subscription->id,
        ];

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$this->apiKey}",
            'Content-Type' => 'application/json',
        ])->post("{$this->baseUrl}/v2/SendPayment", $payload);

        if (!$response->ok()) {
            throw new \Exception('Payment initiation failed.');
        }

        Log::info('Payment initiation response:', $response->json());
        return $response->json()['Data'];
    }

    public function getPaymentStatus($invoiceId)
    {
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$this->apiKey}",
            'Content-Type' => 'application/json',
        ])->post("{$this->baseUrl}/v2/GetPaymentStatus", [
            'KeyType' => 'InvoiceId',
            'Key' => (string) $invoiceId,
        ]);

        if (!$response->ok()) {
            throw new \Exception('Failed to retrieve payment status.');
        }

        return $response->json();
    }
}"

*/