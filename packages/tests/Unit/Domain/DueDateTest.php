<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Packages\Domain\DueDate;

class DueDateTest extends TestCase
{
    public function test_日付以外の文字列をコンストラクタに投げると弾かれるか()
    {
        $this->expectException(\Exception::class);
        new DueDate('abcde');
    }

    public function test_日付を指定形式へフォーマットできるか()
    {
        $obj = new DueDate('2020/01/01');
        $this->assertSame($obj->value(), '2020-01-01 00:00:00');
    }

    public function test_期限切れ判定ができるか()
    {
        $obj = new DueDate('2020/01/01');
        $this->assertTrue($obj->isExpired());
        $obj = new DueDate('3100/01/01');
        $this->assertFalse($obj->isExpired());
    }
}
