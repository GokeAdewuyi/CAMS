<?php

namespace App\Http\Livewire;

use App\Exports\AssessmentReport;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ReportTable extends LivewireDatatable
{
    public $course, $total;

    public function builder(): Builder
    {
        return \App\Models\Student::query()
            ->with('results')
            ->where('semester_id', get_current_semester_id())
            ->where('course_id', $this->course)
            ->orderBy('matric_number');
    }

    public function columns(): array
    {
        return [
            NumberColumn::name('id')
                ->label('SN')
                ->sortBy('id')
                ->setType('sn')
                ->excludeFromExport()
                ->width(0.1),

            Column::callback(['firstname', 'lastname'], function ($first, $last) {
                return $last .' '. $first;
            })
                ->label('Name')
                ->sortBy('lastname')
                ->searchable(),

            Column::name('matric_number')
                ->label('Matric Number')
                ->sortBy('matric_number')
                ->defaultSort()
                ->searchable(),

            Column::name('results.score')
                ->label('Score')
                ->setType('grade')
                ->searchable()
        ];
    }

    public function headings(): array
    {
        return ['Name', 'Matric Number', 'Score'];
    }

    public function export(string $filename = 'report.xlsx'): BinaryFileResponse
    {
        return Excel::download(new AssessmentReport($this->course), $filename);
    }
}
