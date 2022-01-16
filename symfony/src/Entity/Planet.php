<?php

namespace App\Entity;

use App\Model\Coordinate;
use Exception;

class Planet
{
    private $size;
    private $obstacles;

    /**
     * @throws Exception
     */
    public function __construct(int $size, int $obstaclesAmount = 0)
    {
        $this->size = $size;
        $this->generateObstacles($obstaclesAmount);
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function setSize(int $size): void
    {
        $this->size = $size;
    }

    public function getObstacles(): ?array
    {
        return $this->obstacles;
    }

    public function setObstacles(array $obstacles): void
    {
        $this->obstacles = $obstacles;
    }

    /**
     * @throws Exception
     */
    private function generateObstacles(int $amount): void
    {
        $this->obstacles = [];
        for ($i = 0; $i < $amount; $i++) {
            $this->obstacles[] = new Coordinate(random_int(0, $this->size - 1), random_int(0, $this->size - 1));
        }
    }

    public function isObstacle(Coordinate $coordinate): bool
    {
        return in_array($coordinate, $this->obstacles, true);
    }

    public function isInBounds(Coordinate $coordinate): bool
    {
        return $coordinate->getX() >= 0 && $coordinate->getX() < $this->size
            && $coordinate->getY() >= 0 && $coordinate->getY() < $this->size;
    }
}
