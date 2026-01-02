<?php

namespace App\Livewire;

use Livewire\Component;

class CrudCreate extends Component
{
    public $model;
    public $fields = [];
    public $title = '';
    public $redirectRoute;

    public $form = [];

    public function mount($model, $fields, $title = '', $redirectRoute = null)
    {
        $this->model = "App\\Models\\" . $model;
        $this->fields = $fields;
        $this->title = $title ?: "Create $model";
        $this->redirectRoute = $redirectRoute;

        foreach ($fields as $name => $type) {
            $this->form[$name] = '';
        }
    }

    public function save()
    {
        $data = $this->form;

        $this->validate(
            collect($this->fields)->mapWithKeys(fn($type, $name) => [
                "form.$name" => 'required'
            ])->toArray()
        );

        auth()->user()->outlets()->create($data);

        if ($this->redirectRoute) {
            return redirect()->route($this->redirectRoute);
        }

        $this->reset('form');
        session()->flash('success', 'Data is successfully created');
    }

    public function render()
    {
        return view('livewire.crud-create');
    }
}
