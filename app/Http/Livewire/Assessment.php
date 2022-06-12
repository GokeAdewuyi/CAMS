<?php

namespace App\Http\Livewire;

use Illuminate\Contracts\Support\Renderable;
use Livewire\Component;
use Maatwebsite\Excel\Concerns\Importable;

class Assessment extends Component
{
    use Importable;
    public $model = \App\Models\Assessment::class;
    public bool $openModal = false, $openResultModal = false;
    public string $title, $percentage, $score, $remark, $student;
    public $course, $assessment;

    public function render(): Renderable
    {
        if (request('b')) session(['current_course' => '']);
        else session(['current_course' => request('c') ?? session('current_course')]);
        if (request('r')) session(['current_assessment' => '']);
        else session(['current_assessment' => request('a') ?? session('current_assessment')]);
        $this->setCourse();
        return view('livewire.assessments.index', ['course' => $this->course]);
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
        if (session('current_course') && session('current_assessment'))
            $this->assessment = \App\Models\Assessment::query()
                ->where(function ($q) {
                    $q->where('id', session('current_assessment'))
                        ->where('course_id', session('current_course'))
                        ->where('user_id', auth()->id());
                })->first();
        else
            $this->assessment = null;
    }

    public function create()
    {
        $this->setCourse();
        $this->resetCreateForm();
        $this->openModalPopover();
    }

    public function createResult()
    {
        $this->setCourse();
        $this->resetCreateForm();
        $this->openResultModalPopover();
    }

    public function openModalPopover()
    {
        $this->openModal = true;
    }

    public function openResultModalPopover()
    {
        $this->openResultModal = true;
    }

    public function closeModalPopover()
    {
        $this->setCourse();
        $this->openModal = false;
    }

    public function closeResultModalPopover()
    {
        $this->setCourse();
        $this->openResultModal = false;
    }

    private function resetCreateForm()
    {
        $this->title = '';
        $this->percentage = '';
        $this->score = '';
        $this->remark = '';
        $this->student = '';
    }

    public function store()
    {
        $this->setCourse();
        $this->validate([
            'title' => 'required',
            'percentage' => 'required',
        ]);

        request()->user()->assessments()->create([
            'semester_id' => get_current_semester_id(),
            'course_id' => $this->course['id'],
            'title' => $this->title,
            'percentage' => $this->percentage
        ]);
        session()->flash('message', 'Assessment created successfully.');
        $this->closeModalPopover();
        $this->resetCreateForm();
        return redirect()->route('assessments');
    }

    public function result()
    {
        $this->setCourse();
        $this->validate([
            'student' => 'required|exists:students,id',
            'score' => 'required'
        ]);

        $assessment = \App\Models\Assessment::find(session('current_assessment'));
        $assessment?->results()->create([
            'student_id' => $this->student,
            'score' => $this->score,
            'remark' => $this->remark
        ]);
        session()->flash('message', 'Result added successfully.');
        $this->closeResultModalPopover();
        $this->resetCreateForm();
        return redirect()->route('assessments');
    }

    public function upload(): Renderable
    {
        $this->setCourse();
        return view('livewire.assessments.upload', ['assessment' => $this->assessment]);
    }

    public function delete($id)
    {
        \App\Models\Assessment::find($id)->delete();
        session()->flash('message', 'Assessment deleted.');
        return redirect()->route('assessments');
    }
}
