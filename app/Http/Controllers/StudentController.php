<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\StudentRepositoryInterface;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    private $studentRepository;

    public function __construct(StudentRepositoryInterface $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    public function index()
    {
        $students = $this->studentRepository->all();
        return view('pages.view_students', compact('students'));
    }

    public function create()
    {
        return view('pages.add_students');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email'
        ]);

        $data = $this->studentRepository->create($validated);

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function edit($id)
    {
        $student = $this->studentRepository->find($id);
        return view('pages.edit_students', compact('student'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,'.$id
        ]);

        $data = $this->studentRepository->update($id, $validated);

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function destroy($id)
    {
        $this->studentRepository->delete($id);

        return redirect()->route('students.index')
                         ->with('success', 'Student deleted successfully!');
    }
}
