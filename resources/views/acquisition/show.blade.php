@extends('layouts.app')

@section('title', 'Acquisition Request Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Acquisition Request Details</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h4>Book Information</h4>
                            <table class="table">
                                <tr>
                                    <th>Title:</th>
                                    <td>{{ $acquisition->title }}</td>
                                </tr>
                                <tr>
                                    <th>Author:</th>
                                    <td>{{ $acquisition->author ?? 'Not specified' }}</td>
                                </tr>
                                <tr>
                                    <th>ISBN:</th>
                                    <td>{{ $acquisition->isbn ?? 'Not specified' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h4>Request Information</h4>
                            <table class="table">
                                <tr>
                                    <th>Requested By:</th>
                                    <td>{{ $acquisition->requestedBy->name }}</td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>
                                        <span class="badge bg-{{
                                            $acquisition->status == 'pending' ? 'warning' :
                                            ($acquisition->status == 'approved' ? 'primary' :
                                            ($acquisition->status == 'rejected' ? 'danger' : 'success'))
                                        }}">
                                            {{ ucfirst($acquisition->status) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Requested On:</th>
                                    <td>{{ $acquisition->created_at->format('F d, Y') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    @if($acquisition->notes)
                    <div class="mb-4">
                        <h4>Notes</h4>
                        <div class="card">
                            <div class="card-body">
                                {{ $acquisition->notes }}
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('acquisition.index') }}" class="btn btn-secondary">Back to Requests</a>

                        @if(auth()->user()->isAdmin() || auth()->user()->isLibrarian())
                            @if($acquisition->status == 'pending')
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateStatusModal">
                                    Update Status
                                </button>

                                <!-- Status Update Modal -->
                                <div class="modal fade" id="updateStatusModal" tabindex="-1" aria-labelledby="updateStatusModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="updateStatusModalLabel">Update Request Status</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('acquisition.update-status', $acquisition->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="status" class="form-label">Status</label>
                                                        <select class="form-select" id="status" name="status" required>
                                                            <option value="pending" {{ $acquisition->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                            <option value="approved" {{ $acquisition->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                                            <option value="rejected" {{ $acquisition->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                                            <option value="acquired" {{ $acquisition->status == 'acquired' ? 'selected' : '' }}>Acquired</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="notes" class="form-label">Notes</label>
                                                        <textarea class="form-control" id="notes" name="notes" rows="3">{{ $acquisition->notes }}</textarea>
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
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
