<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CrudEdit extends Component
{
    public string $title;
    public array $fields;
    public object $model;
    public string $action;
    public string $method;
    public ?string $redirectRoute;

    public function __construct(
        string $title,
        array $fields,
        object $model,
        string $action,
        string $method = 'POST',
        string $redirectRoute = null
    ) {
        $this->title = $title;
        $this->fields = $fields;
        $this->model = $model;
        $this->action = $action;
        $this->method = $method;
        $this->redirectRoute = $redirectRoute;
    }

    public function render()
    {
        return view('components.crud-edit');
    }
}
