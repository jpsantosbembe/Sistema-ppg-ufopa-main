<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class QualisByProgramExport implements FromView
{
    use Exportable;
    public $data;
    public $info;
    public function __construct($data,$info)
    {
        $this->data = $data;
        $this->info = $info;

    }
    public function view(): View
    {
        return view('reports.qualis-report', ['data'=>$this->data,'info'=>$this->info]);
    }
}
