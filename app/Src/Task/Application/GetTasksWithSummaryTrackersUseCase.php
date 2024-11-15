<?php

declare(strict_types=1);

namespace App\Src\Task\Application;

use App\Models\Task;
use App\Src\Task\Domain\TaskEntity;
use App\Src\Task\Domain\TaskLogic;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Src\Task\Domain\TaskRepository;

final class GetTasksWithSummaryTrackersUseCase
{
    private TaskRepository $repository;
    private Task $model;

    public function __construct(TaskRepository $repository, Task $model){
        $this->repository = $repository;
        $this->model = $model;
    }

    public function execute(?string $filter): array
    {
        return (new TaskLogic($this->repository))->getTimeSummary($filter);
    }

}