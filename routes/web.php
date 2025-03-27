<?php

use App\Models\Campaign;
use App\Mail\EmailCampaign;
use App\Jobs\SendEmailsCampaign;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\EmailListController;
use App\Http\Controllers\SubscriberController;
use App\Http\Middleware\CampaignCreateSessionControl;

//para testar a abertura de email
Route::get('/email', function()
{
    //busque pelo id da campanha
    $campaign = Campaign::find(3);
    $mail = $campaign->mails()->first();
    $email = new EmailCampaign($campaign, $mail);

    SendEmailsCampaign::dispatchAfterResponse($campaign);

    return $email->render();
});

Route::get('/t/{mail}/o', [TrackingController::class, 'openings'])->name('tracking.openings');
Route::get('/t/{mail}/c', [TrackingController::class, 'clicks'])->name('tracking.clicks');

Route::view('/', 'welcome');

Route::view('/dashboard','dashboard')->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/email-list', [EmailListController::class, 'index'])->name('email-list.index');
    Route::get('/email-list/create', [EmailListController::class, 'create'])->name('email-list.create');
    Route::post('/email-list/store', [EmailListController::class, 'store'])->name('email-list.store');
    Route::get('/email-list/{emailList}/subscribers', [SubscriberController::class, 'index'])->name('subscribers.index');
    Route::delete('email-list/{emailList}/subscribers/{subscriber}', [SubscriberController::class, 'destroy'])->name('subscribers.destroy');
    Route::get('/email-list/{emailList}/subscribers/create', [SubscriberController::class, 'create'])->name('subscribers.create');
    Route::post('/email-list/{emailList}/subscribers/store', [SubscriberController::class, 'store'])->name('subscribers.store');

    Route::resource('templates', TemplateController::class);

    Route::get('/campaigns', [CampaignController::class, 'index'])->name('campaigns.index');
    Route::delete('/campaigns/{campaign}', [CampaignController::class, 'destroy'])->name('campaigns.destroy');
    Route::get('/campaigns/create/{tab?}', [CampaignController::class, 'create'])->middleware(CampaignCreateSessionControl::class)->name('campaigns.create');
    Route::get('/campaigns/{campaign}/{what?}', [CampaignController::class, 'show'])->name('campaigns.show')->withTrashed();
    Route::post('/campaigns/create/{tab?}', [CampaignController::class, 'store']);
    Route::patch('/campaigns/{campaign}/restore', [CampaignController::class, 'restore'])->withTrashed()->name('campaigns.restore');

});

require __DIR__.'/auth.php';
