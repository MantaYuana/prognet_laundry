<x-app-layout>
    <livewire:crud-edit
        model="Outlet"
        :fields="[
            'name' => 'text',
            'address' => 'textarea',
            'phone_number' => 'text'
        ]"
        :id="$outlet->id"
        title="Edit Outlet"
        redirectRoute="outlet.index"
    />
</x-app-layout>
