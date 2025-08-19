@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid min-vh-100">
        <form action="{{ route('student.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-header">
                            <div class="card-title">Student Registration</div>
                        </div>
                        <div class="card-body">
                            <div class="row gy-3">
                                <div class="col-xl-4">
                                    <label for="course_id" class="form-label">Course <span
                                            class="text-danger">*</span></label>
                                    <select name="course_id" id="course_id" class="form-control" required>
                                        <option value="">-- Select Course --</option>
                                        @foreach ($courses as $course)
                                            <option value="{{ $course->id }}"
                                                {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                                {{ $course->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('course_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-xl-4">
                                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" id="name"
                                        value="{{ old('name') }}" required>
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-xl-4">
                                    <label for="email" class="form-label">Email <span
                                            class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control" id="email"
                                        value="{{ old('email') }}" required>
                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-xl-4">
                                    <label for="mobile" class="form-label">Mobile <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="mobile" class="form-control" id="mobile"
                                        value="{{ old('mobile') }}" required>
                                    @error('mobile')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>



                                <!-- <div class="col-xl-4">
                                            <label for="batch" class="form-label">Batch <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="batch" class="form-control" id="batch"
                                                value="{{ old('batch') }}" required>
                                            @error('batch')
        <small class="text-danger">{{ $message }}</small>
    @enderror
                                        </div> -->

                                {{-- <div class="col-xl-4">
                                    <label for="payment_status" class="form-label">Payment Status <span
                                            class="text-danger">*</span></label>
                                    <select name="payment_status" id="payment_status" class="form-control" required>
                                        <option value="">-- Select --</option>
                                        <option value="paid" {{ old('payment_status') == 'paid' ? 'selected' : '' }}>Paid
                                        </option>
                                        <option value="unpaid" {{ old('payment_status') == 'unpaid' ? 'selected' : '' }}>
                                            Unpaid</option>
                                        <option value="partial" {{ old('payment_status') == 'partial' ? 'selected' : '' }}>
                                            Partial</option>
                                    </select>
                                    @error('payment_status')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div> --}}

                                {{-- <div class="col-xl-6">
                                    <label for="document" class="form-label">Document</label>
                                    <input type="file" name="document" class="form-control" id="document"
                                        accept=".pdf,.jpg,.jpeg,.png">
                                    @error('document')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div> --}}

                                <div class="col-xl-4">
                                    <label for="status" class="form-label">Status <span
                                            class="text-danger">*</span></label>
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive
                                        </option>
                                    </select>
                                    @error('status')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-xl-12">
                                    <label class="form-label">Photo Attachments</label>
                                    <input type="file" class="multiple-filepond" name="photo">
                                    @error('photo.*')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
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
