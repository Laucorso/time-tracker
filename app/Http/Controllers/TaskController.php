<?php

namespace App\Http\Controllers;

use App\Src\Task\Application\GetTasksWithSummaryTrackersUseCase;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    public function summary(Request $request, GetTasksWithSummaryTrackersUseCase $useCase)
    {
        $response = $useCase->execute($request->filter);
        return response()->json($response, 200);
    }
}
