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
        $this->repository->archive($taskId);
    }
}
