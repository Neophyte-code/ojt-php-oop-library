<?php

declare(strict_types=1);

abstract class Member
{
    protected array $currentLoans = [];
    protected string $name;
    protected string $accountId;

    public function __construct(string $name, string $accountId)
    {
        $this->name = $name;
        $this->accountId = $accountId;
    }

    //getter function account ID
    public function getAccountId(): string
    {
        return $this->accountId;
    }

    //getter function for name
    public function getName(): string
    {
        return $this->name;
    }

    //abstract function (mandatory implementation for child class)
    abstract public function canBorrow(): bool;

    //function for adding loan
    public function addLoan(string $isbn): void
    {
        $this->currentLoans[] = $isbn;
    }

    //function for removing loan
    public function removeLoan(string $isbn): void
    {
        $this->currentLoans = array_filter($this->currentLoans, fn($i) => $i !== $isbn);
    }

    //function for counting loan
    public function getLoanCount(): int
    {
        return count($this->currentLoans);
    }
}
