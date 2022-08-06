<?php

namespace App\Exports;

use App\Models\Component;
use Maatwebsite\Excel\Concerns\FromCollection;

class ComponentExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Component::all();
    }
}
