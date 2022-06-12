<?php

namespace App\Exports;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\ArrayShape;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AssessmentReport implements FromArray, WithHeadings, WithColumnWidths
{
    public int $course;

    public function __construct($course)
    {
        $this->course = $course;
    }

    public function array(): array
    {
        $total = [];
        $c = Course::find($this->course);
        if ($this->course && $c) {
            $percentage = $c->assessments()->where('semester_id', get_current_semester_id())->sum('percentage');
            $total = Student::query()
                ->leftJoin('results', 'results.student_id', '=', 'students.id')
                ->select(
                    DB::raw("CONCAT(lastname, ' ', firstname, ' ', (COALESCE(othername, ''))) as name"),
                    'matric_number',
                    DB::raw("ROUND((COALESCE(SUM(score), 0) / $percentage) * 30) as score")
                )
                ->where('students.semester_id', get_current_semester_id())
                ->where('students.course_id', $this->course)
                ->groupBy('students.id', 'matric_number')
                ->orderBy('matric_number')
                ->get()
                ->toArray();
        }
        return $total;
    }

    public function headings(): array
    {
        return [
            'Name',
            'Matric Number',
            'Score'
        ];
    }

    #[ArrayShape(['A' => "int", 'B' => "int", 'C' => "int"])]
    public function columnWidths(): array
    {
        return ['A' => 35, 'B' => 15, 'C' => 10];
    }

}
