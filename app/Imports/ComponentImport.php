<?php

namespace App\Imports;

use App\Models\Component;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;


class ComponentImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Component([
            'component_code'    => $row['1'],
            'component_name'    => $row['2'],
        ]);
    }
    // public function startRow(): int
    // {
    //     return 1;
    // }
}

