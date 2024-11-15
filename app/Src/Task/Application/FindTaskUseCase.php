<?php

declare(strict_types=1);

namespace App\Src\Task\Application;

use App\Src\Task\Domain\TaskEntity;
use App\Src\Task\Domain\TaskRepository;

final class FindTaskUseCase
{
    private TaskRepository $repository;

    public function __construct(TaskRepository $repository){
        $this->repository = $repository;
    }

    public function execute(string $task_name): ?array
    {
        return $this->repository->searchByName($task_name);
    }

}