<x-app-layout>
    <x-crud-edit
        title="Edit Outlet"
        :fields="[
            'name' => 'text',
            'address' => 'textarea',
            'phone_number' => 'text'
        ]"
        :model="$outlet"
        action="{{ route('outlet.update', $outlet) }}"
        method="PUT"
        redirectRoute="outlet.index"
    />
</x-app-layout>
