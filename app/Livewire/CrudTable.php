<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Pagination\LengthAwarePaginator;

class CrudTable extends Component
{

    public $model;          // e.g., 'App\Models\Outlet'
    public $sourceRows; // data dari controller (collection)
    public $columns = [];   // e.g., ['nama', 'alamat', 'telp']

    public $title = '';
    public $createRoute;
    public $editRoute;

    public string $search = '';
    public int $page = 1;

    public $perPage = 5;


    public function mount($rows, $columns, $title = '', $createRoute = null, $editRoute = null)
    {
        $this->sourceRows = collect($rows);
        $this->columns = $columns;
        $this->title = $title;
        $this->createRoute = $createRoute;
        $this->editRoute = $editRoute;
    }

    public function render()
    {
        // Filter data berdasarkan input search
        $filtered = $this->sourceRows->filter(function ($item) {
            if ($this->search === '')
                return true;

            foreach ($this->columns as $col) {
                if (
                    isset($item->$col) &&
                    str_contains(
                        strtolower((string) $item->$col),
                        strtolower($this->search)
                    )
                ) {
                    return true;
                }
            }
            return false;
        });

        // Tentukan halaman aktif untuk pagination
        $page = $this->page;

        // Lakukan pagination manual tanpa query database
        $rows = new LengthAwarePaginator(
            $filtered->forPage($page, $this->perPage)->values(),
            $filtered->count(),
            $this->perPage,
            $page,
            ['path' => request()->url()]
        );

        // Kirim data hasil filter dan pagination ke view
        return view('livewire.crud-table', [
            'rows' => $rows
        ]);
    }
    public function updatedSearch()
    {
        $this->page = 1;
    }


    public function edit($id)
    {
        // You can implement a modal later
    }

    public function delete($id)
    {
        $this->model::find($id)->delete();
    }

    public function nextPage()
    {
        $this->page++;
    }

    public function previousPage()
    {
        $this->page = max(1, $this->page - 1);
    }

}

