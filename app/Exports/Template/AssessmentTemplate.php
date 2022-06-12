<?php

namespace App\Exports\Template;

use JetBrains\PhpStorm\ArrayShape;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AssessmentTemplate implements FromArray, WithHeadings, WithColumnWidths
{
    public function array(): array
    {
        return [
            [
                'matric number' => '160211003',
                'score' => '29',
                'remark' => 'Excellent'
            ],
            [
                'matric number' => '160211007',
                'score' => '22',
                'remark' => 'Good Job'
            ],
        ];
    }

    public function headings(): array
    {
        return [
            'matric number',
            'score',
            'remark'
        ];
    }

    #[ArrayShape(['A' => "int", 'B' => "int", 'C' => "int"])]
    public function columnWidths(): array
    {
        return ['A' => 15, 'B' => 10, 'C' => 20];
    }
}
