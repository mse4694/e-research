<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

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

Route::match(['get', 'post'],'/', function () {
    $query = \App\Models\Research::query();

    if( request()->keyword ) {
        $query->filterByKeyword(request()->keyword);
    }

    if( request()->first_author ) {
        $query->filterByFirstAuthor(request()->first_author);
    }

    if( request()->doi ) {
        $query->filterByDoi(request()->doi);
    }

    $researchs = $query->with('person:id,image')
                    ->orderBy('publish_date', 'desc')
                    ->paginate(5)
                    ->withQueryString();
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'researchs' => $researchs,
        'filters' => Request::only(['keyword','first_author','doi'])
    ]);
})->name('index');

Route::post('/create-data', function () {
    return Redirect::route('index');
})->name('create-data');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
