<?php
namespace Packages\UseCases;

use Packages\Domain\TaskId;
use Packages\Domain\Repositories\TaskRepositoryInterface;
use Packages\UseCases\Inputs\ToggleIsDoneTaskInput;

/**
 * 完了toggle実装
 */
class ToggleIsDoneTaskInteractor implements ToggleIsDoneTaskInterface
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
     * @param ToggleIsDoneTaskInput $input
     *
     * @return void
     */
    public function handle(ToggleIsDoneTaskInput $input): void
    {
        $taskId = new TaskId($input->id());
        $this->repository->toggleIsDone($taskId);
    }
}
