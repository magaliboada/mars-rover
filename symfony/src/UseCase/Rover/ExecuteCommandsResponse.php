<?php

namespace App\UseCase\Rover;

use App\Model\Coordinate;
use App\Model\UseCase\UseCaseResponse;

class ExecuteCommandsResponse extends UseCaseResponse
{
    private $roverPosition;
    private $collisionDetected;

    public function getRoverPosition(): Coordinate
    {
        return $this->roverPosition;
    }

    public function setRoverPosition(Coordinate $roverPosition): void
    {
        $this->roverPosition = $roverPosition;
    }

    public function isCollisionDetected(): bool
    {
        return $this->collisionDetected;
    }

    public function setCollisionDetected(bool $collisionDetected): void
    {
        $this->collisionDetected = $collisionDetected;
    }
}