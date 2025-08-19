@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Programs List</h4>
                        <a href="{{ route('programs.create') }}" class="btn btn-primary mb-3">Add New Program</a>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif


                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Mode</th>
                                <th>Duration (weeks)</th>
                                <th>Fee</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($programs as $program)
                                <tr>
                                    <td>{{ $program->title }}</td>
                                    <td>{{ $program->mode }}</td>
                                    <td>{{ $program->duration_weeks }}</td>
                                    <td>₹{{ $program->fee }}</td>
                                    <td>
                                        <a href="{{ route('programs.edit', $program->id) }}"
                                            class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('programs.destroy', $program->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger"
                                                onclick="return confirm('Delete this program?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">No programs found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection
