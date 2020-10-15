<?php declare(strict_types=1);

namespace monoclus\db;

use PDOException;
use PHPUnit\Framework\TestCase;


final class UpdateTest extends TestCase
{
    use LoggingTrait;

    public function test_simpleUpdate()
    {
        $res = Connection::create()
            ->setLogger($this->logger())
            ->table('a')
            ->filter(['a' => 2])
            ->update(['b' => 3]);
        self::assertTrue($res);
    }

    public function test_updateTooManyColumns()
    {
        $this->expectException(PDOException::class);
        Connection::create()
            ->setLogger($this->logger())
            ->table('a')
            ->filter(['a' => 1])
            ->update([
                'b' => 2,
                'c' => 2,
                'd' => 2,
                'e' => 2,
                'f' => 2,
                'g' => 2,
            ]);
    }
}
