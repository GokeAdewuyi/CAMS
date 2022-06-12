<?php

namespace App\Http\Controllers;

use App\Exports\Template\StudentTemplate;
use App\Imports\Template\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class StudentController extends Controller
{
    public static function studentExists($data): object|null
    {
        return \App\Models\Student::query()
            ->where('course_id', $data['course_id'])
            ->where('semester_id', get_current_semester_id())
            ->where('matric_number', $data['matric_number'])
            ->first();
    }

    /**
     * @throws ValidationException
     */
    public function process(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'course' => 'required|exists:courses,id',
            'file' => 'required|mimes:xlsx'
        ]);
        $rows = Excel::toArray(new Student, $request->file('file'))[0];
        $headers = $rows[0];
        unset($rows[0]);
        if ($headers != ['firstname','lastname','othername','email','matric number','level'])
            return back()->with('message', 'Invalid file uploaded, see template.')->withInput();
        $headers[4] = 'matric_number';
        $data = $exists =  [];
        foreach ($rows as $row) {
            $datum = [];
            foreach ($row as $key => $item) {
                $datum[$headers[$key]] = $item;
                $datum['semester_id'] = get_current_semester_id();
                $datum['course_id'] = $request->input('course');
                $datum['created_at'] = now();
                $datum['updated_at'] = now();
            }
            if (self::studentExists($datum)) $exists[] = $datum;
            else$data[] = $datum;
        }
        if ($data) DB::table('students')->insert($data);
        if ($exists)
            foreach ($exists as $exist)
                self::studentExists($exist)->update([
                    'firstname' => $exist['firstname'],
                    'lastname' => $exist['lastname'],
                    'othername' => $exist['othername'],
                    'email' => $exist['email'],
                    'level' => $exist['level']
                ]);

        return redirect()->route('students')->with('message', 'Students uploaded successfully.');
    }

    public function template(): BinaryFileResponse
    {
        return Excel::download(new StudentTemplate, 'students.xlsx');
    }
}
