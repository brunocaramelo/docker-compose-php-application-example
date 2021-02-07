<?php

namespace App\Domain\Books\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Domain\Books\Services\BookService;

use App\Domain\Books\Exceptions\BookEditException;
use App\Domain\Books\Exceptions\BookNotFoundException;
use App\Domain\Authors\Exceptions\AuthorNotFoundException;
use App\Domain\Disciplines\Exceptions\DisciplineNotFoundException;

class BooksController extends Controller
{
    public function getAll(BookService $bookService)
    {
        \Log::info('maoee');
        return response()->json(['data' => $bookService->getAll()], 200, [], JSON_NUMERIC_CHECK);
    }

    public function getById(BookService $bookService, Request $request)
    {
        try {
            return response()->json(['data' => $bookService->getById($request->id)], 200, [], JSON_NUMERIC_CHECK);
        } catch (BookNotFoundException $error) {
            return response()->json(['error'=>$error->getMessage()], 404);
        }
    }

    public function store(BookService $bookService, Request $request)
    {
        try {
            \DB::beginTransaction();
            $body = json_decode($request->getContent(), true);
            $bookService->update($request->route('id'), $body);
            \DB::commit();
            return response()->json(['message'=>'Book successfully edited']);
        } catch (BookEditException | AuthorNotFoundException | DisciplineNotFoundException $error) {
            \DB::rollback();
            return response()->json(['error'=>$error->getMessage()], 422);
        } catch (BookNotFoundException $error) {
            \DB::rollback();
            return response()->json(['error'=>$error->getMessage()], 404);
        }
    }

    public function create(BookService $bookService, Request $request)
    {
        try {
            \DB::beginTransaction();
            $body = json_decode($request->getContent(), true);
            $bookService->create($body);
            \DB::commit();
            return response()->json(['message'=>'Successfully Created Book']);
        } catch (BookEditException | AuthorNotFoundException | DisciplineNotFoundException $error) {
            \DB::rollback();
            return response()->json(['error'=>$error->getMessage()], 422);
        }
    }

    public function remove(BookService $bookService, Request $request)
    {
        try {
            \DB::beginTransaction();
            $bookService->remove($request->id);
            \DB::commit();
            return response()->json(['data' => 'Book successfully removed'], 200);
        } catch (BookNotFoundException $error) {
            \DB::rollback();
            return response()->json(['error'=>$error->getMessage()], 404);
        }
    }
}
