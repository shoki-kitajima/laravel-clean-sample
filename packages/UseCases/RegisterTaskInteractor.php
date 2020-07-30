<?php
namespace Packages\UseCases;

use Packages\Domain\Repositories\TaskRepositoryInterface;
use Packages\Domain\Task;
use Packages\Domain\TaskId;
use Packages\Domain\TaskName;
use Packages\Domain\DueDate;
use Packages\UseCases\Inputs\RegisterTaskInput;

/**
 * 登録実装
 */
class RegisterTaskInteractor implements RegisterTaskInterface
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
     * @param RegisterTaskInput $input
     *
     * @return Task
     */
    public function handle(RegisterTaskInput $input): Task
    {
        $id = new TaskId(null);
        $taskName = new TaskName($input->name());
        $dueDate = new DueDate($input->dueDate());
        $task = new Task($id, $taskName, $dueDate);
        return $this->repository->register($task);
    }
}
