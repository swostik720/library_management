@extends('layouts.app')

@section('title', 'Transaction Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Transaction Details</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h4>Book Information</h4>
                            <table class="table">
                                <tr>
                                    <th>Title:</th>
                                    <td>{{ $transaction->book->title }}</td>
                                </tr>
                                <tr>
                                    <th>Author:</th>
                                    <td>{{ $transaction->book->author }}</td>
                                </tr>
                                <tr>
                                    <th>ISBN:</th>
                                    <td>{{ $transaction->book->isbn }}</td>
                                </tr>
                                <tr>
                                    <th>Category:</th>
                                    <td>{{ $transaction->book->category->name }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h4>Member Information</h4>
                            <table class="table">
                                <tr>
                                    <th>Name:</th>
                                    <td>{{ $transaction->user->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td>{{ $transaction->user->email }}</td>
                                </tr>
                                <tr>
                                    <th>Role:</th>
                                    <td>{{ ucfirst($transaction->user->role) }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h4>Transaction Information</h4>
                            <table class="table">
                                <tr>
                                    <th>Issue Date:</th>
                                    <td>{{ $transaction->issue_date->format('F d, Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Due Date:</th>
                                    <td>{{ $transaction->due_date->format('F d, Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Return Date:</th>
                                    <td>{{ $transaction->return_date ? $transaction->return_date->format('F d, Y') : 'Not returned yet' }}</td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>
                                        @if($transaction->return_date)
                                            <span class="badge bg-success">Returned</span>
                                        @elseif($transaction->isOverdue())
                                            <span class="badge bg-danger">Overdue</span>
                                        @else
                                            <span class="badge bg-primary">Issued</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Fine:</th>
                                    <td>
                                        @if($transaction->fine > 0)
                                            <span class="text-danger">${{ $transaction->fine }}</span>
                                        @elseif($transaction->isOverdue() && !$transaction->return_date)
                                            <span class="text-warning">Estimated: ${{ $transaction->calculateFine() }}</span>
                                        @else
                                            <span class="text-success">$0.00</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Back to Transactions</a>

                        @if((auth()->user()->isAdmin() || auth()->user()->isLibrarian()) && !$transaction->return_date)
                            <form action="{{ route('transactions.return', $transaction->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success" onclick="return confirm('Are you sure you want to mark this book as returned?')">
                                    <i class="bi bi-check-lg me-1"></i> Mark as Returned
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
