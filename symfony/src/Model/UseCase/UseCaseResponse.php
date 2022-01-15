<?php

namespace App\Model\UseCase;

class UseCaseResponse implements UseCaseResponseInterface
{
    private $status;
    private $errorMessage;

    public function getMessage(): ?string
    {
        return $this->errorMessage;
    }

    public function setMessage(?string $message): void
    {
        $this->errorMessage = $message;
    }

    public function isOk(): bool
    {
        return $this->getStatus() < UseCaseResponseInterface::HTTP_BAD_REQUEST;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status): void
    {
        $this->status = $status;
    }
}
