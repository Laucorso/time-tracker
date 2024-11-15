<?php

namespace App\Http\Controllers;

use App\Src\TimeTracker\Application\CreateTimeTrackerUseCase;
use App\Src\TimeTracker\Application\UpdateTimeTrackerUseCase;
use Illuminate\Http\Request;

class TimeTrackerController extends Controller
{
    public function start(string $task, CreateTimeTrackerUseCase $useCase)
    {
        $useCase->execute($task);
        return response()->json(['message' => 'creado'], 201);
    }

    public function stop(Request $request, string $task, UpdateTimeTrackerUseCase $useCase)
    {
        $useCase->execute($request->input('duration'),$task);
        return response()->json(['message'=>'actualizado'], 200);
    }
}
