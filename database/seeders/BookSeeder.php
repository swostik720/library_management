<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();

        // Fiction Books
        $fictionCategory = Category::where('name', 'Fiction')->first();
        $this->createBook(
            'To Kill a Mockingbird',
            'Harper Lee',
            '9780061120084',
            $fictionCategory->id,
            10,
            'A novel about racial inequality in the American South during the 1930s.',
            1960,
            'HarperCollins'
        );

        $this->createBook(
            'Pride and Prejudice',
            'Jane Austen',
            '9780141439518',
            $fictionCategory->id,
            8,
            'A romantic novel of manners that follows the character development of Elizabeth Bennet.',
            1813,
            'Penguin Classics'
        );

        // Science Fiction Books
        $scifiCategory = Category::where('name', 'Science Fiction')->first();
        $this->createBook(
            'Dune',
            'Frank Herbert',
            '9780441172719',
            $scifiCategory->id,
            12,
            'A science fiction novel set in the distant future amidst a feudal interstellar society.',
            1965,
            'Ace Books'
        );

        $this->createBook(
            'The Hitchhiker\'s Guide to the Galaxy',
            'Douglas Adams',
            '9780345391803',
            $scifiCategory->id,
            15,
            'A comedy science fiction series following the adventures of Arthur Dent.',
            1979,
            'Del Rey'
        );

        // Computer Science Books
        $csCategory = Category::where('name', 'Computer Science')->first();
        $this->createBook(
            'Clean Code: A Handbook of Agile Software Craftsmanship',
            'Robert C. Martin',
            '9780132350884',
            $csCategory->id,
            7,
            'A book about writing clean, maintainable code.',
            2008,
            'Prentice Hall'
        );

        $this->createBook(
            'Design Patterns: Elements of Reusable Object-Oriented Software',
            'Erich Gamma, Richard Helm, Ralph Johnson, John Vlissides',
            '9780201633610',
            $csCategory->id,
            5,
            'A software engineering book describing software design patterns.',
            1994,
            'Addison-Wesley Professional'
        );

        // History Books
        $historyCategory = Category::where('name', 'History')->first();
        $this->createBook(
            'Sapiens: A Brief History of Humankind',
            'Yuval Noah Harari',
            '9780062316097',
            $historyCategory->id,
            9,
            'A book that explores the history of the human species from the evolution of archaic human species.',
            2011,
            'Harper'
        );

        // Self-Help Books
        $selfHelpCategory = Category::where('name', 'Self-Help')->first();
        $this->createBook(
            'Atomic Habits',
            'James Clear',
            '9780735211292',
            $selfHelpCategory->id,
            6,
            'A guide to building good habits and breaking bad ones.',
            2018,
            'Avery'
        );

        // Generate more random books
        foreach ($categories as $category) {
            $numBooks = rand(1, 3); // 1-3 books per category
            for ($i = 0; $i < $numBooks; $i++) {
                $totalCopies = rand(3, 20);
                Book::create([
                    'title' => 'Sample ' . $category->name . ' Book ' . ($i + 1),
                    'author' => 'Author ' . rand(1, 100),
                    'isbn' => '978' . rand(1000000000, 9999999999),
                    'category_id' => $category->id,
                    'total_copies' => $totalCopies,
                    'available_copies' => $totalCopies,
                    'description' => 'This is a sample book in the ' . $category->name . ' category.',
                    'published_year' => rand(1950, 2023),
                    'publisher' => 'Publisher ' . rand(1, 20),
                ]);
            }
        }
    }

    /**
     * Helper method to create a book with all details
     */
    private function createBook($title, $author, $isbn, $categoryId, $copies, $description, $year, $publisher)
    {
        Book::create([
            'title' => $title,
            'author' => $author,
            'isbn' => $isbn,
            'category_id' => $categoryId,
            'total_copies' => $copies,
            'available_copies' => $copies,
            'description' => $description,
            'published_year' => $year,
            'publisher' => $publisher,
        ]);
    }
}
