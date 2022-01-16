<?php

namespace App\Tests\Entity;

use App\Entity\Rover;
use App\Model\Coordinate;
use PHPUnit\Framework\TestCase;

class RoverTest extends TestCase
{
    public function testTurnLeft()
    {
        $coordinate = new Coordinate(0, 0);
        $rover = new Rover($coordinate, 'N');
        $rover->turnLeft();
        $this->assertEquals('W', $rover->getDirection());
    }

    public function testTurnRight()
    {
        $coordinate = new Coordinate(0, 0);
        $rover = new Rover($coordinate, 'N');
        $rover->turnRight();
        $this->assertEquals('E', $rover->getDirection());
    }

    public function testMoveForward()
    {
        $coordinate = new Coordinate(0, 0);
        $rover = new Rover($coordinate, 'N');
        $rover->moveForward();
        $this->assertEquals(1, $rover->getPosition()->getY());
        $this->assertEquals(0, $rover->getPosition()->getX());
        $this->assertEquals('N', $rover->getDirection());

        $rover->setDirection('E');
        $rover->moveForward();
        $this->assertEquals(1, $rover->getPosition()->getX());
        $this->assertEquals(1, $rover->getPosition()->getY());
    }
}
