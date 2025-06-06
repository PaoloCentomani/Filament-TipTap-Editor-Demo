<?php

namespace App\Traits;

use App\Models\Task;
use App\Models\TaskType;
use Illuminate\Support\Collection;

trait TasksTrait
{
    /**
     * Return all tasks associated with document processing that are applicable to the current model
     *
     * @return \Illuminate\Support\Collection<\App\Models\Task>
     */
    public function documentTasks()
    {
        return Task::where('attach_documents', 1)
            ->whereIn('task_type_id', $this->tasksList()->pluck('id'))
            ->get()
            ->filter(function (Task $task) {
                return $task->appliesToModel($this);
            });
    }

    public function tasksList(): Collection
    {
        return TaskType::getFromModel($this);
    }

    /**
     * Return all tasks associated with premium payment processing that are applicable to the current model
     *
     * @return \Illuminate\Support\Collection<\App\Models\Task>
     */
    public function paymentTasks()
    {
        return Task::where('attach_documents', 0)
            ->whereIn('task_type_id', $this->tasksList()->pluck('id'))
            ->get()
            ->filter(function (Task $task) {
                return $task->appliesToModel($this);
            });
    }
}
