@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid min-vh-100">
        <form action="{{ route('student.update', $student->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-header">
                            <div class="card-title">Edit Student</div>
                        </div>
                        <div class="card-body">
                            <div class="row gy-3">
                                <div class="col-xl-4">
                                    <label for="course_id" class="form-label">Course <span class="text-danger">*</span></label>
                                    <select name="course" id="course_id" class="form-control" required>
                                        <option value="">-- Select Course --</option>
                                        @foreach ($courses as $course)
                                            <option value="{{ $course->id }}"
                                                {{ (old('course', $student->course) == $course->id) ? 'selected' : '' }}>
                                                {{ $course->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('course')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-xl-4">
                                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" id="name"
                                        value="{{ old('name', $student->name) }}" required>
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-xl-4">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control" id="email"
                                        value="{{ old('email', $student->email) }}" required>
                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-xl-4">
                                    <label for="mobile" class="form-label">Mobile <span class="text-danger">*</span></label>
                                    <input type="text" name="mobile" class="form-control" id="mobile"
                                        value="{{ old('mobile', $student->mobile) }}" required>
                                    @error('mobile')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-xl-4">
                                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="1" {{ old('status', $student->status) == '1' ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('status', $student->status) == '0' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('status')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-xl-12">
                                    <label class="form-label">Photo Attachments</label>
                                    <input type="file" class="multiple-filepond" name="photo">
                                    @if ($student->photo)
                                        <p class="mt-2">Current: <img src="{{ asset('uploads/photos/' . $student->photo) }}" width="80"></p>
                                    @endif
                                    @error('photo')
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
