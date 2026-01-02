<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CrudCreate extends Component
{
    public string $title;
    public array $fields;
    public string $action;
    public ?string $redirectRoute;
    public ?object $model;

    public function __construct(
        string $title,
        array $fields,
        string $action,
        ?string $redirectRoute,
        ?object $model,
    ) {
        $this->title = $title;
        $this->fields = $fields;
        $this->action = $action;
        $this->redirectRoute = $redirectRoute;
        $this->model = $model;
    }

    public function render()
    {
        return view('components.crud-create');
    }
}
