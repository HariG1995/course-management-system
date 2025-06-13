<?php
namespace App\Repositories;

use App\Models\Course;
use App\Repositories\Contracts\CoursesRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class EloquentCoursesRepository implements CoursesRepositoryInterface
{
    public function create(array $data)
    {
        return Course::create($data);
    }

    public function find(int $id)
    {
        return Course::findOrFail($id);
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

    public function allWithCategoryAndEnrollments(): Collection
    {
        return Course::with(['category'])->withCount('enrollments')->get();
    }

    public function getStudentsByCourse(int $courseId): Collection
    {
        $course = Course::with('students')->findOrFail($courseId);
        return $course->students;
    }

    public function filterByCategoryWithName(?int $categoryId, ?string $name): Collection
    {
        $query = Course::with(['category', 'enrollments']);

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        if ($name) {
            $query->where('name', 'like', "%{$name}%");
        }

        return $query->get();
    }
}