<?php

namespace App\Entity;

use App\Infrastructure\MovementInterface;
use App\Model\Coordinate;

class Rover implements MovementInterface
{
    private $position;
    private $direction;
    private const DIRECTIONS = ['N', 'E', 'S', 'W'];

    public function __construct(Coordinate $position, string $direction)
    {
        $this->position = $position;
        $this->direction = $direction;
    }

    public function getPosition(): Coordinate
    {
        return $this->position;
    }

    public function setPosition(Coordinate $position): void
    {
        $this->position = $position;
    }

    public function getDirection(): string
    {
        return $this->direction;
    }

    public function setDirection(string $direction): void
    {
        $this->direction = $direction;
    }

    public function moveForward() :void
    {
        switch ($this->direction) {
            case 'N':
                $this->position->setY($this->position->getY() + 1);
                break;
            case 'E':
                $this->position->setX($this->position->getX() + 1);
                break;
            case 'S':
                $this->position->setY($this->position->getY() - 1);
                break;
            case 'W':
                $this->position->setX($this->position->getX() - 1);
                break;
        }
    }

    public function turnLeft() :void
    {
        if($this->direction === 'N') {
            $this->direction = 'W';
        } else {
            $this->direction = self::DIRECTIONS[array_search($this->direction, self::DIRECTIONS) - 1];
        }
    }

    public function turnRight() :void
    {
        if($this->direction === 'W') {
            $this->direction = 'N';
        } else {
            $this->direction = self::DIRECTIONS[array_search($this->direction, self::DIRECTIONS) + 1];
        }
    }
}
