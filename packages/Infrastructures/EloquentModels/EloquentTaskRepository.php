<?php
namespace Packages\Infrastructures\EloquentModels;

use Packages\Domain\Repositories\TaskRepositoryInterface;
use Packages\Domain\Task;
use Packages\Domain\TaskId;
use Packages\Domain\TaskName;
use Packages\Domain\DueDate;
use Packages\Infrastructures\EloquentModels\TaskModel;
use Illuminate\Database\Eloquent\Collection;

/**
 * タスクリポジトリEloquent実装
 */
class EloquentTaskRepository implements TaskRepositoryInterface
{
    /**
     * @var TaskModel
     */
    private $model;

    /**
     * @param TaskModel $model
     */
    public function __construct(TaskModel $model)
    {
        $this->model = $model;
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        return $this->collectionToEntityArray($this->model->select()->where('is_archived', '=', false)->get());
    }

    /**
     * @param TaskId $taskId
     * @return Task|null
     */
    public function findById(TaskId $taskId): ?Task
    {
        $eloquentTask = $this->model->find($taskId->value());
        if (is_null($eloquentTask)) {
            return null;
        }
        return $this->toEntity($eloquentTask);
    }

    /**
     * @param Task $task
     * @return Task
     */
    public function save(Task $task): Task
    {
        $eloquentTask = $this->model->find($task->id()->value());
        if (is_null($eloquentTask)) {
            // 新規登録
            $eloquentTask = $this->model->create([
                'name' => $task->name()->value(),
                'due_date' => $task->dueDate()->value()
            ]);
        } else {
            // 更新
            $eloquentTask->name = $task->name()->value();
            $eloquentTask->due_date = $task->dueDate()->value();
            $eloquentTask->is_done = $task->isDone();
            $eloquentTask->is_archived = $task->isArchived();
            $eloquentTask->save();
        }
        dd($task, $eloquentTask);
        return $this->toEntity($eloquentTask);
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
     * @param EloquentTaskRepository $eloquentTask
     *
     * @return Task
     */
    private function toEntity(TaskModel $eloquentTask): Task
    {
        $id = new TaskId($eloquentTask->id);
        $name = new TaskName($eloquentTask->name);
        $dueDate = new DueDate($eloquentTask->due_date);
        return new Task($id, $name, $dueDate);
    }
}
