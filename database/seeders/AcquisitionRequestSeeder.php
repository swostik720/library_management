<?php

namespace Database\Seeders;

use App\Models\AcquisitionRequest;
use App\Models\User;
use Illuminate\Database\Seeder;

class AcquisitionRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $members = User::where('role', 'member')->get();
        $statuses = ['pending', 'approved', 'rejected', 'acquired'];

        $sampleBooks = [
            [
                'title' => 'The Midnight Library',
                'author' => 'Matt Haig',
                'isbn' => '9780525559474'
            ],
            [
                'title' => 'Project Hail Mary',
                'author' => 'Andy Weir',
                'isbn' => '9780593135204'
            ],
            [
                'title' => 'The Four Winds',
                'author' => 'Kristin Hannah',
                'isbn' => '9781250178602'
            ],
            [
                'title' => 'Klara and the Sun',
                'author' => 'Kazuo Ishiguro',
                'isbn' => '9780571364879'
            ],
            [
                'title' => 'The Last Thing He Told Me',
                'author' => 'Laura Dave',
                'isbn' => '9781501171345'
            ],
            [
                'title' => 'The Lincoln Highway',
                'author' => 'Amor Towles',
                'isbn' => '9780735222359'
            ],
            [
                'title' => 'Cloud Cuckoo Land',
                'author' => 'Anthony Doerr',
                'isbn' => '9781982168438'
            ],
        ];

        foreach ($members as $member) {
            // Each member makes 0-2 acquisition requests
            $numRequests = rand(0, 2);

            for ($i = 0; $i < $numRequests; $i++) {
                // Get a random book from the sample list or create a generic one
                if (count($sampleBooks) > 0 && rand(0, 1) == 1) {
                    $bookIndex = array_rand($sampleBooks);
                    $book = $sampleBooks[$bookIndex];
                    unset($sampleBooks[$bookIndex]);
                    $sampleBooks = array_values($sampleBooks);

                    $title = $book['title'];
                    $author = $book['author'];
                    $isbn = $book['isbn'];
                } else {
                    $title = 'Requested Book ' . rand(100, 999);
                    $author = 'Author ' . rand(1, 100);
                    $isbn = '978' . rand(1000000000, 9999999999);
                }

                $status = $statuses[array_rand($statuses)];
                $notes = null;

                if ($status === 'rejected') {
                    $notes = 'This book is out of print and difficult to acquire.';
                } elseif ($status === 'approved') {
                    $notes = 'We will order this book soon.';
                } elseif ($status === 'acquired') {
                    $notes = 'Book has been added to the library collection.';
                }

                AcquisitionRequest::create([
                    'title' => $title,
                    'author' => $author,
                    'isbn' => $isbn,
                    'requested_by' => $member->id,
                    'status' => $status,
                    'notes' => $notes,
                ]);
            }
        }
    }
}
