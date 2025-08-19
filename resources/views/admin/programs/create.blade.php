@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid min-vh-100">
        <form action="{{ route('programs.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-header">

                            <h4 class="mb-0 mt-3">Create New Program</h4>
                        </div>
                        <div class="card-body">
                            @csrf

                            <div class="form-group mb-3">
                                <label>Program Title *</label>
                                <input type="text" name="title" class="form-control" value="{{ old('title') }}"
                                    required>
                            </div>

                            <div class="form-group mb-3">
                                <label>Mode *</label>
                                <select name="mode" class="form-control" required>
                                    <option value="">Select</option>
                                    <option value="Offline">Offline</option>
                                    <option value="Online">Online</option>
                                    <option value="Hybrid">Hybrid</option>
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label>Duration (weeks)</label>
                                <input type="number" name="duration_weeks" class="form-control"
                                    value="{{ old('duration_weeks') }}">
                            </div>

                            <div class="form-group mb-3">
                                <label>Fee (₹)</label>
                                <input type="number" step="0.01" name="fee" class="form-control"
                                    value="{{ old('fee') }}">
                            </div>

                            {{-- <div class="form-group mb-3">
                            <label>Certificate Enabled?</label><br>
                            <input type="checkbox" name="certificate_enabled" value="1"> Yes
                        </div> --}}

                            {{-- <div class="form-group mb-3">
                            <label>Certificate Criteria</label>
                            <textarea name="certificate_criteria" class="form-control">{{ old('certificate_criteria') }}</textarea>
                        </div> --}}

                            {{-- <div class="form-group mb-4">
                            <label>Rank Criteria (JSON)</label>
                            <textarea name="rank_criteria" class="form-control" placeholder='{"gold": 90, "silver": 75, "bronze": 60}'>{{ old('rank_criteria') }}</textarea>
                        </div> --}}

                            <div class="d-flex justify-content-between">
                                <button class="btn btn-primary">Save</button>
                                <a href="{{ route('programs.index') }}" class="btn btn-secondary">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
        </form>
    </div>
  
@endsection
