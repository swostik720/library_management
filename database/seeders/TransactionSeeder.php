<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all members
        $members = User::where('role', 'member')->get();

        // Get all books
        $books = Book::all();

        // Create some active transactions (books currently borrowed)
        foreach ($members as $member) {
            // Each member borrows 1-3 books
            $numBooks = rand(1, 3);
            $borrowedBooks = $books->random($numBooks);

            foreach ($borrowedBooks as $book) {
                // Skip if no copies available
                if ($book->available_copies <= 0) {
                    continue;
                }

                // Create transaction
                $issueDate = Carbon::now()->subDays(rand(1, 30));

                // 30% chance of being overdue
                $isOverdue = rand(1, 100) <= 30;
                $dueDate = $isOverdue
                    ? Carbon::now()->subDays(rand(1, 10))
                    : Carbon::now()->addDays(rand(1, 14));

                Transaction::create([
                    'user_id' => $member->id,
                    'book_id' => $book->id,
                    'issue_date' => $issueDate,
                    'due_date' => $dueDate,
                    'return_date' => null,
                    'fine' => 0,
                    'status' => $isOverdue ? 'overdue' : 'issued',
                ]);

                // Update book available copies
                $book->available_copies -= 1;
                $book->save();
            }
        }

        // Create some historical transactions (returned books)
        foreach ($members as $member) {
            // Each member has returned 2-5 books in the past
            $numBooks = rand(2, 5);
            $returnedBooks = $books->random($numBooks);

            foreach ($returnedBooks as $book) {
                // Create transaction with return date
                $issueDate = Carbon::now()->subDays(rand(15, 60));
                $dueDate = $issueDate->copy()->addDays(14);
                $returnDate = $dueDate->copy()->subDays(rand(-10, 10)); // Some returned late, some early

                // Calculate fine if returned late
                $fine = 0;
                if ($returnDate->gt($dueDate)) {
                    $daysLate = $returnDate->diffInDays($dueDate);
                    $fine = $daysLate * 5; // $5 per day
                }

                Transaction::create([
                    'user_id' => $member->id,
                    'book_id' => $book->id,
                    'issue_date' => $issueDate,
                    'due_date' => $dueDate,
                    'return_date' => $returnDate,
                    'fine' => $fine,
                    'status' => $returnDate->gt($dueDate) ? 'overdue' : 'returned',
                ]);
            }
        }
    }
}
