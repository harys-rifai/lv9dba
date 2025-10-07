<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BotManController;
use Filament\Notifications\Notification; 

Route::get('/test-notif', function () {
    Notification::make()
        ->title('Notifikasi')
        ->body('Notifikasi hal happening here')
        ->success()
        ->sendToDatabase(auth()->user());

    return 'Notifikasi dikirim!';
});

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
    return to_route('filament.pages.dashboard');
})->name('filament.auth.login');
Route::get('/users', [UserController::class, 'index'])->name('users.index');

Route::middleware([
    'auth:sanctum',
    config('filament-companies.auth_session'),
    'verified',
])->group(function () {
});

if (!app()->environment('production') || !app()->runningUnitTests()) {
    Route::get('superadmin', function () {
        auth()->user()->assignRole('super_admin');
        return redirect()->back();
    });
}
Route::match(['get', 'post'], '/botman', [BotManController::class, 'handle']);