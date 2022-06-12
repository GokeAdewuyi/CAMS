<?php

namespace App\Exports\Template;

use JetBrains\PhpStorm\ArrayShape;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentTemplate implements FromArray, WithHeadings, WithColumnWidths
{
    public function array(): array
    {
        return [
            [
                'firstname' => 'Ciro',
                'lastname' => 'Adewale',
                'othername' => 'Yusuf',
                'email' => 'ciro.adewale160211003@st.lasu.edu.ng',
                'matric number' => '160211003',
                'level' => '500'
            ],
            [
                'firstname' => 'Roland',
                'lastname' => 'Bello',
                'othername' => 'Sideeq',
                'email' => 'roland.bello160211007@st.lasu.edu.ng',
                'matric number' => '160211007',
                'level' => '500'
            ],
        ];
    }

    public function headings(): array
    {
        return [
            'firstname',
            'lastname',
            'othername',
            'email',
            'matric number',
            'level'
        ];
    }

    #[ArrayShape(['A' => "int", 'B' => "int", 'C' => "int", 'D' => "int", 'E' => "int", 'F' => "int"])]
    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 15,
            'C' => 15,
            'D' => 35,
            'E' => 15,
            'F' => 10
        ];
    }
}
