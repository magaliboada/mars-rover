<?php

namespace App\Model;

class Coordinate
{
    private $X;
    private $Y;

    public function __construct(int $X, int $Y)
    {
        $this->X = $X;
        $this->Y = $Y;
    }

    public function getX(): int
    {
        return $this->X;
    }

    public function getY(): int
    {
        return $this->Y;
    }

    public function setX(int $X): void
    {
        $this->X = $X;
    }

    public function setY(int $Y): void
    {
        $this->Y = $Y;
    }

}