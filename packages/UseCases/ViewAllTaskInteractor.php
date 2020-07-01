<?php
namespace Packages\UseCases;

use Packages\Domain\Repositories\TaskRepositoryInterface;

class ViewAllTaskInteractor implements ViewAllTaskInterface
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
     * TODO: outputもBoundary用意する
     * @return array
     */
    public function handle(): array
    {
        return $this->repository->getAll();
    }
}
