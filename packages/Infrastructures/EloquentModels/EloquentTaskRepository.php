<?php
namespace Packages\Infrastructures\EloquentModels;

use Illuminate\Database\Eloquent\Model;
use Packages\Domain\Repositories\TaskRepositoryInterface;
use Packages\Domain\Task;
use Packages\Domain\TaskId;
use Packages\Domain\TaskName;
use Packages\Domain\DueDate;
use Illuminate\Database\Eloquent\Collection;

/**
 * タスクリポジトリEloquent実装
 */
class EloquentTaskRepository extends Model implements TaskRepositoryInterface
{
    protected $table = 'tasks';
    protected $fillable = ['name', 'due_date'];

    /**
     * @return array
     */
    public function getAll(): array
    {
        return $this->collectionToEntityArray(parent::select()->where('is_archived', '=', false)->get());
    }

    /**
     * @param Task $task
     * @return void
     */
    public function register(Task $task): Task
    {
        $newTask = parent::create([
            'name' => $task->name()->value(),
            'due_date' => $task->dueDate()->value()
        ]);
        return $this->toEntity($newTask);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function toggleIsDone(TaskId $taskId): void
    {
        $eloquentTask = parent::find($taskId->value());
        if (is_null($eloquentTask)) {
            throw new \Exception('trying to find a nonexistent task');
        }
        $eloquentTask->is_done = $eloquentTask->is_done ? false : true;
        $eloquentTask->save();
    }

    /**
     * @param TaskId $taskId
     *
     * @return void
     */
    public function archive(TaskId $taskId): void
    {
        $eloquentTask = parent::find($taskId->value());
        if (is_null($eloquentTask)) {
            throw new \Exception('trying to find a nonexistent task');
        }
        $eloquentTask->is_archived = true;
        $eloquentTask->save();
    }

    /**
     * @param Collection $collection
     *
     * @return array
     */
    private function collectionToEntityArray(Collection $collection): array
    {
        $returns = [];
        foreach ($collection as $row) {
            $taskId = new TaskId($row->id);
            $taskName = new TaskName($row->name);
            $dueDate = new DueDate($row->due_date);
            $isDone = (bool) $row->is_done;
            $isArchived = (bool) $row->isArchived;
            $obj = new Task($taskId, $taskName, $dueDate);
            $obj->setIsDone($isDone);
            $obj->setIsArchived($isArchived);
            $returns[] = $obj;
        }
        return $returns;
    }

    /**
     * @param EloquentTaskRepository $eloquentObj
     *
     * @return Task
     */
    private function toEntity(EloquentTaskRepository $eloquentObj): Task
    {
        $id = new TaskId($eloquentObj->id);
        $name = new TaskName($eloquentObj->name);
        $dueDate = new DueDate($eloquentObj->due_date);
        return new Task($id, $name, $dueDate);
    }
}
