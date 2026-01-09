<?php
namespace Packages\UseCases;

use Packages\Domain\TaskId;
use Packages\Domain\Repositories\TaskRepositoryInterface;
use Packages\UseCases\Inputs\ArchiveTaskInput;

/**
 * アーカイブユースケース実装
 */
class ArchiveTaskInteractor implements ArchiveTaskInterface
{
    /**
     * @var TaskRepositoryInterface
     */
    private $repository;

    /**
     * @param TaskRepositoryInterface $repository
     */
    public function __construct(TaskRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param ArchiveTaskInput $input
     *
     * @return void
     */
    public function handle(ArchiveTaskInput $input): void
    {
        $taskId = new TaskId($input->id());
        $task =$this->repository->findById($taskId);
        $task->archive();

        // ユースケース内で例外処理を行う場合のサンプルコード
        // try {
        //     if (is_null($task)) {
        //         throw new \Exception("Task not found");
        //     }
        //     if ($task->isArchived()) {
        //         throw new \Exception("Task is already archived");
        //     }
        // } catch (\Exception $e) {
        //     throw $e;
        // }

        $this->repository->save($task);
    }
}
