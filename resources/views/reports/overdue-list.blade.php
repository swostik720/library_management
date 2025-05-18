@extends('layouts.app')

@section('title', 'Overdue Books Report')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Overdue Books Report</h1>
        <a href="{{ route('reports.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back to Reports
        </a>
    </div>

    <div class="card">
        <div class="card-header bg-danger text-white">
            <h5 class="mb-0">Currently Overdue Books</h5>
        </div>
        <div class="card-body">
            @if(count($overdueTransactions) > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Book Title</th>
                                <th>Member</th>
                                <th>Issue Date</th>
                                <th>Due Date</th>
                                <th>Days Overdue</th>
                                <th>Estimated Fine</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($overdueTransactions as $transaction)
                            <tr>
                                <td>{{ $transaction->book->title }}</td>
                                <td>{{ $transaction->user->name }}</td>
                                <td>{{ $transaction->issue_date->format('M d, Y') }}</td>
                                <td>{{ $transaction->due_date->format('M d, Y') }}</td>
                                <td>{{ now()->diffInDays($transaction->due_date) }}</td>
                                <td>${{ now()->diffInDays($transaction->due_date) * 5 }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('transactions.show', $transaction->id) }}" class="btn btn-sm btn-info">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <form action="{{ route('transactions.return', $transaction->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Are you sure you want to mark this book as returned?')">
                                                <i class="bi bi-check-lg"></i> Return
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-success">
                    No overdue books at the moment. All books have been returned on time.
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
                <div class="col-md-4">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <h5 class="card-title">Total Overdue Books</h5>
                            <h2 class="text-danger">{{ count($overdueTransactions) }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <h5 class="card-title">Total Members with Overdue Books</h5>
                            <h2 class="text-warning">{{ $overdueTransactions->pluck('user_id')->unique()->count() }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <h5 class="card-title">Total Estimated Fines</h5>
                            <h2 class="text-primary">${{ $overdueTransactions->sum(function($transaction) {
                                return now()->diffInDays($transaction->due_date) * 5;
                            }) }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
