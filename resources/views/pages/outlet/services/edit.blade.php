<x-app-layout>
    <x-crud-edit
        title="Edit Outlet Service"
        :fields="[
            'name' => 'text',
            'service_type' => 'text',
            'price' => 'number'
        ]"
        :model="$service"
        action="{{ route('outlet.services.update', [$outlet, $service]) }}"
        method="PUT"
        redirectRoute="outlet.services.index"
    />
</x-app-layout>
