<?php
namespace Packages\Domain;

use DateTimeImmutable;

/**
 * DueDateオブジェクト
 */
final class DueDate
{
    const STRING_FORMAT = 'Y-m-d H:i:s';

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
        return $this->dueDate->format(self::STRING_FORMAT);
    }

    /**
     * @return bool
     */
    public function isExpired(): bool
    {
        return $this->dueDate < new DateTimeImmutable();
    }
}
