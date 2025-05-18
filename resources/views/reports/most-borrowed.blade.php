@extends('layouts.app')

@section('title', 'Most Borrowed Books Report')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Most Borrowed Books Report</h1>
        <a href="{{ route('reports.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back to Reports
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('reports.most-borrowed') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label for="period" class="form-label">Time Period</label>
                    <select name="period" id="period" class="form-select">
                        <option value="week" {{ $period == 'week' ? 'selected' : '' }}>Last Week</option>
                        <option value="month" {{ $period == 'month' ? 'selected' : '' }}>Last Month</option>
                        <option value="quarter" {{ $period == 'quarter' ? 'selected' : '' }}>Last Quarter</option>
                        <option value="year" {{ $period == 'year' ? 'selected' : '' }}>Last Year</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="limit" class="form-label">Number of Books</label>
                    <select name="limit" id="limit" class="form-select">
                        <option value="5" {{ $limit == 5 ? 'selected' : '' }}>Top 5</option>
                        <option value="10" {{ $limit == 10 ? 'selected' : '' }}>Top 10</option>
                        <option value="20" {{ $limit == 20 ? 'selected' : '' }}>Top 20</option>
                        <option value="50" {{ $limit == 50 ? 'selected' : '' }}>Top 50</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">Generate Report</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Most Borrowed Books ({{ ucfirst($period) }})</h5>
        </div>
        <div class="card-body">
            @if(count($books) > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Rank</th>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Times Borrowed</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($books as $index => $book)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $book->title }}</td>
                                <td>{{ $book->author }}</td>
                                <td>{{ $book->borrow_count }}</td>
                                <td>
                                    <a href="{{ route('books.show', $book->id) }}" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i> View Details
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info">
                    No borrowing data available for the selected period.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
