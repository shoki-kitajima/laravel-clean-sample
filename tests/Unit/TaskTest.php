<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use packages\Domain\Task;
use packages\Domain\TaskId;
use packages\Domain\TaskName;
use packages\Domain\DueDate;

class TaskTest extends TestCase
{
    /**
     * @var TaskId
     */
    private $id;
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
     * @return void
     */
    protected function setUp(): void
    {
        $this->id = new TaskId(1);
        $this->nullId = new TaskId(null);
        $this->taskName = new TaskName('タスク1');
        $this->dueDate = new DueDate('2020-06-22 10:15:30');
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

    public function test_idがgetできるか()
    {
        $obj = new Task($this->id, $this->taskName, $this->dueDate);
        $this->assertSame($obj->id(), $this->id);
    }

    public function test_nameがgetできるか()
    {
        $obj = new Task($this->id, $this->taskName, $this->dueDate);
        $this->assertSame($obj->name()->value, $this->name);
    }

    public function test_dueDateがgetできるか()
    {
        $obj = new Task($this->id, $this->taskName, $this->dueDate);
        $this->assertSame($obj->dueDate()->value(), $this->dueDate->value());
    }

    public function test_isDoneがgetできるか()
    {
        $obj = new Task($this->id, $this->taskName, $this->dueDate);
        $this->assertFalse($obj->isDone());
    }

    public function test_isArchivedがgetできるか()
    {
        $obj = new Task($this->id, $this->taskName, $this->dueDate);
        $this->assertFalse($obj->isArchived());
    }

    public function test_インスタンス作成直後isDoneがfalseか()
    {
        $obj = new Task($this->id, $this->taskName, $this->dueDate);
        $this->assertFalse($obj->isDone());
    }

    public function test_インスタンス作成直後isArchivedがfalseか()
    {
        $obj = new Task($this->id, $this->taskName, $this->dueDate);
        $this->assertFalse($obj->isArchived());
    }
}
