@extends('layouts.app')

@section('title', 'Transactions')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Transactions</h1>
        @if(auth()->user()->isAdmin() || auth()->user()->isLibrarian())
        <a href="{{ route('transactions.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Issue New Book
        </a>
        @endif
    </div>

    <!-- Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('transactions.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="issued" {{ request('status') == 'issued' ? 'selected' : '' }}>Issued</option>
                        <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>Returned</option>
                        <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Overdue</option>
                    </select>
                </div>
                @if(auth()->user()->isAdmin() || auth()->user()->isLibrarian())
                <div class="col-md-4">
                    <select name="user_id" class="form-select">
                        <option value="">All Members</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @endif
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                    <a href="{{ route('transactions.index') }}" class="btn btn-outline-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Transactions List -->
    <div class="card">
        <div class="card-body">
            @if($transactions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Book</th>
                                <th>Member</th>
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
                                <td>{{ $transaction->id }}</td>
                                <td>{{ $transaction->book->title }}</td>
                                <td>{{ $transaction->user->name }}</td>
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
                                <td>${{ $transaction->fine }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('transactions.show', $transaction->id) }}" class="btn btn-sm btn-info">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        @if((auth()->user()->isAdmin() || auth()->user()->isLibrarian()) && !$transaction->return_date)
                                            <form action="{{ route('transactions.return', $transaction->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Are you sure you want to mark this book as returned?')">
                                                    <i class="bi bi-check-lg"></i> Return
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center mt-4">
                    {{ $transactions->appends(request()->query())->links() }}
                </div>
            @else
                <div class="alert alert-info">
                    No transactions found.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
