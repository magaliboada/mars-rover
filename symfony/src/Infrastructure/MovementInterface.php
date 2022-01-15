<?php

namespace App\Infrastructure;

interface MovementInterface
{
    public function moveForward(): void;

    public function turnLeft(): void;

    public function turnRight(): void;
}