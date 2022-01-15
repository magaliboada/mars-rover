<?php

namespace App\Model\UseCase;

interface UseCaseResponseInterface
{
    public const HTTP_OK = 200;
    public const HTTP_BAD_REQUEST = 400;
    public const HTTP_INTERNAL_SERVER_ERROR = 500;

    public function setStatus(int $status): void;

    public function getStatus(): int;

    public function setMessage(?string $message): void;

    public function getMessage(): ?string;

    public function isOk(): bool;
}
