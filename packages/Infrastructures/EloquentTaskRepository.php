<?php
namespace Packages\Infrastructures;

use Illuminate\Database\Eloquent\Model;
use Packages\Domain\Repositories\TaskRepositoryInterface;
use Packages\Domain\Task;
use Packages\Domain\TaskId;
use Packages\Domain\TaskName;
use Packages\Domain\DueDate;
use Illuminate\Database\Eloquent\Collection;

class EloquentTaskRepository extends Model implements TaskRepositoryInterface
{
    protected $table = 'tasks';

    /**
     * 全件取得
     * @return array
     */
    public function getAll(): array
    {
        return $this->collectionToEntityArray(parent::all());
    }

    /**
     * 保存
     * @param Task $task
     * @return void
     */
    public function store(Task $task): void
    {
    }

    private function collectionToEntityArray(Collection $collection):array
    {
        $returns = [];
        foreach ($collection as $row) {
            $taskId = new TaskId($row->id);
            $taskName = new TaskName($row->name);
            $dueDate = new DueDate($row->due_date);
            $isDone = (bool) $row->isDone;
            $isArchived = (bool) $row->isArchived;
            $obj = new Task($taskId, $taskName, $dueDate);
            $obj->setIsDone($isDone);
            $obj->setIsArchived($isArchived);
            $returns[] = $obj;
        }
        return $returns;
    }
}
