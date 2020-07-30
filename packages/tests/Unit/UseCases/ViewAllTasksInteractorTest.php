<?php
namespace Tests\Unit;

use Tests\TestCase;
use Packages\UseCases\ViewAllTasksInteractor;
use Packages\Domain\Task;
use Packages\Domain\TaskId;
use Packages\Domain\TaskName;
use Packages\Domain\DueDate;
use Packages\Infrastructures\EloquentModels\EloquentTaskRepository;

class ViewAllTasksInteractorTest extends TestCase
{
    private $task;
    private $task2;
    private $repo;

    public function setUp(): void
    {
        parent::setUp();
        $this->repo = new EloquentTaskRepository();
        $this->task = new Task((new TaskId(1)), (new TaskName('タスク1')), (new DueDate('2020-06-22 10:15:30')));
        $this->task2 = new Task((new TaskId(2)), (new TaskName('タスク2')), (new DueDate('2020-06-23 10:15:30')));
        $this->useCase = new ViewAllTasksInteractor($this->repo);
        $this->artisan('migrate:fresh --path=packages/Infrastructures/Migrations');
    }

    public function test_タスクデータがある時要素数0より大きい配列が返ってくるか()
    {
        $this->repo->register($this->task);
        $output = $this->useCase->handle($this->repo);
        $this->assertSame(count($output), 1);
        $this->repo->register($this->task2);
        $output = $this->useCase->handle($this->repo);
        $this->assertSame(count($output), 2);
    }
}
