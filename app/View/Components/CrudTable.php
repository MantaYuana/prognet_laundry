<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CrudTable extends Component
{
    public LengthAwarePaginator $rows;
    public array $columns;
    public string $title;
    public ?string $createRoute;
    public ?string $editRoute;

    public function __construct(
        LengthAwarePaginator $rows,
        array $columns,
        string $title = '',
        string $createRoute = null,
        string $editRoute = null
    ) {
        $this->rows = $rows;
        $this->columns = $columns;
        $this->title = $title;
        $this->createRoute = $createRoute;
        $this->editRoute = $editRoute;
    }

    public function render()
    {
        return view('components.crud-table');
    }
}
