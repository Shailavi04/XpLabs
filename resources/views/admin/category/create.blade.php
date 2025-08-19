@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Add Category</h5>
            <a href="{{ route('categories.index') }}" class="btn btn-sm btn-secondary">Back</a>
        </div>
        <div class="card-body">
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf

                {{-- Category Name --}}
                <div class="mb-3">
                    <label for="name" class="form-label">Category Name *</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                </div>

                {{-- Status Dropdown --}}
                <div class="mb-3">
                    <label for="active" class="form-label">Status *</label>
                    <slect name="active" id="active" class="form-select" required>
                        <option value="1" {{ old('active', 1) == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('active') == '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <button class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
</div>
@endsection
