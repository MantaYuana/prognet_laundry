<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Schema;

class CrudEdit extends Component
{
    public $model;
    public $fields = [];
    public $title = '';
    public $redirectRoute;
    public $id;

    public $form = [];

    public function mount($model, $fields, $id, $title = '', $redirectRoute = null)
    {
        $this->model = "App\\Models\\" . $model;
        $this->fields = $fields;
        $this->id = $id;
        $this->title = $title ?: "Edit $model";
        $this->redirectRoute = $redirectRoute;

        // ambil data lama
        $record = $this->model::findOrFail($this->id);

        foreach ($fields as $name => $type) {
            $this->form[$name] = $record->$name;
        }
    }

    public function save()
    {
        $this->validate(
            collect($this->fields)->mapWithKeys(fn ($type, $name) => [
                "form.$name" => 'required'
            ])->toArray()
        );

        $record = $this->model::findOrFail($this->id);

        $data = $this->form;

        // jaga-jaga kalau ada user_id
        if (auth()->check() && Schema::hasColumn($record->getTable(), 'user_id')) {
            $data['user_id'] = $record->user_id;
        }

        $record->update($data);

        if ($this->redirectRoute) {
            return redirect()->route($this->redirectRoute);
        }

        session()->flash('success', 'Data berhasil diupdate');
    }

    public function render()
    {
        return view('livewire.crud-edit');
    }
}
