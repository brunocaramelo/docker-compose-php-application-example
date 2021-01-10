<?php

use Illuminate\Http\Request;

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

Route::group(['prefix' => 'v1'], function ()
{
    Route::get('/authors',
        [ 'as' => 'authors-list',
        'uses' => '\App\Domain\Authors\Controllers\AuthorsController@getAll'
    ]);

    Route::group(['prefix' => 'author'], function ()
    {
        Route::post('/process/message',
            [ 'as' => 'author-process-message',
            'uses' => '\App\Domain\Authors\Controllers\AuthorsController@sendMessageToQueue'
        ]);

        Route::get('/{id}',
            [ 'as' => 'author-detail',
            'uses' => '\App\Domain\Authors\Controllers\AuthorsController@getById'
        ]);

        Route::put('/{id}',
        [ 'as' => 'author-store',
        'uses' => '\App\Domain\Authors\Controllers\AuthorsController@store'
        ]);

        Route::post('/',
        [ 'as' => 'author-create',
        'uses' => '\App\Domain\Authors\Controllers\AuthorsController@create'
        ]);

    });


    Route::get('/disciplines',
        [ 'as' => 'disciplines-list',
        'uses' => '\App\Domain\Disciplines\Controllers\DisciplinesController@getAll'
    ]);

    Route::group(['prefix' => 'discipline'], function ()
    {
        Route::get('/{id}',
            [ 'as' => 'discipline-detail',
            'uses' => '\App\Domain\Disciplines\Controllers\DisciplinesController@getById'
        ]);

        Route::put('/{id}',
            [ 'as' => 'discipline-store',
            'uses' => '\App\Domain\Disciplines\Controllers\DisciplinesController@store'
        ]);

        Route::post('/',
            [ 'as' => 'discipline-create',
            'uses' => '\App\Domain\Disciplines\Controllers\DisciplinesController@create'
        ]);
    });

    Route::get('/books',
        [ 'as' => 'books-list',
        'uses' => '\App\Domain\Books\Controllers\BooksController@getAll'
    ]);

    Route::group(['prefix' => 'book'], function ()
    {
        Route::get('/{id}',
            [ 'as' => 'book-detail',
            'uses' => '\App\Domain\Books\Controllers\BooksController@getById'
        ]);

        Route::put('/{id}',
            [ 'as' => 'book-store',
            'uses' => '\App\Domain\Books\Controllers\BooksController@store'
        ]);

        Route::delete('/{id}',
            [ 'as' => 'book-store',
            'uses' => '\App\Domain\Books\Controllers\BooksController@remove'
        ]);

        Route::post('/',
            [ 'as' => 'book-create',
            'uses' => '\App\Domain\Books\Controllers\BooksController@create'
        ]);
    });

});
