@extends('layouts.app')

@section('title', 'Reports')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Reports</h1>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Most Borrowed Books</h5>
                    <p class="card-text">View the most popular books in the library based on borrowing frequency.</p>
                    <a href="{{ route('reports.most-borrowed') }}" class="btn btn-primary">Generate Report</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Overdue Books List</h5>
                    <p class="card-text">View all books that are currently overdue and need to be returned.</p>
                    <a href="{{ route('reports.overdue') }}" class="btn btn-danger">Generate Report</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">User Activity</h5>
                    <p class="card-text">View the most active library members based on borrowing frequency.</p>
                    <a href="{{ route('reports.user-activity') }}" class="btn btn-success">Generate Report</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Category Popularity</h5>
                    <p class="card-text">View which book categories are most popular among library members.</p>
                    <a href="{{ route('reports.category-popularity') }}" class="btn btn-info">Generate Report</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
