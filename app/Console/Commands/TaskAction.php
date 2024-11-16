<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use App\Models\TimeTracker;
use Carbon\Carbon;

class TaskAction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:action {action} {taskName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start or end a task based on the provided action and task name';

    /**
     * Execute the console command.
    */
    public function handle()
    {
        $action = $this->argument('action');
        $taskName = $this->argument('taskName');

        //use use cases we have around application
        $task = Task::where('name', $taskName)->first();

        if (!$task) {
            //use use cases we have around application
            $task = new Task();
            $task->name = $taskName;
            $task->save();
        }

        switch ($action) {
            case 'start':
                $this->startTask($task);
                break;

            case 'stop':
                $this->endTask($task);
                break;

            default:
                $this->error('Invalid action. Use "start" or "stop".');
                break;
        }
    }

    /**
     * Start a task by creating a new task tracker.
    */
    private function startTask(?Task $task)
    {
        //use use cases we have around application
        $taskTracker = new TimeTracker();
        $taskTracker->task_id = $task->id;
        $taskTracker->save();

        $this->info("Task '{$task->name}' started new timer at {$taskTracker->created_at->toDateTimeString()}.");
    }

    /**
     * End a task by updating the last task tracker.
    */
    private function endTask(Task $task)
    {
        $taskTracker = TimeTracker::where('task_id', $task->id)
                                  ->whereNull('duration')
                                  ->first();

        if (!$taskTracker) {
            $this->error('No active tracker found for this task.');
            return;
        }

        $taskTracker->duration = intval($taskTracker->created_at->diffInMinutes(Carbon::now()));
        $taskTracker->save();

        // todo: duration format with utils
        $this->info("Task '{$task->name}' tracker time ended. Duration time: '{$taskTracker->duration}'");
    }
}
