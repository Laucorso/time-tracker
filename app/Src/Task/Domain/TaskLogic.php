<?php

declare(strict_types=1);

namespace App\Src\Task\Domain;

final class TaskLogic
{

    public function __construct(
        private TaskRepository $repository
    ) {
    }

    public function formatDuration($totalMinutes): string
    {
        $hours = floor($totalMinutes / 60);
        $minutes = $totalMinutes % 60;
        $result = '';

        if ($hours > 0) {
            $result .= $hours . ' hora' . ($hours > 1 ? 's' : '') . ' ';
        }
        if ($minutes > 0) {
            $result .= $minutes . ' minuto' . ($minutes > 1 ? 's' : '');
        }
    
        return $result;
    }
    
    public function getTimeSummary($filter): array
    {
        // Obtener todas las tareas con sus duraciones calculadas
        $tasksWithTimes = !$filter ? $this->repository->getTimeTrackers() : $this->repository->getTimeTrackersWithFilter($filter);
        $summary = [];
    
        $perPage = $tasksWithTimes->perPage();
        $currentPage = $tasksWithTimes->currentPage();
        $lastPage = $tasksWithTimes->lastPage();
        $total = $tasksWithTimes->total();
        
        // Iterar sobre las tareas
        foreach ($tasksWithTimes as $task) 
        {
            $summary[] = [
                'name' => $task->name,
                'today_time' => $this->formatDuration($task->today_time),
                'total_time' => $this->formatDuration($task->total_time),
            ];
        }
    
        // Puedes retornar o usar los datos paginados en el resultado
        return [
            'tasks' => $summary,
            'per_page' => $perPage,
            'current_page' => $currentPage,
            'last_page' => $lastPage,
            'total' => $total,
        ];
    }


}