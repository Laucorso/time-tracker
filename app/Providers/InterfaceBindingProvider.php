<?php

namespace App\Providers;

use App\Src\Task\Domain\TaskRepository;
use App\Src\Task\Infrastructure\DatabaseTaskRepository;
use App\Src\TimeTracker\Domain\TimeTrackerRepository;
use App\Src\TimeTracker\Infrastructure\DatabaseTimeTrackerRepository;
use Illuminate\Support\ServiceProvider;

class InterfaceBindingProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Task repo
        $this->app->bind(TaskRepository::class, DatabaseTaskRepository::class);
        // Time tracker repo
        $this->app->bind(TimeTrackerRepository::class, DatabaseTimeTrackerRepository::class);

    }
}