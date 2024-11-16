<?php

declare(strict_types=1);

namespace App\Src\TimeTracker\Domain;

use App\Models\Task;
use App\Src\Task\Application\CreateTaskUseCase;
use App\Src\Task\Application\FindTaskUseCase;
use App\Src\Task\Domain\TaskRepository;
use App\Utils\TimeUtils;

final class TimeTrackerLogic
{

    public function __construct(
        private TimeTrackerRepository $repository,
        private TaskRepository $taskRepository,
        private TimeUtils $timeUtils,
        private Task $modelTask
    ) {
    }

    public function start(string $name): void
    {
        // getting first or create task firstly
        $createTaskUseCase = new CreateTaskUseCase($this->taskRepository, $this->modelTask);
        $task = $createTaskUseCase->execute($name);

        //creating new time tracker by task by every start button click
        $this->repository->create($task['id']);
    }

    public function end(int $durationSecs, string $name): void
    {
        // getting first or create task firstly
        $findTaskUseCase = new FindTaskUseCase($this->taskRepository);
        $task = $findTaskUseCase->execute($name);

        $durationMins = $this->timeUtils->secondsToMinutes($durationSecs);
        //updating tracker by task when end button click
        $this->repository->update($durationMins, $task['id']);
    }

}