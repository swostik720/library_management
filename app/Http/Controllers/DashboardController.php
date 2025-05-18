<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (Auth::user()->isAdmin() || Auth::user()->isLibrarian()) {
            return $this->adminDashboard();
        } else {
            return $this->memberDashboard();
        }
    }

    private function adminDashboard()
    {
        // Total counts
        $totalBooks = Book::count();
        $totalMembers = User::where('role', 'member')->count();
        $totalTransactions = Transaction::count();
        $overdueCount = Transaction::whereNull('return_date')
            ->where('due_date', '<', Carbon::now())
            ->count();

        // Books by category
        $booksByCategory = DB::table('categories')
            ->join('books', 'categories.id', '=', 'books.category_id')
            ->select('categories.name', DB::raw('COUNT(books.id) as count'))
            ->groupBy('categories.name')
            ->orderBy('count', 'desc')
            ->get();

        // Recent transactions
        $recentTransactions = Transaction::with(['user', 'book'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Books with low stock
        $lowStockBooks = Book::where('available_copies', '<', 3)
            ->orderBy('available_copies')
            ->limit(5)
            ->get();

        return view('dashboard.admin', compact(
            'totalBooks',
            'totalMembers',
            'totalTransactions',
            'overdueCount',
            'booksByCategory',
            'recentTransactions',
            'lowStockBooks'
        ));
    }

    private function memberDashboard()
    {
        $userId = Auth::id();

        // Current borrowed books
        $currentBorrowings = Transaction::where('user_id', $userId)
            ->whereNull('return_date')
            ->with('book')
            ->get();

        // Overdue books
        $overdueBooks = Transaction::where('user_id', $userId)
            ->whereNull('return_date')
            ->where('due_date', '<', Carbon::now())
            ->with('book')
            ->get();

        // Borrowing history
        $borrowingHistory = Transaction::where('user_id', $userId)
            ->whereNotNull('return_date')
            ->with('book')
            ->orderBy('return_date', 'desc')
            ->limit(5)
            ->get();

        // Total fine amount
        $totalFine = Transaction::where('user_id', $userId)
            ->sum('fine');

        return view('dashboard.member', compact(
            'currentBorrowings',
            'overdueBooks',
            'borrowingHistory',
            'totalFine'
        ));
    }
}
