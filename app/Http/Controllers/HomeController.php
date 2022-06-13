<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request): Renderable
    {
        $data = [];
        if (auth()->user()['is_admin']) {
            $courses = Course::query()->whereHas('allocations', function ($q) {
                $q->where('semester_id', get_current_semester_id());
            })->get();
        } else {
            $courses = $request->user()->courses()->whereHas('allocations', function ($q) {
                $q->where('semester_id', get_current_semester_id());
            })->get();
        }

        foreach ($courses as $key => $course) {
            $percentage = $course->assessments()->sum('percentage');
            $series = Student::query()
                ->leftJoin('results', 'results.student_id', '=', 'students.id')
                ->select(
                    'matric_number',
                    DB::raw("ROUND((COALESCE(SUM(score), 0) / $percentage) * 30) as score")
                )
                ->where('students.semester_id', get_current_semester_id())
                ->where('results.is_treated', true)
                ->where('students.course_id', $course->id)
                ->groupBy('students.id', 'matric_number')
                ->orderByDesc('score')
                ->get()
                ->take(5)
                ->each(function ($data) {
                    return $data['score'] = (int) $data['score'];
                })
                ->pluck('score');

            $labels = Student::query()
                ->leftJoin('results', 'results.student_id', '=', 'students.id')
                ->select(
                    'matric_number',
                    DB::raw("ROUND((COALESCE(SUM(score), 0) / $percentage) * 30) as score")
                )
                ->where('students.semester_id', get_current_semester_id())
                ->where('students.course_id', $course->id)
                ->where('results.is_treated', true)
                ->groupBy('students.id', 'matric_number')
                ->orderByDesc('score')
                ->get()
                ->take(5)
                ->pluck('matric_number');

            $data[$key]['series'] = $series;
            $data[$key]['labels'] = $labels;
            $data[$key]['course'] = $course;
        }
        return view('dashboard', ['charts' => $data]);
    }
}
