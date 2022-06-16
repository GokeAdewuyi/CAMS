<?php

namespace App\Http\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;

class StudentTable extends LivewireDatatable
{
    public $model = \App\Models\Student::class;

    public function builder(): Builder
    {
        return \App\Models\Student::query()
            ->where('semester_id', get_current_semester_id())
            ->where('course_id', session('current_course'))
            ->orderBy('matric_number');
    }

    public function columns(): array
    {
        return [
            NumberColumn::name('id')
                ->label('SN')
                ->sortBy('id')
                ->setType('sn')
                ->width(0.1),

            Column::name('firstname')
                ->label('Firstname')
                ->searchable()
                ->editable(get_current_semester_status() != 'closed')
                ->sortBy('firstname'),

            Column::name('lastname')
                ->label('Lastname')
                ->searchable()
                ->editable(get_current_semester_status() != 'closed')
                ->sortBy('lastname'),

            Column::name('matric_number')
                ->label('Matric No.')
                ->searchable()
                ->defaultSort('asc')
                ->sortBy('matric_number'),

            Column::name('level')
                ->label('Level')
                ->searchable()
                ->editable(get_current_semester_status() != 'closed')
                ->sortBy('level'),

            DateColumn::name('created_at')
                ->format('Y-m-d')
                ->label('Date Added')
                ->sortBy('created_at'),

            Column::callback(['id'], function ($id) {
                $student = \App\Models\Student::where('course_id', session('current_course'))
                    ->where('semester_id', get_current_semester_id())
                    ->where('id', $id)
                    ->first();
                return view('livewire.students.table-actions', ['id' => $id, 'student' => $student]);
            })
                ->label('Action')
                ->unsortable()
        ];
    }
}
