<?php

declare(strict_types=1);

// Standard requires (assuming files are in src/)
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

// Pre-defined Accounts
$accounts = [
    "std_01" => new StudentMember("Jerwin (Student)", "std_01"),
    "reg_01" => new RegularMember("Alice (Regular)", "reg_01")
];

$currentUser = null;

// --- LOGIN PHASE ---
while ($currentUser === null) {
    echo "\n=== LIBRARY LOGIN ===\n";
    echo "Please enter your Account ID: ";
    $input = trim(fgets(STDIN));

    if (isset($accounts[$input])) {
        $currentUser = $accounts[$input];
        echo "Welcome back, " . $currentUser->getName() . "!\n";
    } else {
        echo "Error: Account ID not found. Try 'std_01' or 'reg_01'.\n";
    }
}

// --- MAIN PROGRAM PHASE ---
while (true) {
    echo "\nLogged in as: " . $currentUser->getName() . "\n";
    echo "1. Borrow a Book\n";
    echo "2. Return a Book\n";
    echo "3. System Report (ABCD)\n";
    echo "4. Logout & Exit\n";
    echo "Choice: ";

    $choice = trim(fgets(STDIN));

    if ($choice === '4') break;

    switch ($choice) {
        case '1':
            echo "Enter Book ISBN: ";
            $isbn = trim(fgets(STDIN));
            try {
                $book = $lib->getBookByIsbn($isbn);
                $lib->borrowItem($book, $currentUser); // Automatically uses logged-in user
            } catch (Exception $e) {
                echo "A) Action Logs:\n- " . $e->getMessage() . PHP_EOL;
            }
            break;

        case '2':
            echo "Enter ISBN to return: ";
            $isbn = trim(fgets(STDIN));
            try {
                $lib->returnItem($isbn);
            } catch (Exception $e) {
                echo "- " . $e->getMessage() . PHP_EOL;
            }
            break;

        case '3':
            // Pass the $accounts array so it can see all members for the report
            $lib->displayFullReport($accounts);
            break;
    }
}
