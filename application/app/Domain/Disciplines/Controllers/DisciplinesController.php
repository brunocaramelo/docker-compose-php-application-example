<?php

namespace App\Domain\Disciplines\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Domain\Disciplines\Services\DisciplineService;

use App\Domain\Disciplines\Exceptions\DisciplineEditException;
use App\Domain\Disciplines\Exceptions\DisciplineNotFoundException;

class DisciplinesController extends Controller
{
    public function getAll(DisciplineService $disciplineService)
    {
        return response()->json(['data' => $disciplineService->getAll()]);
    }
    
    public function getById(DisciplineService $disciplineService, Request $request)
    {
        try {
            $item = $disciplineService->getById($request->id);
            return response()->json(['data' => $item]);
        } catch (DisciplineNotFoundException $error) {
            return response()->json(['error'=>$error->getMessage()], 404);
        }
    }
    
    public function store(DisciplineService $disciplineService, Request $request)
    {
        try {
            \DB::beginTransaction();
            $body = json_decode($request->getContent(), true);
            $disciplineService->update($request->route('id'), $body);
            \DB::commit();
            return response()->json(['message'=>'Disciplina Editada com sucesso']);
        } catch (DisciplineEditException $error) {
            \DB::rollback();
            return response()->json(['error'=>$error->getMessage()], 422);
        } catch (DisciplineNotFoundException $error) {
            \DB::rollback();
            return response()->json(['error'=>$error->getMessage()], 404);
        }
    }

    public function create(DisciplineService $disciplineService, Request $request)
    {
        try {
            \DB::beginTransaction();
            $body = json_decode($request->getContent(), true);
            $disciplineService->create($body);
            \DB::commit();
            return response()->json(['message'=>'Disciplina Criada com sucesso']);
        } catch (DisciplineEditException $error) {
            \DB::rollback();
            return response()->json(['error'=>$error->getMessage()], 422);
        }
    }
}
