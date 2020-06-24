<?php
namespace packages\Domain;

use DateTimeImmutable;

final class DueDate
{
    /**
     * @var string
     */
    private $dueDate;

    /**
     * @param string $dateTime
     */
    public function __construct(string $dateTime)
    {
        $this->dueDate = new DateTimeImmutable($dateTime);
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->dueDate->format('Y-m-d H:i:s');
    }
}
