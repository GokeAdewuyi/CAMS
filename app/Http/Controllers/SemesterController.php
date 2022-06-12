<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SemesterController extends Controller
{
    /**
     * @throws ValidationException
     */
    public function update(Request $request, Semester $semester): RedirectResponse
    {
        $this->validate($request, ['status' => 'required|in:current,open,closed']);
        $semester->update(['status' => $request->input('status')]);
        if ($request->input('status') == 'current')
            self::syncSemester($semester['id']);
        session()->flash('message', 'Semester status updated successfully');
        return redirect()->route('semesters');
    }

    public static function syncSemester($id)
    {
        DB::table('semesters')
            ->where('status', 'current')
            ->where('id', '!=', $id)
            ->update(['status' => 'open']);
    }

    /**
     * @throws ValidationException
     */
    public function set(Request $request): RedirectResponse
    {
        $this->validate($request, ['semester' => 'required|exists:semesters,id']);
        session(['current_semester' => $request->input('semester')]);
        return back()->with('semester_saved', 'true');
    }
}
