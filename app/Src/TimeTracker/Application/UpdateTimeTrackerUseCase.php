<?php

declare(strict_types=1);

namespace App\Src\TimeTracker\Application;

use App\Models\Task;
use App\Models\TimeTracker;
use App\Src\Task\Domain\TaskEntity;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Src\Task\Domain\TaskRepository;
use App\Src\TimeTracker\Domain\TimeTrackerLogic;
use App\Src\TimeTracker\Domain\TimeTrackerRepository;

final class UpdateTimeTrackerUseCase
{
    private TimeTrackerRepository $repository;
    private TaskRepository $taskRepository;
    private TimeTracker $model;
    private Task $modelTask;

    public function __construct(TimeTrackerRepository $repository, TaskRepository $taskRepository, TimeTracker $model, Task $modelTask){
        $this->repository = $repository;
        $this->taskRepository = $taskRepository;
        $this->model = $model;
        $this->modelTask = $modelTask;
    }

    public function execute(int $duration, string $task_name): void
    {
        (new TimeTrackerLogic($this->repository, $this->taskRepository, $this->modelTask))->end($duration, $task_name);
    }

}