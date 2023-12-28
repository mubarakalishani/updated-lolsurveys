<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IpExampleController;
use App\Http\Controllers\OfferwallsPostbacksController;
use App\Http\Controllers\Advertiser\CreateTaskController;
use App\Http\Controllers\Advertiser\TaskFullPageController;
use App\Http\Controllers\Worker\TaskSubmitController;
use App\Http\Controllers\Worker\PtcAdController;
use App\Http\Controllers\Worker\WorkerFaucetController;
use App\Http\Controllers\Advertiser\ReviewTasksController;
use App\Http\Controllers\Worker\WorkerShortLinkController;


use App\Livewire\ReviewTasks;

use App\Http\Controllers\Admin\AdminTaskCategoryController;
use App\Http\Controllers\Advertiser\DepositController;
use App\Http\Controllers\Pages\ContactPageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/ip', [IpExampleController::class, 'index']);

Route::get('/create-task', function () {
    return view('advertiser.create_task');
});

Route::get('/advertiser/task', function () {
    return view('advertiser.task_full_page');
});

Route::get('/livevalidationexample', function () {
    return view('livevalidation');
});

Route::get('/create-ptc', function () {
    return view('advertiser.create_ptc');
});

Route::get('/advertiser/create-new-ptc-campaign', function () {
    return view('advertiser.ptc.create-new-ptc');
});

Route::get('/advertiser/campaigns', function () {
    return view('advertiser.task.campaign-list');
});

Route::get('/advertiser/campaign/{taskId}', [TaskFullPageController::class, 'showCampaignDetails']);

Route::get('/advertiser/deposit', function () {
    return view('advertiser.deposit');
});

Route::get('/offers', function () {
    return view('worker.all-offers');
});

Route::get('/advertiser/new-ptc-campaign', function () {
    return view('advertiser.ptc.create-new-ptc');
});

Route::get('/advertiser/create-new-task', function () {
    return view('advertiser.task.create-campaign');
});

Route::get('/advertiser/disputes', function () {
    return view('advertiser.task.disputes');
});


Route::get('/faucetpay/callback', [DepositController::class, 'faucetpaySuccessCallback']);

Route::get('/faucet', [WorkerFaucetController::class, 'index'])->name('worker.faucet');

Route::get('/shortlinks', [WorkerShortLinkController::class, 'index'])->name('worker.shortlinks');
Route::get('/shortlink/{uniqueId}', [WorkerShortLinkController::class, 'show'])->name('shortlink.show');
Route::get('/shortlink/back/{secretKey}', [WorkerShortLinkController::class, 'verifyAndUpdate'])->name('shortlink.verifyandupdate');

Route::get('/views', function () {
    return view('worker.ptc.allptc-ads');
});

Route::get('/jobs', function () {
    return view('worker.all-jobs');
});

Route::get('/referral', function () {
    return view('worker.referral');
});

Route::get('/contact', [ContactPageController::class, 'index']);
Route::post('/contact', [ContactPageController::class, 'store'])->name('contact.submit');


Route::get('/jobs/{taskId}', [TaskSubmitController::class, 'showTask']);
Route::post('/jobs/{taskId}', [TaskSubmitController::class, 'store'])->name('worker.submit_task');
Route::get('/jobs/submitted/{taskId}', [TaskSubmitController::class, 'showSbumittedProof']);
Route::post('/jobs/submitted/{taskId}/file-dispute', [TaskSubmitController::class, 'fileDispute'])->name('worker.file_dispute');

Route::post('/jobs/submitted/{taskId}/submit-revised-task', [TaskSubmitController::class, 'submitRevisedTask'])->name('worker.submit_revised_task');



Route::get('/history', function () {
    return view('worker.history.overall');
});

Route::get('/history/jobs', function () {
    return view('worker.history.jobs');
});

Route::get('/withdraw', function () {
    return view('worker.withdraw');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->get('/views/iframe/{uniqueId}', [PtcAdController::class, 'show'])->name('ptc.iframe');

Route::post('/views/iframe/{uniqueId}', [PtcAdController::class, 'iframeSubmit'])->name('worker.ptc_iframe.submit');

Route::get('/views/iframe', [PtcAdController::class, 'showIframe'])->name('worker.views.iframe.show');
Route::get('/views/window', [PtcAdController::class, 'showWindow'])->name('worker.views.window.show');
Route::get('/views/youtube', [PtcAdController::class, 'showYoutube'])->name('worker.views.youtube.show');

Route::post('/views/window', [PtcAdController::class, 'windowSubmit'])->name('worker.ptc.window.submit');

Route::get('/advertiser/tasks/{taskId}', [TaskFullPageController::class, 'showTask']);

Route::get('/adscendmedia', [OfferwallsPostbacksController::class, 'adscendmedia']);




Route::post('/advertiser/new-ptc-campaign', [CreateTaskController::class, 'store'])->name('advertiser.create_task');

Route::post('/worker/submit-task/{taskId}', [TaskSubmitController::class, 'store'])->name('worker.submit_task');

Route::get('/advertiser/review-task/{taskId}', [ReviewTasksController::class, 'show']);

Route::post('/advertiser/review-task/{taskId}', [ReviewTasksController::class, 'approve'])->name('advertiser.approve_proof');


Route::post('/faucet', [WorkerFaucetController::class, 'store'])->name('worker.claim_faucet');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});




Route::get('/admin/task-categories/{id}/add-rewards', [AdminTaskCategoryController::class, 'addRewards'])->name('admin.task-categories.add-rewards');
Route::post('/admin/task-categories/{id}/store-rewards', [AdminTaskCategoryController::class, 'storeRewards'])->name('admin.task-categories.store-rewards');

