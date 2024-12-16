<?php

use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Jobs\sendEmail;
use Aws\Sqs\SqsClient;
use App\Models\SentMessage;
use App\Models\ReceivedMessage;
use App\Http\Controllers\MessageController;
use App\Jobs\SendMessage;

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

Route::get('/sqs/send-message', [MessageController::class, 'showSendMessageForm'])->name('send.message.form');
Route::post('/sqs/send-message', [MessageController::class, 'sendMessage'])->name('send.message.submit');
Route::get('/sqs/received-messages', [MessageController::class, 'showReceivedMessages'])->name('received.messages.view');

Route::get('/sqs/queue/sendMessage', function () {
    sendEmail::dispatch('Hi i am laravel queue message')->onConnection('sqs');
    echo 'Message sent successfully';
});

Route::get('/sqs/sendMessage', function () {
});
