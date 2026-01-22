<?php

declare(strict_types=1);

require_once 'src/Borrowable.php';
require_once 'src/Book.php';
require_once 'src/Member.php';
require_once 'src/StudentMember.php';
require_once 'src/RegularMember.php';
require_once 'src/Loan.php';
require_once 'src/Library.php';

$lib = new Library();
$lib->addBook(new Book("101", "PHP Mastery"));
$lib->addBook(new Book("102", "OOP Pillars"));
$lib->addBook(new Book("103", "JAVA Zero to Hero"));

// Pre-defined Accounts
$accounts = [
    //student member
    "std_01" => new StudentMember("Jerwin", "std_01"),
    //regular member
    "reg_01" => new RegularMember("John", "reg_01")
];

$currentUser = null;

// LOGIN PHASE 
while ($currentUser === null) {
    echo "\n=== LIBRARY LOGIN ===\n";
    echo "Please enter your Account ID: ";
    $input = trim(fgets(STDIN));

    if (isset($accounts[$input])) {
        $currentUser = $accounts[$input];
        echo "\nWelcome back, " . $currentUser->getName() . "!\n";
    } else {
        echo "Error: Account ID not found.\n";
    }
}

// MAIN PROGRAM PHASE
while (true) {
    echo "1. Borrow a Book\n";
    echo "2. Return a Book\n";
    echo "3. Available Books\n";
    echo "4. Active Loans\n";
    echo "5. Totals\n";
    echo "6. Exit\n";
    echo "Choice: ";

    $choice = trim(fgets(STDIN));
    if ($choice === '6') break;

    switch ($choice) {
        case '1':
            $lib->showAvailableBooks();
            echo "\nEnter Book ISBN: ";
            $isbn = trim(fgets(STDIN));
            try {
                $book = $lib->getBookByIsbn($isbn);
                $lib->borrowItem($book, $currentUser);
            } catch (Exception $e) {
                echo "- " . $e->getMessage() . PHP_EOL;
            }
            break;

        case '2':
            $lib->showMemberLoans($currentUser);
            echo "Enter ISBN to return: ";
            $isbn = trim(fgets(STDIN));
            try {
                $lib->returnItem($isbn);
            } catch (Exception $e) {
                echo "- " . $e->getMessage() . PHP_EOL;
            }
            break;

        case '3':
            $lib->showAvailableBooks();
            break;

        case '4':
            $lib->showMemberLoans($currentUser);
            break;

        case '5':
            $lib->showTotals();
            break;

        default:
            echo "\nInvalid option.\n\n";
    }
}
