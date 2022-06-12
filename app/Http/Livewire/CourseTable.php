<?php

namespace App\Http\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;

class CourseTable extends LivewireDatatable
{
    public $model = \App\Models\Course::class;
    public string $semester = '';

    public function builder(): Builder
    {
        if (request()->user()['is_admin'])
            return \App\Models\Course::query()->with('curriculum')->orderBy('code');
        return \App\Models\Course::query()
            ->whereHas('allocations', function ($query) {
                $query->where('user_id', auth()->id())
                    ->where('semester_id', get_current_semester_id());
            })
            ->with('curriculum')
            ->orderBy('code');
    }

    public function columns(): array
    {
        $arr =  [
            NumberColumn::name('id')
                ->label('SN')
                ->sortBy('id')
                ->setType('sn')
                ->width(0.1)
        ];
        if (request()->user()['is_admin']) {
            $arr[] = Column::name('code')
                ->label('Code')
                ->searchable()
                ->editable()
                ->sortBy('code');

            $arr[] = Column::name('title')
                ->label('Title')
                ->searchable()
                ->editable()
                ->sortBy('title');

            $arr[] = Column::name('curriculum.name')
                ->label('Curriculum')
                ->searchable()
                ->sortBy('curriculum.name');

            $arr[] = NumberColumn::name('unit')
                ->label('Unit')
                ->alignCenter()
                ->searchable()
                ->editable()
                ->sortBy('unit');

            $arr[] = Column::callback(['id'], function ($id) {
                return view('admin.courses.table-actions', ['id' => $id]);
            })
                ->label('Action')
                ->unsortable();
        } else {
            $arr[] = Column::name('code')
                ->label('Code')
                ->searchable()
                ->sortBy('code');

            $arr[] = Column::name('title')
                ->label('Title')
                ->searchable()
                ->sortBy('title');

            $arr[] = Column::name('curriculum.name')
                ->label('Curriculum')
                ->searchable()
                ->sortBy('curriculum.name');

            $arr[] = NumberColumn::name('unit')
                ->label('Unit')
                ->alignCenter()
                ->searchable()
                ->sortBy('unit');

            $arr[] = Column::callback(['id'], function ($id) {
                return view('livewire.courses.table-actions', ['id' => $id]);
            })
                ->alignCenter()
                ->label('Action')
                ->maxWidth(0.5)
                ->unsortable();
        }

        return $arr;
    }
}
