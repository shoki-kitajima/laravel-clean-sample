<?php
namespace Packages\Domain\Repositories;

use Packages\Domain\Task;

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
    public function save(Task $task): void;
}
