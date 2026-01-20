<?php

declare(strict_types=1);

class Book
{
    private bool $isAvailable = true;

    public function __construct(
        private string $isbn,
        private string $title
    ) {}

    public function getIsbn(): string
    {
        return $this->isbn;
    }
    public function getTitle(): string
    {
        return $this->title;
    }
    public function checkAvailability(): bool
    {
        return $this->isAvailable;
    }

    public function setAvailability(bool $status): void
    {
        $this->isAvailable = $status;
    }
}
