<?php

declare(strict_types=1);

namespace App\Src\TimeTracker\Domain;

interface TimeTrackerRepository
{
    public function create(int $task_id): void;
    public function update(int $duration, int $task_id): void;
}