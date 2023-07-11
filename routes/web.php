<?php

use App\Http\Controllers\ProfileController;
use App\Imports\ResearchsImport;
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
    $query = \App\Models\Research::query()->where('person_id', '<>', 0);

    if( request()->item_per_page ) {
        $item_per_page = request()->item_per_page;
    } else {
        $item_per_page = 5;
    }

    if( request()->title ) {
        $query->filterByTitle(request()->title);
    }

    if( request()->keyword ) {
        $query->filterByKeyword(request()->keyword);
    }

    if( request()->author ) {
        $query->filterByAuthor(request()->author);
    }

    if( request()->journal_name ) {
        $query->filterByJournalName(request()->journal_name);
    }

    if( request()->doi ) {
        $query->filterByDoi(request()->doi);
    }

    if( request()->publication_date_range ) {
        if( request()->publication_date_range === 'custom' ) {
            $query->filterByBetweenYear([request()->custom_publication_date_range[0], request()->custom_publication_date_range[1]]);
        }else if( request()->publication_date_range != 0 ) {
            $query->filterByBetweenYear([date(NOW()->year) - request()->publication_date_range, date(NOW()->year)]);
        }
    }

//    $end_year = \App\Models\Research::select('publish_date')->orderBy('publish_date', 'desc')->first();
//    $start_year = \App\Models\Research::select('publish_date')->orderBy('publish_date', 'asc')->first();
//
//    $researchs = $query->with('person:id,image')
//                    ->orderBy('publish_date', 'desc')
//                    ->paginate($item_per_page)
//                    ->withQueryString();


    $researchs = $query->with('person:id,image')
        ->orderBy('id', 'asc')
        ->orderBy('year', 'desc')
        ->paginate($item_per_page)
        ->withQueryString();

    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'researchs' => $researchs,
//        'start_year' => $start_year->publish_date,
//        'end_year' => $end_year->publish_date,
        'filters' => Request::only(['title','keyword','first_author','journal_name','doi', 'publication_date_range', 'custom_publication_date_range'])
    ]);
})->name('index');

Route::post('/create-data', function () {
    return Redirect::route('index');
})->name('create-data');

Route::get('/export-research', function () {
    return \Maatwebsite\Excel\Facades\Excel::download(new  \App\Exports\ResearchsExport, 'research.xlsx');
})->name('export-research');

Route::post('/import-research', function () {
    //$import = \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\ResearchsImport, storage_path('\excel\research.xlsx'));
    $import = new ResearchsImport();
    $import->import(storage_path('\excel\research.xlsx'));

    //dd($import->errors());
    return Redirect::route('index');
})->name('import-research');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
