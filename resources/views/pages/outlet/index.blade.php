<x-app-layout>
    <div class="px-24 py-8">
        <x-crud-table
            :rows="$outletPaginated"
            :columns="['name', 'address', 'phone_number']"
            title="Outlet"
            createRoute="outlet.create"
            editRoute="outlet.edit"
            deleteRoute="outlet.destroy"
            rowParamKey="outlet"
        />

    </div>
</x-app-layout>
