@extends('layouts.app')

@section('title', 'User Profile')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">User Profile: {{ $user->name }}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>User Information</h4>
                            <table class="table">
                                <tr>
                                    <th>Name:</th>
                                    <td>{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <th>Role:</th>
                                    <td>
                                        <span class="badge bg-{{ $user->role == 'admin' ? 'danger' : ($user->role == 'librarian' ? 'warning' : 'info') }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Registered On:</th>
                                    <td>{{ $user->created_at->format('F d, Y') }}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <h4>Activity Summary</h4>
                            <table class="table">
                                <tr>
                                    <th>Total Books Borrowed:</th>
                                    <td>{{ $user->transactions->count() }}</td>
                                </tr>
                                <tr>
                                    <th>Currently Borrowed:</th>
                                    <td>{{ $user->transactions->whereNull('return_date')->count() }}</td>
                                </tr>
                                <tr>
                                    <th>Overdue Books:</th>
                                    <td>
                                        @php
                                            $overdueCount = $user->transactions->filter(function($transaction) {
                                                return $transaction->return_date === null && $transaction->isOverdue();
                                            })->count();
                                        @endphp
                                        <span class="{{ $overdueCount > 0 ? 'text-danger' : 'text-success' }}">
                                            {{ $overdueCount }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Total Fines:</th>
                                    <td>${{ $user->transactions->sum('fine') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h4>Recent Activity</h4>
                        @if($user->transactions->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Book</th>
                                            <th>Issue Date</th>
                                            <th>Due Date</th>
                                            <th>Return Date</th>
                                            <th>Status</th>
                                            <th>Fine</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($user->transactions->sortByDesc('created_at')->take(5) as $transaction)
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
                                            <td>${{ $transaction->fine }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-center">
                                <a href="{{ route('transactions.user-history', $user->id) }}" class="btn btn-outline-primary">View Full History</a>
                            </div>
                        @else
                            <div class="alert alert-info">
                                No transaction history found for this user.
                            </div>
                        @endif
                    </div>

                    <div class="mt-4 d-flex justify-content-between">
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">Back to Users</a>
                        <div>
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">Edit User</a>
                            @if(auth()->user()->isAdmin() && auth()->id() != $user->id)
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete User</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
