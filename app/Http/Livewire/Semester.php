<?php

namespace App\Http\Livewire;

use App\Http\Controllers\SemesterController;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;
use function view;

class Semester extends Component
{
    public $model = \App\Models\Semester::class;
    public string $name, $session, $semester, $status;
    public bool $openModal = false;

    public function render(): Renderable
    {
        return view('admin.semesters.index');
    }

    public function create()
    {
        $this->resetCreateForm();
        $this->openModalPopover();
    }

    public function openModalPopover()
    {
        $this->openModal = true;
    }
    public function closeModalPopover()
    {
        $this->openModal = false;
    }
    private function resetCreateForm()
    {
        $this->name = '';
        $this->session = '';
        $this->semester = '';
        $this->status = '';
    }

    public function store()
    {
        $this->validate([
            'session' => 'required',
            'semester' => ['required', Rule::unique('semesters', 'type')->where('session', $this->session)],
        ]);

        $semester = \App\Models\Semester::create([
            'name' => $this->name,
            'session' => $this->session,
            'type' => $this->semester,
            'status' => $this->status ? 'current' : 'open'
        ]);
        if ($this->status) SemesterController::syncSemester($semester->id);
        session()->flash('message', 'Semester added successfully.');
        $this->closeModalPopover();
        $this->resetCreateForm();
        return redirect()->route('semesters');
    }

    public function delete($id)
    {
        \App\Models\Course::find($id)->delete();
        session()->flash('message', 'Semester deleted successfully.');
    }
}
