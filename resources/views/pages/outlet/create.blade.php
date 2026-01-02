<x-app-layout>
    <div class="px-24 py-8">
        <livewire:crud-create
        model="Outlet"
        :fields="[
            'name' => 'text',
            'address' => 'textarea',
            'phone_number' => 'text'
        ]"
        title="Create Outlet"
        redirectRoute="outlet.index"
    />
    </div>
</x-app-layout>