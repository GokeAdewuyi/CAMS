<?php

namespace App\Imports\Template;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class Student implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        \App\Models\Student::all();
    }
}
