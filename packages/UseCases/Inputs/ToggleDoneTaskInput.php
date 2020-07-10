<?php
namespace Packages\UseCases\Inputs;

class ToggleDoneTaskInput
{
    /**
     * @var int
     */
    private $id;

    /**
     */
    public function __construct(int $id)
    {
    }

    /**
     * @return int
     */
    public function id(): int
    {
        return $this->id();
    }
}
