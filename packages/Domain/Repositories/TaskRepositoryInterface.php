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
     * 保存
     * @param Task $task
     * @return void
     */
    public function register(Task $task): Task;

    /**
     * @param int $id
     *
     * @return void
     */
    public function toggleIsDone(TaskId $id): void;

    /**
     * @param TaskId $id
     *
     * @return void
     */
    public function archive(TaskId $id): void;
}
