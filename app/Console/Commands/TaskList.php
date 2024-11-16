<?php

namespace App\Console\Commands;

use App\Models\Task;
use App\Src\Task\Application\GetTasksWithSummaryTrackersUseCase;
use App\Src\Task\Domain\TaskRepository;
use App\Utils\TimeUtils;
use Illuminate\Console\Command;

class TaskList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Obtain task list with details';

    protected $taskRepository;
    protected $taskModel;
    protected $utils;

    /**
     *
     * @param TaskRepository $taskRepository
     * @param Task $taskModel
     * @param TimeUtils $utils
     * @return void
     */
    public function __construct(TaskRepository $taskRepository, Task $taskModel, TimeUtils $utils)
    {
        parent::__construct();

        $this->taskRepository = $taskRepository;
        $this->taskModel = $taskModel;
        $this->utils = $utils;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $useCase = new GetTasksWithSummaryTrackersUseCase($this->taskRepository, $this->taskModel, $this->utils);
        $tasksWithTrackers = $useCase->execute(null, true);

        $this->info('Looking for tasks details...');
        
        if (count($tasksWithTrackers['tasks'])>0) {

            $tasks = array_map(function ($task) {
                $lastEnd = !empty($task['taskTrackers']) ? end($task['taskTrackers'])['updated_at'] : null;
                return [
                    'start' => $task['created_at'],
                    'last_end_info' => $lastEnd,
                    'duration' => $task['total_time'],
                ];
            }, $tasksWithTrackers['tasks']);
        
            $this->table(
                ['start', 'last_end_info', 'duration'],
                array_map(function ($task) {
                    return [
                        $task['start'] ? $task['start'] : 'N/A',
                        $task['last_end_info'] ? $task['last_end_info'] : 'N/A',
                        $task['total_time'] == '' ? 'N/A' : $task['total_time'],
                    ];
                }, $tasks)
            );
        }
    }
}
