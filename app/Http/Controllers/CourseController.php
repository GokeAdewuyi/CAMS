<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function allocate(Request $request)
    {
        $this->validate($request, [
            'lecturers' => 'required|array|min:1',
            'lecturers.*' => 'exists:users,id',
            'semester' => 'required|exists:semesters,id'
        ]);
        $course = Course::find($request->input('course'));
        if (!$course) {
            session()->flash('error', 'Course not found.');
            return redirect()->route('courses');
        }
        $course->lecturers()->syncWithPivotValues($request->input('lecturers'), ['semester_id' => $request->input('semester')]);
        session()->flash('message', 'Course allocated successfully');
        return redirect()->route('courses');
    }

    public function fetchLecturers($course, $semester): Collection|array
    {
        return User::query()
            ->whereHas('allocations', function ($q) use ($course, $semester) {
                $q->where('semester_id', $semester)
                    ->where('course_id', $course);
            })->get();
    }
}
