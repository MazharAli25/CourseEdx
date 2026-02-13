@extends('adminlte::page')
@section('title', 'Edit Sub Category')

@section('content_header')
    <h1>Edit Sub Category</h1>
@endsection

@section('content')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit Sub Category</h3>
        </div>

        <div class="card-body">
            <form action="{{ route('sub-category.update', $subCategory->id) }}" method="POST">
                @csrf
                @method('PUT')
                <!-- Sub Category Name -->
                <div class="form-group">
                    <label for="name">Sub Category Name</label>
                    <select type="text" name="categoryId" class="form-control" placeholder="Enter category name" required>
                        <option value="">Select Category</option>
                        @foreach ($cats as $cat)
                            <option value="{{ $cat->id }}" {{ $subCategory->categoryId == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Sub Category Name -->
                <div class="form-group">
                    <label for="name">Sub Category Name</label>
                    <input type="text" value="{{ $subCategory->name }}" name="name" class="form-control" placeholder="Enter category name" required>
                </div>

                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input type="text" value="{{ $subCategory->slug }}" name="slug" class="form-control" placeholder="Example: web-dev" required>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save
                </button>
            </form>
        </div>
    </div>

@endsection
