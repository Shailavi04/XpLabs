@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid min-vh-100">
        <form action="{{ route('course.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-header">
                            <div class="card-title">Add New Course</div>
                        </div>
                        <div class="card-body">
                            <div class="row gy-3">

                                {{-- Course Name --}}
                                <div class="col-xl-6">
                                    <label for="name" class="form-label">Course Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" id="name"
                                        value="{{ old('name') }}" required>
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- Course Code --}}
                                <div class="col-xl-6">
                                    <label for="code" class="form-label">Course Code <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="code" class="form-control" id="code"
                                        value="{{ old('code') }}" required>
                                    @error('code')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- Duration --}}
                                <div class="col-xl-6">
                                    <label for="duration" class="form-label">Duration <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="duration" class="form-control" id="duration"
                                        placeholder="e.g. 6 Months, 1 Year" value="{{ old('duration') }}" required>
                                    @error('duration')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- Category --}}
                                <div class="col-xl-6">
                                    <label for="category_id" class="form-label">Category <span
                                            class="text-danger">*</span></label>
                                    <select name="category_id" id="category_id" class="form-control" required>
                                        <option value="">-- Select Category --</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- Description with text editor --}}
                                <div class="col-xl-12">
                                    <label for="description" class="form-label">Description <span
                                            class="text-danger">*</span></label>
                                    <textarea name="description" id="description" class="form-control texteditor" rows="5" required>{{ old('description') }}</textarea>
                                    @error('description')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- Image Upload --}}
                                <div class="col-xl-12">
                                    <label class="form-label">Course Image</label>
                                    <input type="file" class="form-control" name="image" accept=".jpg,.jpeg,.png">
                                    @error('image')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="curriculum" class="form-label">Course Curriculum (Module-wise)</label>
                                    <textarea name="curriculum" id="curriculum" class="form-control" rows="10">
        {{ old('curriculum', $course->curriculum ?? '') }}
    </textarea>
                                </div>


                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-primary float-end">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
