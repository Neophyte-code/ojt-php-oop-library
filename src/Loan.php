<?php

declare(strict_types=1);

class Loan
{
    public function __construct(
        private Book $book,
        private Member $member,
        private DateTime $date
    ) {}

    public function getDetails(): string
    {
        return "{$this->book->getTitle()} borrowed by {$this->member->getName()}";
    }
}
