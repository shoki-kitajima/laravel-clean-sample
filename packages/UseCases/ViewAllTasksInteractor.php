<?php
namespace Packages\UseCases;

use Packages\Domain\Repositories\TaskRepositoryInterface;

/**
 * 閲覧実装
 */
class ViewAllTasksInteractor implements ViewAllTasksInterface
{
    /**
     * @var TaskRepositoryInterface
     */
    private $repository;

    public function __construct(TaskRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return array[Task]
     */
    public function handle(): array
    {
        return $this->repository->getAll();
    }
}
