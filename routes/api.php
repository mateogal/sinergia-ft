<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PlayerController;
use App\Http\Controllers\API\MatchController;
use App\Http\Controllers\API\FieldController;
use App\Http\Controllers\API\PlayerMatchController;
use App\Http\Controllers\API\TeamMakerController;
use App\Http\Controllers\API\FundController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

if (\App::environment('production')) {
    \URL::forceScheme('https');
}

Route::get('ranking', [PlayerMatchController::class, 'ranking'])->name('ranking');
Route::get('test', [PlayerMatchController::class, 'getTeamsMatch']);
// Route::post('playermatch', [PlayerMatchController::class, 'store'])->middleware('auth:api');

Route::get('players/{id}/getMatches', [PlayerController::class, 'getMatches']);
Route::get('matches/next', [MatchController::class, 'nextMatch']);
Route::get('maker/bestlineup', [TeamMakerController::class, 'bestLineUps']);
// Route::get('maker/autolineup', [TeamMakerController::class, 'autoTeamLineUp']);

Route::middleware('auth:api')->get('/user-api', function (Request $request) {
    return $request->user()->load('profile');
});

Route::post('register', [AuthController::class, 'register']);
Route::get('register', function(){
    return view('auth.register');
})->name('register');

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::get('login', function(){
    return view('auth.login');
});

Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('logout');

###################################################################
###################################################################

Route::get('password/reset', function(){
    return view('auth.passwords.email');
})->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

###################################################################
###################################################################

Route::get('password/reset/{token}', function ($token) {
    return view('auth.passwords.reset', ['token' => $token]);
})->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

###################################################################
###################################################################

Route::middleware('tokenAuth')->group(function(){
    Route::put('playermatch', [PlayerMatchController::class, 'update']);
    Route::delete('playermatch', [PlayerMatchController::class, 'destroy']);
    Route::get('home', 'App\Http\Controllers\HomeController@index')->name('dashboard');
    Route::get('home/matchHistory', [HomeController::class, 'matchHistory'])->name('home.match_history');
    Route::get('match/history', [MatchController::class, 'history'])->name('match.history');
    Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
    Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});

###################################################################
###################################################################

Route::apiResource('players', PlayerController::class);
Route::apiResource('matches', MatchController::class);
Route::apiResource('fields', FieldController::class);
Route::apiResource('funds', FundController::class);
Route::apiResource('playermatch', PlayerMatchController::class)->middleware('auth:api');

Route::get('{page}', ['as' => 'page.index', 'uses' => 'App\Http\Controllers\PageController@index'])->middleware('tokenAuth');

Route::get('getAwsFile/{image}', function($image){
    date_default_timezone_set('America/Montevideo');
    $datetime = new DateTime('now');
    $datetime->modify('+1 hour');
    return redirect(Storage::disk('s3')->temporaryUrl(
        $image,
        $datetime->format('Y-m-d H:i:s'),
        ['ResponseContentDisposition' => 'attachment']
    ));
});
