<?php

declare(strict_types=1);

namespace App\Src\Task\Infrastructure;

use App\Models\Task;
use App\Src\Task\Domain\TaskEntity;
use App\Src\Task\Domain\TaskId;
use App\Src\Task\Domain\TaskRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class DatabaseTaskRepository implements TaskRepository
{

    private $model;

    public function __construct()
    {
        $this->model = new Task();
    }

    public function search(int $task_id): array
    {
        return $this->model->findOrFail($task_id)->toArray();
    }

    public function searchAll(): array
    {
        return $this->model->all()->toArray();
    }

    public function searchByName(string $name): array
    {
        return $this->model->where('name', $name)->firstOrFail()->toArray();
    }

    public function create(string $task_name): array
    {
        return $this->model->firstOrCreate(['name'=>$task_name])->toArray();
    }

    public function getTimeTrackers(): LengthAwarePaginator
    {

        return $this->model::withCount([
                    'timeTrackers as total_time' => function ($query) {
                        $query->select(DB::raw("SUM(duration)"));
                    },
                    'timeTrackers as today_time' => function ($query) {
                        $query->whereDate('created_at', now()->toDateString())
                            ->select(DB::raw("SUM(duration)"));
                    }
                ])
                ->paginate(5)
                ->through(function ($task) {
                    $task->name = $task->name;
                    $task->total_time = $task->total_time ?: 0;
                    $task->today_time = $task->today_time ?: 0;
                    return $task;
                });
    }

    public function getTimeTrackersWithFilter(string $filter): LengthAwarePaginator
    {

        return $this->model::where('name', 'like', '%'.$filter.'%')
                ->withCount([
                    'timeTrackers as total_time' => function ($query) {
                        $query->select(DB::raw("SUM(duration)"));
                    },
                    'timeTrackers as today_time' => function ($query) {
                        $query->whereDate('created_at', now()->toDateString())
                            ->select(DB::raw("SUM(duration)"));
                    }
                ])
                ->paginate(5)
                ->through(function ($task) {
                    $task->name = $task->name;
                    $task->total_time = $task->total_time ?: 0;
                    $task->today_time = $task->today_time ?: 0;
                    return $task;
                });
    }
    


}