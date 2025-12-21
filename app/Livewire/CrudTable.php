<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class CrudTable extends Component
{
    use WithPagination;

    public $model;         // e.g., 'App\Models\Outlet'
    public $columns = [];  // e.g., ['nama', 'alamat', 'telp']
    public $title = '';
    public $search = '';
    public $createRoute;
    public $editRoute;


    protected $queryString = ['search'];

    public function mount($model, $columns, $title = '', $createRoute = null, $editRoute = null)
    {
        $this->model = "App\\Models\\" . $model;
        $this->columns = $columns;
        $this->title = $title ?: $model;
        $this->createRoute = $createRoute;
        $this->editRoute = $editRoute;
    }

    public function render()
    {
        $query = $this->model::query();

        // Dynamic search
        if ($this->search) {
            foreach ($this->columns as $col) {
                $query->orWhere($col, 'like', '%' . $this->search . '%');
            }
        }

        $rows = $query->paginate(5);

        return view('livewire.crud-table', [
            'rows' => $rows,
            'columns' => $this->columns,
            'title' => $this->title,
            'modelName' => $this->model
        ]);
    }

    public function edit($id)
    {
        // You can implement a modal later
    }

    public function delete($id)
    {
        $this->model::find($id)->delete();
    }
}

