<x-app-layout>
    <x-crud-create
        title="Create Outlet"
        :fields="[
            'name' => 'text',
            'address' => 'textarea',
            'phone_number' => 'text'
        ]"
        action="{{ route('outlet.store') }}"
        redirectRoute="outlet.index"
    />
</x-app-layout>
