<?php

declare(strict_types=1);

namespace App\Src\TimeTracker\Infrastructure;

use App\Models\TimeTracker;
use App\Src\TimeTracker\Domain\TimeTrackerRepository;

class DatabaseTimeTrackerRepository implements TimeTrackerRepository
{

    private $model;

    public function __construct()
    {
        $this->model = new TimeTracker();
    }


    public function searchAll(): array
    {
        return $this->model->all()->toArray();
    }

    public function create(int $task_id): void
    {
        $this->model->create([
            'task_id'=>$task_id
        ]);
    }

    public function update(int $duration, int $task_id): void
    {
        $this->model
            ->where('task_id', $task_id)
            ->whereNull('duration')
            ->update([
                'duration'=>$duration
            ]);
    }

}