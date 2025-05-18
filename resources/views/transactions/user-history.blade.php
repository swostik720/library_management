@extends('layouts.app')

@section('title', 'User Borrowing History')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Borrowing History: {{ $user->name }}</h1>
        <a href="{{ route('transactions.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back to Transactions
        </a>
    </div>

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Complete Borrowing History</h5>
        </div>
        <div class="card-body">
            @if(count($transactions) > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Book Title</th>
                                <th>Issue Date</th>
                                <th>Due Date</th>
                                <th>Return Date</th>
                                <th>Status</th>
                                <th>Fine</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->book->title }}</td>
                                <td>{{ $transaction->issue_date->format('M d, Y') }}</td>
                                <td>{{ $transaction->due_date->format('M d, Y') }}</td>
                                <td>{{ $transaction->return_date ? $transaction->return_date->format('M d, Y') : 'Not returned' }}</td>
                                <td>
                                    @if($transaction->return_date)
                                        <span class="badge bg-success">Returned</span>
                                    @elseif($transaction->isOverdue())
                                        <span class="badge bg-danger">Overdue</span>
                                    @else
                                        <span class="badge bg-primary">Issued</span>
                                    @endif
                                </td>
                                <td>
                                    @if($transaction->fine > 0)
                                        <span class="text-danger">${{ $transaction->fine }}</span>
                                    @elseif($transaction->isOverdue() && !$transaction->return_date)
                                        <span class="text-warning">Estimated: ${{ $transaction->calculateFine() }}</span>
                                    @else
                                        <span class="text-success">$0.00</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('transactions.show', $transaction->id) }}" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                    @if((auth()->user()->isAdmin() || auth()->user()->isLibrarian()) && !$transaction->return_date)
                                        <form action="{{ route('transactions.return', $transaction->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Are you sure you want to mark this book as returned?')">
                                                <i class="bi bi-check-lg"></i> Return
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center mt-4">
                    {{ $transactions->links() }}
                </div>
            @else
                <div class="alert alert-info">
                    No borrowing history found for this user.
                </div>
            @endif
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">Summary</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <h5 class="card-title">Total Books Borrowed</h5>
                            <h2>{{ $transactions->count() }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <h5 class="card-title">Currently Borrowed</h5>
                            <h2>{{ $transactions->where('return_date', null)->count() }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <h5 class="card-title">Overdue Books</h5>
                            <h2 class="text-danger">{{ $transactions->filter(function($t) { return $t->isOverdue(); })->count() }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <h5 class="card-title">Total Fines</h5>
                            <h2 class="text-primary">${{ $transactions->sum('fine') }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
