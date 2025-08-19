@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid min-vh-100">
        <form action="{{ route('course.update', $course->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-header">
                            <div class="card-title">Edit Course</div>
                        </div>
                        <div class="card-body">
                            <div class="row gy-3">

                                {{-- Course Name --}}
                                <div class="col-xl-6">
                                    <label for="name" class="form-label">Course Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" id="name"
                                        value="{{ old('name', $course->name) }}" required>
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- Course Code --}}
                                <div class="col-xl-6">
                                    <label for="code" class="form-label">Course Code <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="code" class="form-control" id="code"
                                        value="{{ old('code', $course->code) }}" required>
                                    @error('code')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- Duration --}}
                                <div class="col-xl-6">
                                    <label for="duration" class="form-label">Duration <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="duration" class="form-control" id="duration"
                                        placeholder="e.g. 6 Months, 1 Year" value="{{ old('duration', $course->duration) }}"
                                        required>
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
                                                {{ old('category_id', $course->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- Description --}}
                                <div class="col-xl-12">
                                    <label for="description" class="form-label">Description <span
                                            class="text-danger">*</span></label>
                                    <textarea name="description" id="description" class="form-control texteditor" rows="5" required>{{ old('description', $course->description) }}</textarea>
                                    @error('description')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- Current Image Preview --}}


                                {{-- Image Upload --}}
                                <div class="col-xl-12">
                                    <label class="form-label">Change Course Image</label>
                                    <input type="file" class="form-control" name="image" accept=".jpg,.jpeg,.png">
                                    @if ($course->image)
                                        <img src="{{ asset('uploads/courses/' . $course->image) }}" alt="Course Image"
                                            width="150">
                                    @endif
                                    @error('image')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-primary float-end">Update</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
