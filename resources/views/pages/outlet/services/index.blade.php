<x-app-layout>
    <div class="px-24 py-8">
            <livewire:crud-table
                model="\App\Models\LaundryService"
                :rows="$laundry_service_paginated"
                :columns="['name', 'service_type', 'price']"
                title="Outlet Services"
                createRoute="outlet.services.create"
                editRoute="outlet.services.edit"
            />
    </div>
</x-app-layout>
