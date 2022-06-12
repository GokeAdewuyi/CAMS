<?php

namespace App\Http\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;

class AssessmentTable extends LivewireDatatable
{
    public $model = \App\Models\Assessment::class;

    public function builder(): Builder
    {
        return \App\Models\Assessment::query()
            ->where('semester_id', get_current_semester_id())
            ->where('course_id', session('current_course'))
            ->where('user_id', auth()->id());
    }

    public function columns(): array
    {
        $arr =  [
            NumberColumn::name('id')
                ->label('SN')
                ->sortBy('id')
                ->setType('sn')
                ->width(0.1),

            Column::name('title')
                ->label('Title')
                ->searchable()
                ->editable(get_current_semester_status() != 'closed')
                ->sortBy('title'),

            Column::name('percentage')
                ->label('Percentage')
                ->searchable()
                ->editable(get_current_semester_status() != 'closed')
                ->sortBy('percentage'),

            DateColumn::name('created_at')
                ->format('Y-m-d')
                ->headerAlignCenter()
                ->contentAlignCenter()
                ->label('Date Added')
                ->sortBy('created_at')
        ];

        if(get_current_semester_status() != 'closed')
            $arr[] = Column::callback(['id'], function ($id) {
                return view('livewire.assessments.table-actions', ['id' => $id]);
            })
                ->headerAlignCenter()
                ->contentAlignCenter()
                ->label('Action')
                ->unsortable();

        return $arr;
    }
}
