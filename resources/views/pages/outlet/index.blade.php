<x-app-layout>
    <div class="px-24 py-8">

        <x-crud-table
            :rows="$rows"
            :columns="['name', 'address', 'phone_number']"
            title="Outlet"
            createRoute="outlet.create"
            editRoute="outlet.edit"
        />

    </div>
</x-app-layout>
