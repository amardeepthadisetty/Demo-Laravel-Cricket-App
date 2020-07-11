<?php

namespace App\Imports;

use App\product;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToCollection, WithChunkReading,WithHeadingRow
{
     use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    /*public function model(array $row)
    {
       //echo "<pre>";
       return $row;
    }*/

     public function collection(Collection $rows)
    {
       
    }

    public function chunkSize(): int
    {
        return 500;
    }
}
