<?php

declare(strict_types=1);

class Loan
{
    private DateTime $loanDate;
    private Book $book;
    private Member $member;

    public function __construct(Book $book, Member $member)
    {
        $this->book = $book;
        $this->member = $member;
        $this->loanDate = new DateTime();
    }

    //getter function details
    public function getDetails(): string
    {
        return $this->book->getTitle();
    }

    //getter function for member
    public function getMember(): Member
    {
        return $this->member;
    }

    //getter function for books
    public function getBook(): Book
    {
        return $this->book;
    }
}
