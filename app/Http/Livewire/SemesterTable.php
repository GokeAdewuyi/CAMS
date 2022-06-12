<?php

namespace App\Http\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;

class SemesterTable extends LivewireDatatable
{
    public $model = \App\Models\Semester::class;

    public function builder(): Builder
    {
        return \App\Models\Semester::query()->orderByDesc('session');
    }

    public function columns(): array
    {
        return [
            NumberColumn::name('id')
                ->headerAlignCenter()
                ->label('SN')
                ->sortBy('id')
                ->setType('sn')
                ->width(0.1),

            Column::name('type')
                ->label('Semester')
                ->searchable()
                ->sortBy('type'),

            Column::name('session')
                ->label('Session')
                ->searchable()
                ->sortBy('session'),

            Column::name('status')
                ->headerAlignCenter()
                ->label('Status')
                ->setType('status')
                ->sortBy('status'),


            Column::callback(['id'], function ($id) {
                return view('admin.semesters.table-actions', ['id' => $id]);
            })
                ->label('Action')
                ->headerAlignCenter()
                ->unsortable()
        ];
    }
}
