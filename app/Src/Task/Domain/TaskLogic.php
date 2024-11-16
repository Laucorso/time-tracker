<?php

declare(strict_types=1);

namespace App\Src\Task\Domain;

use App\Utils\TimeUtils;

final class TaskLogic
{

    public function __construct(
        private TaskRepository $repository,
        private TimeUtils $timeUtils
    ) {
    }
    
    public function getTimeSummary($filter): array
    {
        $tasksWithTimes = !$filter ? $this->repository->getTimeTrackers() : $this->repository->getTimeTrackersWithFilter($filter);
        $summary = [];
    
        $perPage = $tasksWithTimes->perPage();
        $currentPage = $tasksWithTimes->currentPage();
        $lastPage = $tasksWithTimes->lastPage();
        $total = $tasksWithTimes->total();
        
        foreach ($tasksWithTimes as $task) 
        {
            $summary[] = [
                'name' => $task->name,
                'today_time' => $this->timeUtils->formatDuration($task->today_time),
                'total_time' => $this->timeUtils->formatDuration($task->total_time),
            ];
        }
    
        return [
            'tasks' => $summary,
            'per_page' => $perPage,
            'current_page' => $currentPage,
            'last_page' => $lastPage,
            'total' => $total,
        ];
    }


}