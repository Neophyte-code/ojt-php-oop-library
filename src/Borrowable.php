<?php

declare(strict_types=1);

interface Borrowable
{
    public function borrowItem(Book $book, Member $member): void;
    public function returnItem(string $isbn): void;
}
