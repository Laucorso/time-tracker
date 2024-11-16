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
use App\Utils\TimeUtils;

final class CreateTimeTrackerUseCase
{
    private TimeTrackerRepository $repository;
    private TaskRepository $taskRepository;
    private TimeTracker $model;
    private TimeUtils $utilsTime;
    private Task $modelTask;

    public function __construct(TimeTrackerRepository $repository, TaskRepository $taskRepository, TimeTracker $model, Task $modelTask, TimeUtils $utilsTime){
        $this->repository = $repository;
        $this->taskRepository = $taskRepository;
        $this->model = $model;
        $this->modelTask = $modelTask;
        $this->utilsTime = $utilsTime;
    }

    public function execute(string $task_name): void
    {

        (new TimeTrackerLogic($this->repository, $this->taskRepository, $this->utilsTime, $this->modelTask))->start($task_name);
        //TaskEntity::fromArray($Task);
    }

}