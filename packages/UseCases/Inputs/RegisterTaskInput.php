<?php
namespace Packages\UseCases\Inputs;

class RegisterTaskInput
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $dueDate;

    /**
     * @param string $name
     * @param string $dueDate
     */
    public function __construct(string $name, string $dueDate)
    {
        $this->name = $name;
        $this->dueDate = $dueDate;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function dueDate(): string
    {
        return $this->dueDate;
    }
}
