@extends('layouts.app')

@section('content')
    <div>
        <livewire:crud-table
            model="Outlet"
            :columns="['nama', 'alamat', 'telp']"
            title="Data Outlet"
        />
    </div>
@endsection
