<?php declare(strict_types=1);

namespace monoclus\db;

use PDOException;
use PHPUnit\Framework\TestCase;


final class InsertTest extends TestCase
{
    use LoggingTrait;

    public function test_simpleInsert()
    {
        $res = Connection::create()
            ->setLogger($this->logger())
            ->table('a')
            ->insert(['a' => 2]);
        self::assertTrue($res);
    }

    public function test_InsertTooManyColumns()
    {
        $this->expectException(PDOException::class);
        Connection::create()
            ->setLogger($this->logger())
            ->table('a')
            ->insert([
                'a' => 2,
                'b' => 2,
                'c' => 2,
                'd' => 2,
                'e' => 2,
                'f' => 2,
                'g' => 2,
            ]);
    }
}
