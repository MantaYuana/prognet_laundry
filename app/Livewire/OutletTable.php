<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Outlet;

class OutletTable extends Component
{
    use WithPagination;

    public $search = '';

    protected $queryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $rows = Outlet::query()
            ->when($this->search, function ($query) {
                $query->where('nama', 'like', '%' . $this->search . '%')
                      ->orWhere('alamat', 'like', '%' . $this->search . '%')
                      ->orWhere('telp', 'like', '%' . $this->search . '%');
            })
            ->paginate(5);

        return view('livewire.outlet-table', compact('rows'));
    }
}
