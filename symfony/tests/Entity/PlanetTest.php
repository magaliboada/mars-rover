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
}
