@extends('layouts.app')

@section('title', 'Acquisition Requests')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Acquisition Requests</h1>
        <a href="{{ route('acquisition.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> New Request
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            @if($requests->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Requested By</th>
                                <th>Status</th>
                                <th>Requested On</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($requests as $request)
                            <tr>
                                <td>{{ $request->id }}</td>
                                <td>{{ $request->title }}</td>
                                <td>{{ $request->author ?? 'N/A' }}</td>
                                <td>{{ $request->requestedBy->name }}</td>
                                <td>
                                    <span class="badge bg-{{
                                        $request->status == 'pending' ? 'warning' :
                                        ($request->status == 'approved' ? 'primary' :
                                        ($request->status == 'rejected' ? 'danger' : 'success'))
                                    }}">
                                        {{ ucfirst($request->status) }}
                                    </span>
                                </td>
                                <td>{{ $request->created_at->format('M d, Y') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('acquisition.show', $request->id) }}" class="btn btn-sm btn-info">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        @if(auth()->user()->isAdmin() || auth()->user()->isLibrarian())
                                            @if($request->status == 'pending')
                                                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#updateStatusModal{{ $request->id }}">
                                                    <i class="bi bi-check-circle"></i> Update Status
                                                </button>
                                            @endif
                                        @endif
                                    </div>

                                    <!-- Status Update Modal -->
                                    @if(auth()->user()->isAdmin() || auth()->user()->isLibrarian())
                                        <div class="modal fade" id="updateStatusModal{{ $request->id }}" tabindex="-1" aria-labelledby="updateStatusModalLabel{{ $request->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="updateStatusModalLabel{{ $request->id }}">Update Request Status</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('acquisition.update-status', $request->id) }}" method="POST">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="status" class="form-label">Status</label>
                                                                <select class="form-select" id="status" name="status" required>
                                                                    <option value="pending" {{ $request->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                                    <option value="approved" {{ $request->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                                                    <option value="rejected" {{ $request->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                                                    <option value="acquired" {{ $request->status == 'acquired' ? 'selected' : '' }}>Acquired</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="notes" class="form-label">Notes</label>
                                                                <textarea class="form-control" id="notes" name="notes" rows="3">{{ $request->notes }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Update Status</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center mt-4">
                    {{ $requests->links() }}
                </div>
            @else
                <div class="alert alert-info">
                    No acquisition requests found. <a href="{{ route('acquisition.create') }}">Create a new request</a>.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
