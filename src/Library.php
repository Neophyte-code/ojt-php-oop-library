<?php

declare(strict_types=1);

class Library implements Borrowable
{
    private array $books = [];
    private array $loans = [];
    private int $returnedCount = 0;

    public function addBook(Book $book): void
    {
        $this->books[$book->getIsbn()] = $book;
    }

    public function getBookByIsbn(string $isbn): Book
    {
        if (!isset($this->books[$isbn])) throw new Exception("Book ISBN $isbn not found.");
        return $this->books[$isbn];
    }

    // A) Action Logs logic
    public function borrowItem(Book $book, Member $member): void
    {
        if (!$book->checkAvailability()) throw new Exception("Borrow FAILED: Book already out.");
        if (!$member->canBorrow()) throw new Exception("Borrow FAILED: Limit reached.");

        $book->setAvailability(false);
        $member->addLoan($book->getIsbn());
        $this->loans[$book->getIsbn()] = new Loan($book, $member, new DateTime());

        echo "- Borrow SUCCESS\n";
    }

    public function returnItem(string $isbn): void
    {
        if (!isset($this->loans[$isbn])) throw new Exception("Return FAILED: No active loan.");

        $book = $this->books[$isbn];
        $member = $this->loans[$isbn]->getMember(); // Need getter in Loan

        $book->setAvailability(true);
        $member->removeLoan($isbn);
        unset($this->loans[$isbn]);
        $this->returnedCount++;

        echo "- Return SUCCESS\n";
    }

    public function displayFullReport(array $members): void
    {
        echo "\n------------------------------------------\n";

        // B) Available Books
        echo "B) Available Books List:\n";
        foreach ($this->books as $book) {
            if ($book->checkAvailability()) echo "   • [" . $book->getIsbn() . "] " . $book->getTitle() . "\n";
        }

        // C) Active Loans per Member
        echo "\nC) Active Loans per Member:\n";
        foreach ($members as $m) {
            echo "   • " . $m->getName() . " (ID: " . $m->getId() . "): " . $m->getLoanCount() . " books\n";
        }

        // D) Totals
        $activeCount = count($this->loans);
        $availableCount = count(array_filter($this->books, fn($b) => $b->checkAvailability()));

        echo "\nD) Totals:\n";
        echo "   - Total books: " . count($this->books) . "\n";
        echo "   - Available books: " . $availableCount . "\n";
        echo "   - Total loans (Life): " . ($activeCount + $this->returnedCount) . "\n";
        echo "   - Active loans: " . $activeCount . "\n";
        echo "   - Returned loans: " . $this->returnedCount . "\n";
        echo "------------------------------------------\n";
    }
}
