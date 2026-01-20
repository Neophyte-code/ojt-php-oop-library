<?php

declare(strict_types=1);

abstract class Member
{
    protected array $currentLoans = [];

    public function __construct(
        protected string $name,
        protected string $accountId
    ) {}

    public function getAccountId(): string
    {
        return $this->accountId;
    }
    public function getName(): string
    {
        return $this->name;
    }

    abstract public function canBorrow(): bool;

    public function addLoan(string $isbn): void
    {
        $this->currentLoans[] = $isbn;
    }
    public function removeLoan(string $isbn): void
    {
        $this->currentLoans = array_filter($this->currentLoans, fn($i) => $i !== $isbn);
    }
    public function getLoanCount(): int
    {
        return count($this->currentLoans);
    }
}
