<?php

declare(strict_types=1);

class Library implements Borrowable
{
    private array $books = [];
    private array $loans = [];
    private int $returnedCount = 0;

    //function to add book
    public function addBook(Book $book): void
    {
        $this->books[$book->getIsbn()] = $book;
    }

    //getter for book isbn
    public function getBookByIsbn(string $isbn): Book
    {
        if (!isset($this->books[$isbn])) throw new Exception("Book ISBN $isbn not found.");
        return $this->books[$isbn];
    }

    // function to borrow a book
    public function borrowItem(Book $book, Member $member): void
    {
        if (!$book->checkAvailability()) throw new Exception("\nBorrow FAILED: Book already out.\n");
        if (!$member->canBorrow()) throw new Exception("\nBorrow FAILED: Limit reached.\n");

        $book->setAvailability(false);
        $member->addLoan($book->getIsbn());
        $this->loans[$book->getIsbn()] = new Loan($book, $member, new DateTime());

        echo "\nBorrow SUCCESS\n\n";
    }

    //function to return a borrowed book
    public function returnItem(string $isbn): void
    {
        if (!isset($this->loans[$isbn])) throw new Exception("\nReturn FAILED: No active loan.\n\n");

        $book = $this->books[$isbn];
        $member = $this->loans[$isbn]->getMember();

        $book->setAvailability(true);
        $member->removeLoan($isbn);
        unset($this->loans[$isbn]);
        $this->returnedCount++;

        echo " \nReturn SUCCESS\n\n";
    }

    //function to show an available books
    public function showAvailableBooks(): void
    {
        echo "\nAvailable Books List:\n\n";
        $available = array_filter($this->books, fn($b) => $b->checkAvailability());

        if (empty($available)) {
            echo "No books currently available\n";
        } else {
            foreach ($available as $book) {
                echo "   • [" . $book->getIsbn() . "] " . $book->getTitle() . "\n\n";
            }
        }
    }

    // function to show member loans (logged in members only)
    public function showMemberLoans(Member $member): void
    {
        echo "\n=== Your Active Loans ===\n";
        $hasLoans = false;

        foreach ($this->loans as $isbn => $loan) {
            // Check if the loan belongs to the current account ID
            if ($loan->getMember()->getAccountId() === $member->getAccountId()) {
                echo "   • [" . $isbn . "] " . $loan->getDetails() . "\n\n";
                $hasLoans = true;
            }
        }

        if (!$hasLoans) {
            echo "   \nYou have no active loans\n\n";
        }
    }

    // function to show all totals
    public function showTotals(): void
    {
        $activeCount = count($this->loans);
        $availableCount = count(array_filter($this->books, fn($b) => $b->checkAvailability()));

        echo "\n Totals:\n";
        echo "   - Total books: " . count($this->books) . "\n";
        echo "   - Available books: " . $availableCount . "\n";
        echo "   - Total loans: " . ($activeCount + $this->returnedCount) . "\n";
        echo "   - Active loans: " . $activeCount . "\n";
        echo "   - Returned loans: " . $this->returnedCount . "\n\n";
    }
}
