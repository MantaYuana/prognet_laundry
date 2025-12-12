<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CrudTable extends Component
{
    public $columns;
    public $data;
    public $pagination;

    public function __construct($columns = [], $data = [], $pagination = null)
    {
        $this->columns = $columns;
        $this->data = $data;
        $this->pagination = $pagination;
    }

    public function render()
    {
        return view('components.crud-table');
    }
}
