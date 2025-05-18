@extends('layouts.app')

@section('title', 'Book Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Book Details</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h2>{{ $book->title }}</h2>
                            <h5 class="text-muted">by {{ $book->author }}</h5>

                            <div class="mt-4">
                                <h4>Description</h4>
                                <p>{{ $book->description ?? 'No description available.' }}</p>
                            </div>

                            <div class="mt-4">
                                <h4>Book Information</h4>
                                <table class="table">
                                    <tr>
                                        <th>ISBN:</th>
                                        <td>{{ $book->isbn }}</td>
                                    </tr>
                                    <tr>
                                        <th>Category:</th>
                                        <td>{{ $book->category->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Publisher:</th>
                                        <td>{{ $book->publisher ?? 'Not specified' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Published Year:</th>
                                        <td>{{ $book->published_year ?? 'Not specified' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Total Copies:</th>
                                        <td>{{ $book->total_copies }}</td>
                                    </tr>
                                    <tr>
                                        <th>Available Copies:</th>
                                        <td>
                                            <span class="{{ $book->available_copies > 0 ? 'text-success' : 'text-danger' }}">
                                                {{ $book->available_copies }}
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Availability</h5>
                                </div>
                                <div class="card-body text-center">
                                    @if($book->available_copies > 0)
                                        <div class="alert alert-success">
                                            <i class="bi bi-check-circle-fill me-2"></i> Available
                                        </div>
                                        <p>{{ $book->available_copies }} of {{ $book->total_copies }} copies available</p>

                                        @if(auth()->user()->isAdmin() || auth()->user()->isLibrarian())
                                            <a href="{{ route('transactions.create') }}" class="btn btn-primary">
                                                <i class="bi bi-journal-arrow-up me-1"></i> Issue This Book
                                            </a>
                                        @endif
                                    @else
                                        <div class="alert alert-danger">
                                            <i class="bi bi-x-circle-fill me-2"></i> Not Available
                                        </div>
                                        <p>All copies are currently borrowed</p>
                                    @endif
                                </div>
                            </div>

                            @if(auth()->user()->isAdmin() || auth()->user()->isLibrarian())
                                <div class="card mt-3">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">Management</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-grid gap-2">
                                            <a href="{{ route('books.edit', $book->id) }}" class="btn btn-primary">
                                                <i class="bi bi-pencil me-1"></i> Edit Book
                                            </a>
                                            @if(auth()->user()->isAdmin())
                                                <form action="{{ route('books.destroy', $book->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this book?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger w-100">
                                                        <i class="bi bi-trash me-1"></i> Delete Book
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="mt-4">
                        <h4>Borrowing History</h4>
                        @if($book->transactions->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Member</th>
                                            <th>Issue Date</th>
                                            <th>Due Date</th>
                                            <th>Return Date</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($book->transactions->sortByDesc('created_at')->take(5) as $transaction)
                                        <tr>
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
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-info">
                                This book has not been borrowed yet.
                            </div>
                        @endif
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('books.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Back to Books
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
