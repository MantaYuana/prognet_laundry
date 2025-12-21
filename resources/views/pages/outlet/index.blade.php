@section('title', 'Home Page Title')

<x-app-layout>
    <div class="px-24 py-8">
        <livewire:crud-table
            model="Outlet"
            :columns="['name', 'address', 'phone_number']"
            title="Outlet"
            createRoute="outlet.create"
            editRoute="outlet.edit"
        />
    </div>
</x-app-layout>
