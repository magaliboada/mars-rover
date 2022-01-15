<?php

namespace App\Model\UseCase;

interface UseCaseInterface
{
    public function execute(UseCaseRequestInterface $request): UseCaseResponseInterface;
}
