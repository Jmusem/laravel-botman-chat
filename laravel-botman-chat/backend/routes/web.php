
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Http\Controllers\BotManController;

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

// Chatbot main endpoint
Route::match(['get', 'post'], '/botman', [BotManController::class, 'handle']);

// Autocomplete suggestions
Route::get('/autocomplete', [BotManController::class, 'autocomplete']);

// Autocorrect suggestions
Route::post('/correct', [BotManController::class, 'correct']);

// Dynamically generate dictionary files for Typo.js


// Default home page
Route::get('/', function () {
    return view('welcome');
});

// Optional fallback for undefined routes
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
