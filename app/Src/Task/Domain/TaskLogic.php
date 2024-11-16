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
    
    public function getTimeSummary(?string $filter, $command = false): array
    {
        $tasksWithTimes = !$filter ? $this->repository->getTimeTrackers() : $this->repository->getTimeTrackersWithFilter($filter);

        $summary = [];
    
        $perPage = $tasksWithTimes->perPage();
        $currentPage = $tasksWithTimes->currentPage();
        $lastPage = $tasksWithTimes->lastPage();
        $total = $tasksWithTimes->total();
        
        foreach ($tasksWithTimes as $task) 
        {
            if ($command) {
                $summary[] = [
                    'name' => $task->name,
                    'created_at' => $task->created_at,
                    'total_time' => $this->timeUtils->formatDuration($task->today_time),
                    'timeTrackers' => $task->timeTrackers
                ];
            } else {
                $summary[] = [
                    'name' => $task->name,
                    'today_time' => $this->timeUtils->formatDuration(intval($task->today_time)),
                    'total_time' => $this->timeUtils->formatDuration(intval($task->total_time)),
                ];
            }
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