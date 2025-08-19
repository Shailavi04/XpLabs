@extends('admin.layouts.app')

@section('content')
    <div class="container">

        <div class="container-fluid min-vh-100">
            <form action="{{ route('programs.update', $program->id) }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-xl-12">
                        <div class="card custom-card">
                            <div class="card-header">

                                <h4 class="mb-0 mt-3">Edit Program</h4>
                            </div>
                            <div class="card-body">


                                <div class="form-group mb-3">
                                    <label>Program Title *</label>
                                    <input type="text" name="title" class="form-control"
                                        value="{{ old('title', $program->title) }}" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label>Mode *</label>
                                    <select name="mode" class="form-control" required>
                                        <option value="">Select</option>
                                        <option value="Offline" {{ $program->mode == 'Offline' ? 'selected' : '' }}>Offline
                                        </option>
                                        <option value="Online" {{ $program->mode == 'Online' ? 'selected' : '' }}>Online
                                        </option>
                                        <option value="Hybrid" {{ $program->mode == 'Hybrid' ? 'selected' : '' }}>Hybrid
                                        </option>
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label>Duration (weeks)</label>
                                    <input type="number" name="duration_weeks" class="form-control"
                                        value="{{ old('duration_weeks', $program->duration_weeks) }}">
                                </div>

                                <div class="form-group mb-3">
                                    <label>Fee (₹)</label>
                                    <input type="number" step="0.01" name="fee" class="form-control"
                                        value="{{ old('fee', $program->fee) }}">
                                </div>


                                <button class="btn btn-primary">Update</button>
                                <a href="{{ route('programs.index') }}" class="btn btn-secondary">Back</a>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    @endsection
