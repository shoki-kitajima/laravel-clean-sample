<?php
namespace packages\Domain;

final class TaskId
{
    /**
     * @var ?int
     */
    private $id;


    /**
     * @param int|null $id
     */
    public function __construct(?int $id)
    {
        if (is_int($id) && $int < 0) {
            throw new InvalidArgumentException('task id must be integer more than 0');
        }
        $this->id = $id;
    }

    public function value()
    {
        return $this->id;
    }
}
