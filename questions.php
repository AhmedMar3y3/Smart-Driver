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
now here is the refrences here is the client model




we have implemented the package manipulation from the admin side and subscription to packages in the client side in the previous step
- now we need to implement the exam feature the client after subscribing to the package can start the exam and answer the questions and submit the exam and get the results so we need to implement starting the exam with getting the first question and another endpoint to get the next question after checking the answer of the current question and another endpoint to submit the exam and get the results
- so the flow is going to be like this:
- 1. Client pays for the package and starts the exam (immediately or later)
- 2. Client start the exam and get the first question
- 3. Client answers the question sends his answer in the endpoint that gets the next question and gets the next question after saving the answer
- 4. Client submits the exam (and cannot submit till he answer all questions) and gets the results and if the score is less than 90% he cannot start the next level exam he can buy it but cannot start it till he pass all the previous levels if he got less than 90% he cannot take the exam again unless he buys the package again
- 5. If the client passes the exam with a score of 90% or more he can buy the next level package (or start the exam if he did buy it previously) and take it's exam and the previous package cannot be bought again cause he finished it
- each exam has a time limit and the user must finish the exam before the time is up
- the client should be able to see the packages he bought and the exams he took and the results of last attempt of each exam

now here is the refrences here is the models of the feature 
"<?php

namespace App\Models;

use App\Traits\HasImage;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class QuestionPackage extends Model
{
    use Translatable, HasImage;

    protected $table = 'question_packages';
    public $translatedAttributes = ['title', 'description'];
    protected $fillable = ['level_order', 'price', 'time_limit'];

    public function questions()
    {
        return $this->hasMany(Question::class, 'question_package_id');
    }

    public function subscriptions()
    {
        return $this->hasMany(QuestionSubscription::class, 'question_package_id');
    }
}""<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionPackageTranslation extends Model
{
    use HasFactory;


    protected $fillable = ['title', 'description'];

    public $timestamps = false;

}
" "<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'question_package_id',
        'status',
        'payment_status',
        'invoice_id',
        'invoice_url',
    ];

    public function subscriber()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function package()
    {
        return $this->belongsTo(QuestionPackage::class, 'question_package_id');
    }

    public function exams()
    {
        return $this->hasMany(Exam::class, 'question_subscription_id');
    }
}" "<?php

namespace App\Models;

use App\Traits\HasImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory, HasImage;

    protected $fillable = ['question_package_id', 'question_text', 'image'];

    public function package()
    {
        return $this->belongsTo(QuestionPackage::class, 'question_package_id');
    }

    public function choices()
    {
        return $this->hasMany(Choice::class, 'question_id');
    }

    public function examAnswers()
    {
        return $this->hasMany(ExamAnswer::class, 'question_id');
    }
}" "<?php

namespace App\Models;

