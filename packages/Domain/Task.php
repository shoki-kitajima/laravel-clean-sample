<?php
namespace Packages\Domain;

/**
 * タスクオブジェクト
 */
final class Task
{
    /**
     * @var TaskId
     */
    private $id;

    /**
     * @var TaskName
     */
    private $name;

    /**
     * @var DueDate
     */
    private $dueDate;

    /**
     * @var bool
     */
    private $isDone;

    /**
     * @var bool
     */
    private $isArchived;

    /**
     * @param TaskId $taskId
     * @param TaskName $taskName
     * @param DueDate $duedate
     * @param bool $isDone
     * @param bool $isArchived
     */
    public function __construct(TaskId $id, TaskName $taskName, DueDate $dueDate)
    {
        $this->id = $id;
        $this->name = $taskName;
        $this->dueDate = $dueDate;
        $this->isDone = false;
        $this->isArchived = false;
    }

    /**
     * @return TaskId
     */
    public function id(): TaskId
    {
        return $this->id;
    }

    /**
     * @return TaskName
     */
    public function name(): TaskName
    {
        return $this->name;
    }

    /**
     * @return DueDate
     */
    public function dueDate(): DueDate
    {
        return $this->dueDate;
    }

    /**
     * @return bool
     */
    public function isDone(): bool
    {
        return $this->isDone;
    }

    /**
     * @return bool
     */
    public function isArchived(): bool
    {
        return $this->isArchived;
    }

    /**
     * @param TaskName $name
     *
     * @return void
     */
    public function setName(TaskName $name): void
    {
        $this->name = $name;
    }

    /**
     * @param DueDate $dueDate
     *
     * @return void
     */
    public function setDueDate(DueDate $dueDate): void
    {
        $this->dueDate = $dueDate;
    }

    /**
     * @param bool $isDone
     *
     * @return void
     */
    public function setIsDone(bool $isDone): void
    {
        $this->isDone = $isDone;
    }

    /**
     * @param bool $isArchived
     *
     * @return void
     */
    public function setIsArchived(bool $isArchived): void
    {
        $this->isArchived = $isArchived;
    }
}
