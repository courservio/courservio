<?php

use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Booking;
use App\Http\Livewire\BookingOverview;
use App\Http\Livewire\CertTemplate;
use App\Http\Livewire\Course;
use App\Http\Livewire\CourseParticipant;
use App\Http\Livewire\CourseType;
use App\Http\Livewire\Home;
use App\Http\Livewire\LocationSearch;
use App\Http\Livewire\Participant;
use App\Http\Livewire\ParticipantDetails;
use App\Http\Livewire\PasswordReset;
use App\Http\Livewire\Position;
use App\Http\Livewire\Price;
use App\Http\Livewire\Role;
use App\Http\Livewire\Setup;
use App\Http\Livewire\Team;
use App\Http\Livewire\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix(LaravelLocalization::setLocale())->middleware('localeSessionRedirect', 'localizationRedirect', 'localeViewPath')->group(function () {
    Route::post('livewire/message/{name}', \Livewire\Controllers\HttpConnectionHandler::class);

    Route::get('login', Login::class)
            ->middleware('guest')
            ->name('login');

    Route::get('home', Home::class)
            ->name('home');

    Route::get('teams', Team::class)
            ->name('teams');

    Route::get('user', User::class)
            ->name('user');

    Route::get('coursetype', CourseType::class)
            ->name('coursetype');

    Route::get('course', Course::class)
            ->name('course');

    Route::get('participant/{course}', CourseParticipant::class)
            ->name('participant.course');

    Route::get('participant/{participant}/details', ParticipantDetails::class)
            ->name('participant.details');

    Route::get('participant', Participant::class)
            ->name('participant');

    Route::get('roles', Role::class)
            ->name('roles');

    Route::get('prices', Price::class)
            ->name('prices');

    Route::get('positions', Position::class)
            ->name('positions');

    Route::get('cert-templates', CertTemplate::class)
            ->name('certTemplates');

    Route::get('course/{slug}', LocationSearch::class);

    Route::get('course/{slug}/{location}', BookingOverview::class)
            ->name('booking.overview');

    Route::get('course/{slug}/{location}/{location2}', BookingOverview::class)
            ->name('booking.coordinates');

    Route::get('booking/{course}/{price}', Booking::class)
            ->name('booking');
}
);

Route::get('setup', Setup::class);

if (config('services.indexnow.key')) {
    Route::get('{key}.txt', function (Request $request, $key) {
        if ($key === config('services.indexnow.key')) {
            return config('services.indexnow.key');
        }

        abort(404);
    });
}

Route::get('/', function () {
    return redirect(config('app.redirect'));
});

Route::get('password/reset/{hashedId}', PasswordReset::class)
    ->middleware('signed')
    ->name('password.reset');

Route::get(
    '/email/verify',
    function () {
        return view('auth.verify-email'); // TODO correct message if still not confirmed email
    }
)
    ->middleware('auth')
    ->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect()->to('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return redirect()->back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
