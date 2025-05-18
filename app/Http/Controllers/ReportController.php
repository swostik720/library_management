<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin,librarian');
    }

    public function index()
    {
        return view('reports.index');
    }

    public function mostBorrowedBooks(Request $request)
    {
        $period = $request->get('period', 'month');
        $limit = $request->get('limit', 10);

        $startDate = $this->getStartDate($period);

        $books = DB::table('transactions')
            ->join('books', 'transactions.book_id', '=', 'books.id')
            ->select('books.id', 'books.title', 'books.author', DB::raw('COUNT(transactions.id) as borrow_count'))
            ->where('transactions.created_at', '>=', $startDate)
            ->groupBy('books.id', 'books.title', 'books.author')
            ->orderBy('borrow_count', 'desc')
            ->limit($limit)
            ->get();

        return view('reports.most-borrowed', compact('books', 'period', 'limit'));
    }

    public function overdueList()
    {
        $overdueTransactions = Transaction::whereNull('return_date')
            ->where('due_date', '<', Carbon::now())
            ->with(['user', 'book'])
            ->orderBy('due_date')
            ->get();

        return view('reports.overdue-list', compact('overdueTransactions'));
    }

    public function userActivity(Request $request)
    {
        $period = $request->get('period', 'month');
        $startDate = $this->getStartDate($period);

        $users = User::where('role', 'member')
            ->withCount(['transactions' => function ($query) use ($startDate) {
                $query->where('created_at', '>=', $startDate);
            }])
            ->orderBy('transactions_count', 'desc')
            ->limit(10)
            ->get();

        return view('reports.user-activity', compact('users', 'period'));
    }

    public function categoryPopularity()
    {
        $categories = DB::table('categories')
            ->leftJoin('books', 'categories.id', '=', 'books.category_id')
            ->leftJoin('transactions', 'books.id', '=', 'transactions.book_id')
            ->select('categories.name', DB::raw('COUNT(DISTINCT books.id) as book_count'), DB::raw('COUNT(transactions.id) as transaction_count'))
            ->groupBy('categories.name')
            ->orderBy('transaction_count', 'desc')
            ->get();

        return view('reports.category-popularity', compact('categories'));
    }

    private function getStartDate($period)
    {
        switch ($period) {
            case 'week':
                return Carbon::now()->subWeek();
            case 'month':
                return Carbon::now()->subMonth();
            case 'quarter':
                return Carbon::now()->subMonths(3);
            case 'year':
                return Carbon::now()->subYear();
            default:
                return Carbon::now()->subMonth();
        }
    }
}
