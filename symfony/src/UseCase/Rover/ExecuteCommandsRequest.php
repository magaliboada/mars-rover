<?php

namespace App\UseCase\Rover;

use App\Entity\Planet;
use App\Entity\Rover;
use App\Model\UseCase\UseCaseRequestInterface;

class ExecuteCommandsRequest implements UseCaseRequestInterface
{
    private $commands;
    private $rover;
    private $planet;

    public function getPlanet(): ?Planet
    {
        return $this->planet;
    }

    public function setPlanet(Planet $planet): void
    {
        $this->planet = $planet;
    }

    public function getCommands(): ?string
    {
        return $this->commands;
    }

    public function setCommands(string $commands): void
    {
        $this->commands = $commands;
    }

    public function getRover(): ?Rover
    {
        return $this->rover;
    }

    public function setRover(Rover $rover): void
    {
        $this->rover = $rover;
    }

}