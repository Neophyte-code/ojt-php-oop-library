<?php

declare(strict_types=1);

class Loan
{
    private DateTime $loanDate;

    public function __construct(
        private Book $book,
        private Member $member
    ) {
        $this->loanDate = new DateTime();
    }

    public function getDetails(): string
    {
        return $this->book->getTitle();
    }

    public function getMember(): Member
    {
        return $this->member;
    }

    public function getBook(): Book
    {
        return $this->book;
    }
}
