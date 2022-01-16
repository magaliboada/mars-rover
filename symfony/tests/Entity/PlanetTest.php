<?php

namespace App\Tests\Entity;

use App\Entity\Planet;
use App\Model\Coordinate;
use PHPUnit\Framework\TestCase;

class PlanetTest extends TestCase
{
    public function testGenerateObstacles(): void
    {
        $planet = new Planet(100, 5);

        self::assertCount(5, $planet->getObstacles());
        self::assertInstanceOf(Coordinate::class, $planet->getObstacles()[0]);
    }

    public function testisObstacle(): void
    {
        $coordinate = new Coordinate(1, 1);
        $planet = new Planet(5); $planet->setObstacles([$coordinate]);

        self::assertTrue($planet->isObstacle($coordinate));
    }

    public function testisNotObstacle(): void
    {
        $coordinate = new Coordinate(1, 1);
        $planet = new Planet(5); $planet->setObstacles([$coordinate]);

        self::assertFalse($planet->isObstacle(new Coordinate(2, 2)));
    }

    public function testIsInBounds(): void
    {
        $planet = new Planet(5);

        self::assertTrue($planet->isInBounds(new Coordinate(0, 0)));
        self::assertTrue($planet->isInBounds(new Coordinate(4, 4)));
        self::assertFalse($planet->isInBounds(new Coordinate(-1, 0)));
        self::assertFalse($planet->isInBounds(new Coordinate(0, -1)));
        self::assertFalse($planet->isInBounds(new Coordinate(5, 0)));
        self::assertFalse($planet->isInBounds(new Coordinate(0, 5)));
    }
}
