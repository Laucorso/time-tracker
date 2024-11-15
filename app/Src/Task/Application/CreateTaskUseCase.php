<?php

declare(strict_types=1);

namespace App\Src\Task\Application;

use App\Models\Task;
use App\Src\Task\Domain\TaskEntity;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Src\Task\Domain\TaskRepository;

final class CreateTaskUseCase
{
    private TaskRepository $repository;
    private Task $model;

    public function __construct(TaskRepository $repository, Task $model){
        $this->repository = $repository;
        $this->model = $model;
    }

    public function execute(string $task_name): ?array
    {
        $validator = Validator::make(['name'=>$task_name], $this->model::$createRules);
        $validatedData = $validator->validate();

        return $this->repository->create($task_name);
        //TaskEntity::fromArray($Task);
    }

}