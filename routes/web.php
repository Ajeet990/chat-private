<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\PusherController;
use Illuminate\Support\Facades\Broadcast;

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

// Route::get('/', function () {
//     return view('welcome');
// });
Broadcast::routes();
Route::get('/', [ChatController::class, 'index']);
Route::get('/login', [ChatController::class, 'login'])->name('login');
Route::post('/makeLogin', [ChatController::class, 'makeLogin'])->name('makeLogin');
Route::get('/register', [ChatController::class, 'register'])->name('register');
Route::post('/addUser', [ChatController::class, 'addUser'])->name('addUser');

Route::get('/dashboard', [ChatController::class, 'dashboard'])->name('dashboard');
Route::get('/friend-requests', [ChatController::class, 'friendRequests'])->name('friend.requests');
Route::post('/send-request', [ChatController::class, 'sendRequest']);
Route::post('/accept-request', [ChatController::class, 'acceptRequest']);
Route::get('/chat-with-friend/{receiver_id}', [ChatController::class, 'chatWithFriend'])->name('chat.with.friend');

Route::post('/broadcast', [PusherController::class, 'broadcast']);
Route::post('/receive', [PusherController::class, 'receive']);

// Route::get('/')