use App\Traits\HasImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Choice extends Model
{
    use HasFactory, HasImage;

    protected $fillable = ['question_id', 'choice_text', 'is_correct', 'image'];
    protected $casts = [
        'is_correct' => 'boolean',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

    public function examAnswers()
    {
        return $this->hasMany(ExamAnswer::class, 'choice_id');
    }
}" and exam and exam answer models "<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = ['question_subscription_id', 'start_time', 'end_time', 'status', 'score'];

    public function subscription()
    {
        return $this->belongsTo(QuestionSubscription::class, 'question_subscription_id');
    }

    public function answers()
    {
        return $this->hasMany(ExamAnswer::class, 'exam_id');
    }
}" "<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamAnswer extends Model
{
    use HasFactory;

    protected $fillable = ['exam_id', 'question_id', 'choice_id'];

    public function exam()
    {
        return $this->belongsTo(Exam::class, 'exam_id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

    public function choice()
    {
        return $this->belongsTo(Choice::class, 'choice_id');
    }
}" and here is the subscription controller and service "<?php

namespace App\Http\Controllers\API\Client;

use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Services\QuestionSubscriptionService;

class QuestionSubscriptionController extends Controller
{
    use HttpResponses;
    protected $subscriptionService;

    public function __construct(QuestionSubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    public function subscribe(Request $request)
    {
        $client = auth('client')->user();
        $packageId = $request->input('package_id');
        $subscription = $this->subscriptionService->subscribe($client, $packageId);
        return $this->successWithDataResponse([
            'invoice_url' => $subscription->invoice_url,
            'subscription_id' => $subscription->id,
        ]);
    }
}
" "<?php

namespace App\Services;

use App\Exceptions\CustomException;
use App\Models\QuestionSubscription;
use App\Models\QuestionPackage;

class QuestionSubscriptionService
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function subscribe($client, $packageId)
    {
        $package = QuestionPackage::find($packageId);
        if (!$package) {
            throw new CustomException('حزمة غير صالحة.');
        }

        if($client->hasActiveSubscription($packageId)) {
            throw new CustomException('لديك بالفعل اشتراك نشط من نفس النوع.');
        }

        $subscription = QuestionSubscription::create([
            'client_id' => $client->id,
            'question_package_id' => $package->id,
            'status' => 'pending',
            'payment_status' => 'unpaid',
        ]);

        $paymentData = $this->paymentService->initiatePayment(
            $subscription,
            config('MyFatoorah.front_end_success_url'),
            config('MyFatoorah.front_end_error_url'),
            'question.payment.callback',
            'question.payment.error'
        );
        $subscription->update([
            'invoice_id' => $paymentData['InvoiceId'],
            'invoice_url' => $paymentData['InvoiceURL'],
            'payment_status' => 'initiated',
        ]);

        return $subscription;
    }
}" and the exam controller and service which you're going to implement now "<?php

namespace App\Http\Controllers\API\Client;

use App\Http\Controllers\Controller;
use App\Services\ExamService;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    protected $examService;

    public function __construct(ExamService $examService)
    {
        $this->examService = $examService;
    }

    public function startExam(Request $request)
    {
        $client = auth('client')->user();
        $exam = $this->examService->startExam($client, $request->input('subscription_id'));
        return response()->json(['message' => 'Exam started', 'data' => $exam], 200);
    }

    public function submitExam(Request $request)
    {
        $client = auth('client')->user();
        $result = $this->examService->submitExam($client, $request->input('exam_id'), $request->input('answers'));
        return response()->json(['message' => 'Exam submitted', 'data' => $result], 200);
    }
}" "<?php

namespace App\Services;

use App\Models\Exam;
use App\Models\QuestionSubscription;
use Carbon\Carbon;

class ExamService
{
    public function startExam($client, $subscriptionId)
    {
        $subscription = QuestionSubscription::where('id', $subscriptionId)
            ->where('client_id', $client->id)
            ->where('status', 'active')
            ->firstOrFail();

        $exam = Exam::create([
            'question_subscription_id' => $subscription->id,
            'start_time' => Carbon::now(),
            'end_time' => Carbon::now()->addMinutes($subscription->package->time_limit),
            'status' => 'in_progress',
        ]);

        return $exam;
    }

    public function submitExam($client, $examId, $answers)
    {
        $exam = Exam::where('id', $examId)
            ->whereHas('subscription', fn($q) => $q->where('client_id', $client->id))
            ->firstOrFail();

        if ($exam->status !== 'in_progress') {
            throw new \Exception('Exam is not in progress.');
        }

        foreach ($answers as $answer) {
            $exam->answers()->create([
                'question_id' => $answer['question_id'],
                'choice_id' => $answer['choice_id'],
            ]);
        }

        $correctAnswers = $exam->answers()->whereHas('choice', fn($q) => $q->where('is_correct', true))->count();
        $totalQuestions = $exam->subscription->package->questions()->count();
        $score = ($correctAnswers / $totalQuestions) * 100;

        $exam->update([
            'status' => 'completed',
            'score' => $score,
            'end_time' => Carbon::now(),
        ]);

        if ($score >= 90) {
            $exam->subscription->update(['status' => 'completed']);
        }

        return ['score' => $score, 'passed' => $score >= 90];
    }
}"
*/


