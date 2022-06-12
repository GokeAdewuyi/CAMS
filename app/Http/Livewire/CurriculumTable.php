<?php

namespace App\Http\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;

class CurriculumTable extends LivewireDatatable
{
    public $model = \App\Models\Curriculum::class;

    public function builder(): Builder
    {
        return \App\Models\Curriculum::query()->withCount('courses')->orderBy('name');
    }

    public function columns(): array
    {
        return [
            NumberColumn::name('id')
                ->label('SN')
                ->sortBy('id')
                ->setType('sn')
                ->width(0.1),

            Column::name('name')
                ->label('Name')
                ->searchable()
                ->editable()
                ->sortBy('name'),

            Column::name('description')
                ->label('Description')
                ->searchable()
                ->editable()
                ->sortBy('description'),

            DateColumn::name('created_at')
                ->format('Y-m-d')
                ->label('Date Added')
                ->sortBy('created_at'),

            Column::callback(['id'], function ($id) {
                return view('admin.curricula.table-actions', ['id' => $id]);
            })
                ->label('Action')
                ->unsortable()
        ];
    }
}
