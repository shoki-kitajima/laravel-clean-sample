<?php
namespace Tests\Unit;

use Tests\TestCase;
use Packages\UseCases\RegisterTaskInteractor;
use Packages\UseCases\Inputs\RegisterTaskInput;
use Packages\Domain\Task;
use Packages\Domain\TaskId;
use Packages\Domain\TaskName;
use Packages\Domain\DueDate;
use Packages\Infrastructures\EloquentModels\EloquentTaskRepository;

class RegisterTaskInteractorTest extends TestCase
{
    private $input1;
    private $input2;
    private $repo;

    public function setUp(): void
    {
        parent::setUp();
        $this->repo = new EloquentTaskRepository();
        $this->input1 = new RegisterTaskInput('タスク1', '2020-06-22T10:15');
        $this->input2 = new RegisterTaskInput('タスク2', '2020-06-23 10:15:30');
        $this->useCase = new RegisterTaskInteractor($this->repo);
        $this->artisan('migrate:fresh --path=packages/Infrastructures/Migrations');
    }

    public function test_タスクデータを登録できるか()
    {
        $res1 = $this->useCase->handle($this->input1);
        $this->assertSame($this->input1->name(), $res1->name()->value());
        $this->assertNotNull($res1->id());
        $res2 = $this->useCase->handle($this->input2);
        $this->assertSame($this->input2->name(), $res2->name()->value());
        $this->assertNotNull($res2->id());
    }
}
