<?php
namespace packages\Domain\Repositories;

use packages\Domain\Task;

interface TaskRepositoryInterface
{
    /**
     * 全件取得
     * @return array
     */
    public function all(): array;

    /**
     * 保存
     * @param Task $task
     * @return void
     */
    public function insertOrUpdate(Task $task): void;
}
