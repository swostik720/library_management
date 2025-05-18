@extends('layouts.app')

@section('title', 'Category Popularity Report')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Category Popularity Report</h1>
        <a href="{{ route('reports.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back to Reports
        </a>
    </div>

    <div class="card">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">Book Categories by Popularity</h5>
        </div>
        <div class="card-body">
            @if(count($categories) > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Rank</th>
                                <th>Category</th>
                                <th>Number of Books</th>
                                <th>Total Borrows</th>
                                <th>Average Borrows per Book</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $index => $category)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->book_count }}</td>
                                <td>{{ $category->transaction_count }}</td>
                                <td>
                                    @if($category->book_count > 0)
                                        {{ number_format($category->transaction_count / $category->book_count, 2) }}
                                    @else
                                        0
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info">
                    No category data available.
                </div>
            @endif
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Insights</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5>Most Popular Categories</h5>
                    <p>The most popular categories based on borrowing frequency are:</p>
                    <ol>
                        @foreach($categories->take(3) as $category)
                            <li><strong>{{ $category->name }}</strong> with {{ $category->transaction_count }} borrows</li>
                        @endforeach
                    </ol>
                </div>
                <div class="col-md-6">
                    <h5>Recommendations</h5>
                    <ul>
                        <li>Consider acquiring more books in popular categories</li>
                        <li>Promote less popular categories through displays and events</li>
                        <li>Use this data for budget allocation when purchasing new books</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
