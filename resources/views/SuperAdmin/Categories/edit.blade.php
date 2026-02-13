@extends('adminlte::page')
@section('title', 'Update Category')

@section('content_header')
    <h1>Update Category</h1>
@endsection

@section('content')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Update Category</h3>
        </div>

        <div class="card-body">
            <form action="{{ route('category.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT')
                <!-- Category Name -->
                <div class="form-group">
                    <label for="name">Category Name</label>
                    <input type="text" value="{{ $category->name }}" name="name" class="form-control" placeholder="Enter category name" required>
                </div>

                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input type="text" value="{{ $category->slug }}" name="slug" class="form-control" placeholder="Example: web-dev" required>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Create Category
                </button>
            </form>
        </div>
    </div>

@endsection
