<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin,librarian')->except(['index', 'show', 'userHistory']);
    }

    public function index(Request $request)
    {
        $query = Transaction::with(['user', 'book']);

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by user (for admin/librarian)
        if (Auth::user()->isAdmin() || Auth::user()->isLibrarian()) {
            if ($request->has('user_id') && $request->user_id != '') {
                $query->where('user_id', $request->user_id);
            }
        } else {
            // Regular members can only see their own transactions
            $query->where('user_id', Auth::id());
        }

        $transactions = $query->orderBy('created_at', 'desc')->paginate(10);
        $users = User::where('role', 'member')->get();

        return view('transactions.index', compact('transactions', 'users'));
    }

    public function create()
    {
        $books = Book::where('available_copies', '>', 0)->get();
        $members = User::where('role', 'member')->get();

        return view('transactions.create', compact('books', 'members'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'due_date' => 'required|date|after:today',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $book = Book::findOrFail($request->book_id);

        if ($book->available_copies <= 0) {
            return redirect()->back()
                ->with('error', 'This book is not available for issue.')
                ->withInput();
        }

        // Check if user already has this book
        $existingTransaction = Transaction::where('user_id', $request->user_id)
            ->where('book_id', $request->book_id)
            ->whereNull('return_date')
            ->first();

        if ($existingTransaction) {
            return redirect()->back()
                ->with('error', 'This user already has this book issued.')
                ->withInput();
        }

        // Create transaction
        $transaction = new Transaction([
            'user_id' => $request->user_id,
            'book_id' => $request->book_id,
            'issue_date' => Carbon::now(),
            'due_date' => Carbon::parse($request->due_date),
            'status' => 'issued',
        ]);

        $transaction->save();

        // Update book available copies
        $book->available_copies -= 1;
        $book->save();

        return redirect()->route('transactions.index')
            ->with('success', 'Book issued successfully.');
    }

    public function show(Transaction $transaction)
    {
        // Check if user is authorized to view this transaction
        if (!Auth::user()->isAdmin() && !Auth::user()->isLibrarian() && Auth::id() != $transaction->user_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('transactions.show', compact('transaction'));
    }

    public function returnBook(Transaction $transaction)
    {
        if ($transaction->return_date !== null) {
            return redirect()->back()
                ->with('error', 'This book has already been returned.');
        }

        $transaction->return_date = Carbon::now();

        // Calculate fine if overdue
        if (Carbon::now()->gt($transaction->due_date)) {
            $daysOverdue = Carbon::now()->diffInDays($transaction->due_date);
            $transaction->fine = $daysOverdue * 5; // $5 per day
            $transaction->status = 'overdue';
        } else {
            $transaction->status = 'returned';
        }

        $transaction->save();

        // Update book available copies
        $book = $transaction->book;
        $book->available_copies += 1;
        $book->save();

        return redirect()->route('transactions.index')
            ->with('success', 'Book returned successfully.');
    }

    public function userHistory($userId)
    {
        // Check if user is authorized to view this history
        if (!Auth::user()->isAdmin() && !Auth::user()->isLibrarian() && Auth::id() != $userId) {
            abort(403, 'Unauthorized action.');
        }

        $user = User::findOrFail($userId);
        $transactions = Transaction::where('user_id', $userId)
            ->with('book')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('transactions.user-history', compact('user', 'transactions'));
    }

    public function overdueBooks()
    {
        $this->middleware('role:admin,librarian');

        $overdueTransactions = Transaction::whereNull('return_date')
            ->where('due_date', '<', Carbon::now())
            ->with(['user', 'book'])
            ->orderBy('due_date')
            ->paginate(10);

        return view('transactions.overdue', compact('overdueTransactions'));
    }
}
