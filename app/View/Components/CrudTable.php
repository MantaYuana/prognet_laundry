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
    public ?string $deleteRoute;
    public array $routeParams;
    public ?string $rowParamKey;

    public function __construct(
        LengthAwarePaginator $rows,
        array $columns,
        string $title = '',
        ?string $createRoute,
        ?string $editRoute,
        ?string $deleteRoute, 
        array $routeParams = [],
        ?string $rowParamKey = null
    ) {
        $this->rows = $rows;
        $this->columns = $columns;
        $this->title = $title;
        $this->createRoute = $createRoute;
        $this->editRoute = $editRoute;
        $this->deleteRoute = $deleteRoute;
        $this->routeParams = $routeParams;
        $this->rowParamKey = $rowParamKey;
    }

    public function render()
    {
        return view('components.crud-table');
    }
}
