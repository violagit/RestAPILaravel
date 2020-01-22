<?php

namespace App\Exports;

use App\Poll;
use Maatwebsite\Excel\Concerns\FromCollection;

class PollsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Poll::all();
    }
}
