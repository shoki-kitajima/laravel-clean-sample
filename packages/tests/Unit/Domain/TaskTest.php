<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Packages\Domain\Task;
use Packages\Domain\TaskId;
use Packages\Domain\TaskName;
use Packages\Domain\DueDate;

class TaskTest extends TestCase
{
    /**
     * @var TaskId
     */
    private $id;

    /**
     * @var TaskId
     */
    private $nullId;

    /**
     * @var TaskName
     */
    private $taskName;

    /**
     * @var DueDate
     */
    private $dueDate;

    /**
     * @var Task
     */
    private $obj;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->id = new TaskId(1);
        $this->nullId = new TaskId(null);
        $this->taskName = new TaskName('タスク1');
        $this->dueDate = new DueDate('2020-06-22 10:15:30');
        $this->obj = new Task($this->id, $this->taskName, $this->dueDate);
    }

    public function test_idにTaskIdインスタンス以外を渡すとインスタンス作成できないか()
    {
        $this->expectException(\TypeError::class);
        $task = new Task(1, $this->taskName, $this->dueDate);
    }

    public function test_taskNameにTaskNameインスタンス以外を渡すとインスタンス作成できないか()
    {
        $this->expectException(\TypeError::class);
        $task = new Task($this->id, 'test', $this->dueDate);
    }

    public function test_dueDateにDueDateインスタンス以外を渡すとインスタンス作成できないか()
    {
        $this->expectException(\TypeError::class);
        $task = new Task($this->id, $this->taskName, new \datetime());
    }

    public function test_未登録タスクでもTaskを作れるか()
    {
        $this->expectException(\TypeError::class);
        $task = new Task($this->nullId, $this->taskName, new \datetime());
    }

    public function test_idがgetできるか()
    {
        $this->assertSame($this->obj->id(), $this->id);
    }

    public function test_nameがgetできるか()
    {
        $this->assertSame($this->obj->name()->value, $this->name);
    }

    public function test_dueDateがgetできるか()
    {
        $this->assertSame($this->obj->dueDate()->value(), $this->dueDate->value());
    }

    public function test_isDoneがgetできるか()
    {
        $this->assertFalse($this->obj->isDone());
    }

    public function test_isArchivedがgetできるか()
    {
        $this->assertFalse($this->obj->isArchived());
    }

    public function test_インスタンス作成直後isDoneがfalseか()
    {
        $this->assertFalse($this->obj->isDone());
    }

    public function test_インスタンス作成直後isArchivedがfalseか()
    {
        $this->assertFalse($this->obj->isArchived());
    }

    public function test_setNameはTaskName以外の引数で実行できないか()
    {
        $cloneObj = clone $this->obj;
        $this->expectException(\TypeError::class);
        $cloneObj->setName('new name');
    }

    public function test_setNameできるか()
    {
        $newName = 'new task name';
        $cloneObj = clone $this->obj;
        $cloneObj->setName(new TaskName($newName));
        $this->assertSame($cloneObj->name()->value(), $newName);
    }

    public function test_setDueDateできるか()
    {
        $datetTimeString = '2020-01-02 10:15:01';
        $cloneObj = clone $this->obj;
        $cloneObj->setDueDate(new DueDate($datetTimeString));
        $this->assertSame($cloneObj->dueDate()->value(), $datetTimeString);
    }

    public function test_setIsDoneできるか()
    {
        $cloneObj = clone $this->obj;
        $cloneObj->setIsDone(true);
        $this->assertTrue($cloneObj->isDone());
    }

    public function test_setIsArchivedできるか()
    {
        $cloneObj = clone $this->obj;
        $cloneObj->setIsArchived(true);
        $this->assertTrue($cloneObj->isArchived());
    }
}
