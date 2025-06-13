<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\CoursesRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Course;
use App\Models\Student;

class CourseController extends Controller
{
    private $coursesRepository;

    public function __construct(CoursesRepositoryInterface $coursesRepository)
    {
        $this->coursesRepository = $coursesRepository;
    }

    public function index(){
        $courses = $this->coursesRepository->allWithCategoryAndEnrollments();
        $categories = Category::all();

        return view('pages/view_courses', [
            'courses' => $courses,
            'categories' => $categories
        ]);
    }

    public function create()
    {
        $categories = Category::all();
        return view('pages.add_courses', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'fee' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id'
        ]);

        $data = $this->coursesRepository->create($validated);

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function edit($id)
    {
        $course = $this->coursesRepository->find($id);
        $categories = Category::all();
        return view('pages.edit_courses', compact('course', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'fee' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id'
        ]);

        $data = $this->coursesRepository->update($id, $validated);

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function destroy($id)
    {
        $this->coursesRepository->delete($id);

        return redirect()->route('courses.index')
                         ->with('success', 'Course deleted successfully!');
    }

    public function show($id)
    {
        $course = Course::with(['students' => function($query) {
            $query->withPivot('enrolled_at');
        }])->findOrFail($id);
        
        $availableStudents = Student::whereDoesntHave('courses', function($query) use ($id) {
            $query->where('course_id', $id);
        })->get();
        
        return view('pages.enrollment', [
            'course' => $course,
            'enrolledStudents' => $course->students,
            'availableStudents' => $availableStudents
        ]);
    }

    public function studentsByCourse(int $courseId)
    {
        $students = $this->coursesRepository->getStudentsByCourse($courseId);
        return response()->json($students);
    }

    public function filter(Request $request)
    {
        $categoryId = $request->input('category_id');
        $name = $request->input('name');
        
        $courses = $this->coursesRepository->filterByCategoryWithName($categoryId, $name);
        $categories = Category::all();

        return view('pages.view_courses', [
            'courses' => $courses,
            'categories' => $categories
        ]);
    }

    public function coursesApi()
    {
        $courses = $this->coursesRepository->allWithCategoryAndEnrollments();
        return response()->json($courses);
    }

    public function filterApi(Request $request)
    {
        $categoryId = $request->input('category_id');
        $name = $request->input('name');
        
        $courses = $this->coursesRepository->filterByCategoryWithName($categoryId, $name);
        return response()->json($courses);
    }
}
