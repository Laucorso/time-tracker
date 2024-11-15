<?php

declare(strict_types=1);

namespace App\Src\Task\Domain;

use Illuminate\Pagination\LengthAwarePaginator;

interface TaskRepository
{
    public function search(int $task_id): array;
    public function searchByName(string $task_name): array;
    public function searchAll(): array;
    public function create(string $task_name): array;
    public function getTimeTrackers(): LengthAwarePaginator;
    public function getTimeTrackersWithFilter(string $filter): LengthAwarePaginator;
}