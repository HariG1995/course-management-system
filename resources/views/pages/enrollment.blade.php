@extends('layouts.app')

@section('content')
    <style>
    body{
        height: auto !important;
    }
    </style>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>{{ $course->name }} - Course Details</h1>
        <div>
            <a href="{{ route('courses.index') }}" class="btn btn-secondary">Back to Courses</a>
            <a href="{{ route('enrollments.index') }}" class="btn btn-info">View All Enrollments</a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="card-title">Course Information</h5>
                    <p><strong>ID:</strong> {{ $course->id }}</p>
                    <p><strong>Name:</strong> {{ $course->name }}</p>
                    <p><strong>Fee:</strong> ₹{{ number_format($course->fee, 2) }}</p>
                </div>
                <div class="col-md-6">
                    <h5 class="card-title">Category</h5>
                    <p><strong>Category:</strong> {{ $course->category->name }}</p>
                    <p><strong>Total Enrollments:</strong> {{ $course->students->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5>Currently Enrolled Students ({{ $enrolledStudents->count() }})</h5>
        </div>
        <div class="card-body">
            @if($enrolledStudents->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover" id="data-table">
                        <thead class="table-light">
                            <tr>
                                <th>Student ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Enrolled At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($enrolledStudents as $student)
                                <tr>
                                    <td>{{ $student->id }}</td>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->email }}</td>
                                    <td>{{ \Carbon\Carbon::parse($student->pivot->enrolled_at)->format('M j, Y g:i A') }}</td>
                                    <td>
                                        <form action="{{ route('enrollments.destroy', $student->pivot->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('Remove this student from the course?')">
                                                Remove
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info">No students enrolled in this course yet.</div>
            @endif
        </div>
    </div>

    <div class="card mb-5">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Enroll New Student</h5>
        </div>
        <div class="card-body">
            @if($availableStudents->count() > 0)
                <form action="{{ route('enrollments.store', $course->id) }}" method="POST">
                    @csrf
                    <div class="row g-3 align-items-end">
                        <div class="col-md-8">
                            <label for="student_id" class="form-label">Select Student</label>
                            <select name="student_id" id="student_id" class="form-control" required>
                                <option value="">Choose a student</option>
                                @foreach($availableStudents as $student)
                                    <option value="{{ $student->id }}">
                                        {{ $student->name }} ({{ $student->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-user-plus me-2"></i> Enroll Student
                            </button>
                        </div>
                    </div>
                </form>
            @else
                <div class="alert alert-warning">
                    All students are already enrolled in this course.
                </div>
            @endif
        </div>
    </div>
@endsection