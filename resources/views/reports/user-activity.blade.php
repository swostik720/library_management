@extends('layouts.app')

@section('title', 'User Activity Report')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>User Activity Report</h1>
        <a href="{{ route('reports.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back to Reports
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('reports.user-activity') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label for="period" class="form-label">Time Period</label>
                    <select name="period" id="period" class="form-select">
                        <option value="week" {{ $period == 'week' ? 'selected' : '' }}>Last Week</option>
                        <option value="month" {{ $period == 'month' ? 'selected' : '' }}>Last Month</option>
                        <option value="quarter" {{ $period == 'quarter' ? 'selected' : '' }}>Last Quarter</option>
                        <option value="year" {{ $period == 'year' ? 'selected' : '' }}>Last Year</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">Generate Report</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Most Active Users ({{ ucfirst($period) }})</h5>
        </div>
        <div class="card-body">
            @if(count($users) > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Rank</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Books Borrowed</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $index => $user)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->transactions_count }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-info">
                                            <i class="bi bi-eye"></i> View Profile
                                        </a>
                                        <a href="{{ route('transactions.user-history', $user->id) }}" class="btn btn-sm btn-primary">
                                            <i class="bi bi-clock-history"></i> View History
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info">
                    No user activity data available for the selected period.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
