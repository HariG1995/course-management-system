<?php

namespace App\Repositories;

use App\Models\Student;
use App\Repositories\Contracts\StudentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class EloquentStudentRepository implements StudentRepositoryInterface
{
    public function all(): Collection
    {
        return Student::withCount('courses')->get();
    }

    public function create(array $data)
    {
        return Student::create($data);
    }

    public function find(int $id)
    {
        return Student::with('courses')->findOrFail($id);
    }

    public function update(int $id, array $data)
    {
        $student = $this->find($id);
        $student->update($data);
        return $student;
    }

    public function delete(int $id)
    {
        $student = $this->find($id);
        return $student->delete();
    }

    public function getStudentsByCourse(int $courseId): Collection
    {
        return Student::whereHas('courses', function($query) use ($courseId) {
            $query->where('courses.id', $courseId);
        })->get();
    }
}