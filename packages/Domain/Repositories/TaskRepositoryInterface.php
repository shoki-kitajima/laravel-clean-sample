<?php
namespace Packages\Domain\Repositories;

use Packages\Domain\Task;
use Packages\Domain\TaskId;

/**
 * タスクリポジトリインターフェース
 */
interface TaskRepositoryInterface
{
    /**
     * 全件取得
     * @return array
     */
    public function getAll(): array;

    /**
     * IDで検索
     * @param TaskId $id
     * @return Task|null
     */
    public function findById(TaskId $id): ?Task;

    /**
     * 保存
     * @param Task $task
     * @return Task
     */
    public function save(Task $task): Task;
}
