<x-app-layout>
    <x-crud-create
        title="Create Outlet Services"
        :fields="[
            'name' => 'text',
            'service_type' => 'text',
            'price' => 'number'
        ]"
        :model="$outlet"
        action="{{ route('outlet.services.store', $outlet) }}"
        redirectRoute="outlet.services.index"
        />
    </x-app-layout>