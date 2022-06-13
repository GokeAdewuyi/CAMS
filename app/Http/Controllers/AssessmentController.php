<?php

namespace App\Http\Controllers;

use App\Exports\AssessmentReport;
use App\Exports\Template\AssessmentTemplate;
use App\Imports\Template\Student;
use App\Models\Assessment;
use App\Models\Result;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AssessmentController extends Controller
{
    public static function studentExists($assessment, $matric): object|null
    {
        return \App\Models\Student::query()
            ->where('semester_id', get_current_semester_id())
            ->where('course_id', $assessment->course->id)
            ->where('matric_number', $matric)
            ->first();
    }

    public static function studentHasAssessment($assessment, $student): object|null
    {
        return Result::query()
            ->where('assessment_id', $assessment['id'])
            ->where('student_id', $student)
            ->first();
    }

    /**
     * @throws ValidationException
     */
    public function process(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'file' => 'required|mimes:xlsx'
        ]);
        $rows = Excel::toArray(new Student, $request->file('file'))[0];
        $headers = $rows[0];
        unset($rows[0]);
        if ($headers != ['matric number','score','remark'])
            return back()->with('message', 'Invalid file uploaded, see template.')->withInput();
        $data = $exists = [];
        $assessment = Assessment::find(session('current_assessment'));
        if (!$assessment) return back()->with('error', 'An error occurred, please try again.');
        foreach ($rows as $row) {
            $datum = [];
            foreach ($row as $key => $item) {
                $datum[$headers[$key]] = $item;
                $datum['assessment_id'] = $assessment['id'];
                $datum['is_treated'] = true;
                $datum['created_at'] = now();
                $datum['updated_at'] = now();
            }
            if ($datum['score'] > $assessment['percentage']) $datum['score'] = $assessment['percentage'];
            if ($student = self::studentExists($assessment, $datum['matric number'])) {
                $datum['student_id'] = $student['id'];
                unset($datum['matric number']);
                if (self::studentHasAssessment($assessment, $student['id'])) $exists[] = $datum;
                else $data[] = $datum;
            }
        }
        if ($data) DB::table('results')->insert($data);
        if ($exists)
            foreach ($exists as $exist)
                self::studentHasAssessment($assessment, $exist['student_id'])->update([
                    'score' => $exist['score'],
                    'remark' => $exist['remark'],
                    'is_treated' => true
                ]);

        return redirect()->route('assessments')->with('message', 'Results uploaded successfully.');
    }

    public function delete(Result $result): RedirectResponse
    {
        $result->delete();
        return back()->with('message', 'Result deleted.');
    }

    public function template(): BinaryFileResponse
    {
        return Excel::download(new AssessmentTemplate, 'results.xlsx');
    }

    public function report(): BinaryFileResponse
    {
        return Excel::download(new AssessmentReport(request('c')), 'report.xlsx');
    }
}
