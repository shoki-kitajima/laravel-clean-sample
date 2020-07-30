<?php
namespace Packages\Domain;

/**
 * タスク名オブジェクト
 */
final class TaskName
{
    /**
     * @var string
     */
    private $name;

    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        if (mb_ereg_match("^(\s|　)+$", $name)) {
            throw new \InvalidArgumentException('Task name must contain a non-blank string');
        }
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->name;
    }
}
