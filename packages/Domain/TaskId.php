<?php
namespace packages\Domain;

final class TaskId
{
    /**
     * @var ?int
     */
    private $id;


    /**
     * 文字列型の数値'1234'を投げると暗黙的にintへキャストしてしまうので注意
     * @param int|null $id
     */
    public function __construct(?int $id)
    {
        if (is_null($id)) {
            $this->id = $id;
            return;
        }
        if (!is_int($id)) {
            throw new \InvalidArgumentException('task id must be an integer or null');
        }

        if ($id < 1) {
            throw new \InvalidArgumentException('task id must be an integer more than 1');
        }
        $this->id = $id;
    }

    public function value()
    {
        return $this->id;
    }
}
