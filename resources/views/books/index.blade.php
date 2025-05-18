@extends('layouts.app')

@section('title', 'Books')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Books</h1>
        @if(auth()->user()->isAdmin() || auth()->user()->isLibrarian())
        <a href="{{ route('books.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Add New Book
        </a>
        @endif
    </div>

    <!-- Search and Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('books.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search by title, author or ISBN" name="search" value="{{ request('search') }}">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="category" class="form-select">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="sort" class="form-select">
                        <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Sort by Title</option>
                        <option value="author" {{ request('sort') == 'author' ? 'selected' : '' }}>Sort by Author</option>
                        <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Sort by Date Added</option>
                        <option value="available_copies" {{ request('sort') == 'available_copies' ? 'selected' : '' }}>Sort by Availability</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="direction" class="form-select">
                        <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>Ascending</option>
                        <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>Descending</option>
                    </select>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                    <a href="{{ route('books.index') }}" class="btn btn-outline-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Books List -->
    <div class="card">
        <div class="card-body">
            @if($books->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Category</th>
                                <th>ISBN</th>
                                <th>Available / Total</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($books as $book)
                            <tr>
                                <td>{{ $book->title }}</td>
                                <td>{{ $book->author }}</td>
                                <td>{{ $book->category->name }}</td>
                                <td>{{ $book->isbn }}</td>
                                <td>
                                    <span class="{{ $book->available_copies > 0 ? 'text-success' : 'text-danger' }}">
                                        {{ $book->available_copies }} / {{ $book->total_copies }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('books.show', $book->id) }}" class="btn btn-sm btn-info">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        @if(auth()->user()->isAdmin() || auth()->user()->isLibrarian())
                                            <a href="{{ route('books.edit', $book->id) }}" class="btn btn-sm btn-primary">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            @if(auth()->user()->isAdmin())
                                                <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this book?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center mt-4">
                    {{ $books->appends(request()->query())->links() }}
                </div>
            @else
                <div class="alert alert-info">
                    No books found. @if(auth()->user()->isAdmin() || auth()->user()->isLibrarian()) <a href="{{ route('books.create') }}">Add a new book</a>. @endif
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
