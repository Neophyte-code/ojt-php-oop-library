<?php

declare(strict_types=1);

class Book
{
    private bool $isAvailable = true;
    private string $isbn;
    private string $title;

    public function __construct(string $isbn, string $title)
    {
        $this->isbn = $isbn;
        $this->title = $title;
    }

    //isbn property getter function
    public function getIsbn(): string
    {
        return $this->isbn;
    }

    //title property getter function
    public function getTitle(): string
    {
        return $this->title;
    }

    //function to check the availability of the book
    public function checkAvailability(): bool
    {
        return $this->isAvailable;
    }

    //isAvailable property setter function
    public function setAvailability(bool $status): void
    {
        $this->isAvailable = $status;
    }
}
