<?php

declare(strict_types=1);

namespace App\Src\Task\Application;

use App\Models\Task;
use App\Src\Task\Domain\TaskEntity;
use App\Src\Task\Domain\TaskLogic;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Src\Task\Domain\TaskRepository;
use App\Utils\TimeUtils;

final class GetTasksWithSummaryTrackersUseCase
{
    private TaskRepository $repository;
    private TimeUtils $timeUtils;
    private Task $model;

    public function __construct(TaskRepository $repository, Task $model, TimeUtils $timeUtils){
        $this->repository = $repository;
        $this->timeUtils = $timeUtils;
        $this->model = $model;
    }

    public function execute(?string $filter, ?bool $command = false): array
    {
        return (new TaskLogic($this->repository, $this->timeUtils))->getTimeSummary($filter, $command);
    }

}