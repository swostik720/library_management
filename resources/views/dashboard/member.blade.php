@extends('layouts.app')

@section('title', 'Member Dashboard')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Member Dashboard</h1>

    <!-- Current Borrowings -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Currently Borrowed Books</h5>
        </div>
        <div class="card-body">
            @if($currentBorrowings->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Book Title</th>
                                <th>Author</th>
                                <th>Issue Date</th>
                                <th>Due Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($currentBorrowings as $transaction)
                            <tr>
                                <td>{{ $transaction->book->title }}</td>
                                <td>{{ $transaction->book->author }}</td>
                                <td>{{ $transaction->issue_date->format('M d, Y') }}</td>
                                <td>{{ $transaction->due_date->format('M d, Y') }}</td>
                                <td>
                                    @if($transaction->isOverdue())
                                        <span class="badge bg-danger">Overdue</span>
                                    @else
                                        <span class="badge bg-primary">Issued</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-center">You don't have any books currently borrowed.</p>
            @endif
        </div>
    </div>

    <!-- Overdue Books -->
    @if($overdueBooks->count() > 0)
    <div class="card mb-4">
        <div class="card-header bg-danger text-white">
            <h5 class="mb-0">Overdue Books</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Book Title</th>
                            <th>Due Date</th>
                            <th>Days Overdue</th>
                            <th>Estimated Fine</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($overdueBooks as $transaction)
                        <tr>
                            <td>{{ $transaction->book->title }}</td>
                            <td>{{ $transaction->due_date->format('M d, Y') }}</td>
                            <td>{{ $transaction->due_date->diffInDays(now()) }}</td>
                            <td>${{ $transaction->due_date->diffInDays(now()) * 5 }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="alert alert-warning mt-3">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                Please return overdue books as soon as possible to avoid additional fines.
            </div>
        </div>
    </div>
    @endif

    <!-- Borrowing History -->
    <div class="card mb-4">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">Recent Borrowing History</h5>
        </div>
        <div class="card-body">
            @if($borrowingHistory->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Book Title</th>
                                <th>Issue Date</th>
                                <th>Return Date</th>
                                <th>Fine Paid</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($borrowingHistory as $transaction)
                            <tr>
                                <td>{{ $transaction->book->title }}</td>
                                <td>{{ $transaction->issue_date->format('M d, Y') }}</td>
                                <td>{{ $transaction->return_date->format('M d, Y') }}</td>
                                <td>${{ $transaction->fine }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="text-end mt-3">
                    <a href="{{ route('transactions.user-history', auth()->id()) }}" class="btn btn-outline-primary">View Full History</a>
                </div>
            @else
                <p class="text-center">You don't have any borrowing history yet.</p>
            @endif
        </div>
    </div>

    <!-- Total Fine -->
    <div class="card">
        <div class="card-header bg-warning">
            <h5 class="mb-0">Fine Summary</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h4>Total Fine Paid: ${{ $totalFine }}</h4>
                </div>
                <div class="col-md-6">
                    <h4>Estimated Pending Fine: ${{ $overdueBooks->sum(function($transaction) {
                        return $transaction->due_date->diffInDays(now()) * 5;
                    }) }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
