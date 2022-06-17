<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;

class LecturerTable extends LivewireDatatable
{
    public $model = User::class;

    public function builder(): Builder
    {
        return User::query()->where('is_admin', false);
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

            Column::name('pfn')
                ->label('PFN')
                ->searchable()
                ->editable()
                ->sortBy('pfn'),

            Column::name('email')
                ->label('Email')
                ->searchable()
                ->sortBy('pfn'),

            DateColumn::name('created_at')
                ->format('Y-m-d')
                ->label('Date Added')
                ->sortBy('created_at'),

            Column::callback(['id'], function ($id) {
                return view('admin.lecturers.table-actions', ['id' => $id]);
            })
                ->label('Action')
                ->unsortable()
        ];
    }
}
