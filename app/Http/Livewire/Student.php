<?php

namespace App\Http\Livewire;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Maatwebsite\Excel\Concerns\Importable;

class Student extends Component
{
    use Importable;
    public $model = \App\Models\Student::class;
    public bool $openModal = false;
    public string $firstname, $lastname, $othername, $email, $matric_number, $level;
    public $course;

    public function render(): Renderable
    {

        if (request('b'))
            session(['current_course' => '']);
        else
            session(['current_course' => request('c') ?? session('current_course')]);
        $this->setCourse();
        return view('livewire.students.index', ['course' => $this->course]);
    }

    public function setCourse()
    {
        if (session('current_course'))
            $this->course = request()->user()
                ->courses()
                ->withPivotValue([
                    'semester_id' => get_current_semester_id(),
                    'course_id' => session('current_course')
                ])->first();
        else
            $this->course = null;
    }

    public function upload(): Renderable
    {
        $this->setCourse();
        return view('livewire.students.upload', ['course' => $this->course]);
    }

    public function create()
    {
        $this->setCourse();
        $this->resetCreateForm();
        $this->openModalPopover();
    }

    public function openModalPopover()
    {
        $this->openModal = true;
    }
    public function closeModalPopover()
    {
        $this->setCourse();
        $this->openModal = false;
    }
    private function resetCreateForm()
    {
        $this->firstname = '';
        $this->lastname = '';
        $this->othername = '';
        $this->email = '';
        $this->matric_number = '';
        $this->level = '';
    }

    public function store()
    {
        $this->setCourse();
        $this->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'matric_number' => [
                'required',
                Rule::unique('students')
                    ->where('semester_id', get_current_semester_id())
                    ->where('course_id', $this->course['id'])
            ],
            'level' => 'required'
        ], [
            'matric_number.unique' => 'Student already added'
        ]);

        \App\Models\Student::create([
            'semester_id' => get_current_semester_id(),
            'course_id' => $this->course['id'],
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'othername' => $this->othername,
            'email' => $this->email,
            'matric_number' => $this->matric_number,
            'level' => $this->level
        ]);
        session()->flash('message', 'Student data added.');
        $this->closeModalPopover();
        $this->resetCreateForm();
        return redirect()->route('students');
    }

    public function delete($id)
    {
        \App\Models\Student::find($id)->delete();
        session()->flash('message', 'Student data deleted.');
        return redirect()->route('students');
    }
}
