<?php

namespace App\Http\Livewire;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Validation\Rule;
use Livewire\Component;
use function view;

class Course extends Component
{
    public $model = \App\Models\Course::class;
    public string $code, $title, $unit, $curriculum;
    public bool $openModal = false;

    public function render(): Renderable
    {
        if (auth()->user()['is_admin'])
            return view('admin.courses.index');
        return view('livewire.courses.index');
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
        $this->curriculum = '';
        $this->code = '';
        $this->title = '';
        $this->unit = '';
    }

    public function store()
    {
        $this->validate([
            'curriculum' => 'required|exists:curricula,id',
            'code' => ['required', Rule::unique('courses')->where('curriculum_id', $this->curriculum)],
            'title' => 'required',
            'unit' => 'required|integer'
        ]);

        \App\Models\Course::create([
            'curriculum_id' => $this->curriculum,
            'code' => $this->code,
            'title' => $this->title,
            'unit' => $this->unit,
        ]);
        session()->flash('message', 'Course added successfully.');
        $this->closeModalPopover();
        $this->resetCreateForm();
        return redirect()->route('courses');
    }

    public function delete($id)
    {
        \App\Models\Course::find($id)->delete();
        session()->flash('message', 'Course deleted successfully.');
    }
}
