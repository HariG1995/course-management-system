<?php
namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface CoursesRepositoryInterface
{
    public function create(array $data);
    public function find(int $id);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function allWithCategoryAndEnrollments(): Collection;
    public function getStudentsByCourse(int $courseId): Collection;
    public function filterByCategoryWithName(?int $categoryId, ?string $name): Collection;
}