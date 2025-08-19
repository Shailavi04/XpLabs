@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="container-fluid min-vh-100">
        <form action="{{ route('categories.update', $category->id) }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card shadow">
                        <div class="card-header bg-white">
                            <h4 class="mb-0 mt-3">Edit Category</h4>
                        </div>
                        <div class="card-body">

                            {{-- Category Name --}}
                            <div class="form-group mb-3">
                                <label for="name">Category Name *</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ old('name', $category->name) }}" required>
                            </div>

                            {{-- Status Dropdown --}}
                            <div class="form-group mb-3">
                                <label for="active">Status *</label>
                                <select name="active" id="active" class="form-select" required>
                                    <option value="1" {{ old('active', $category->active) == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('active', $category->active) == 0 ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>

                            {{-- Buttons --}}
                            <button class="btn btn-primary">Update</button>
                            <a href="{{ route('categories.index') }}" class="btn btn-secondary">Back</a>

                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
