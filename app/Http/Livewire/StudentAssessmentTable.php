<?php

namespace App\Http\Livewire;

use App\Models\Result;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;

class StudentAssessmentTable extends LivewireDatatable
{
    public $model = Result::class;

    public function builder(): Builder
    {
        return Result::query()
            ->with('student')
            ->where('assessment_id', session('current_assessment'));
    }

    public function columns(): array
    {
        return [
            NumberColumn::name('id')
                ->label('SN')
                ->sortBy('id')
                ->setType('sn')
                ->width(0.1),

            Column::callback(['student.firstname', 'student.lastname'], function ($first, $last) {
                return $first .' '. $last;
            })
                ->label('Name')
                ->searchable(),

            Column::name('student.matric_number')
                ->label('Matric No')
                ->searchable(),

            Column::name('score')
                ->label('Score')
                ->searchable()
                ->sortBy('score'),

            Column::name('remark')
                ->label('Remark')
                ->searchable()
                ->editable(get_current_semester_status() != 'closed')
                ->sortBy('score'),

            DateColumn::name('created_at')
                ->format('Y-m-d')
                ->headerAlignCenter()
                ->contentAlignCenter()
                ->label('Date Added')
                ->sortBy('created_at'),

            Column::callback(['id'], function ($id) {
                return view('livewire.assessments.student-table-actions', ['id' => $id]);
            })
                ->headerAlignCenter()
                ->contentAlignCenter()
                ->label('Action')
                ->unsortable()
        ];
    }
}
