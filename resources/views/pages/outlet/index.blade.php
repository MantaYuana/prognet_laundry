<x-app-layout>
    <div class="px-24 py-8">
            <livewire:crud-table
                model="\App\Models\Outlet"
                :rows="$usersPaginated"
                :columns="['name', 'address', 'phone_number']"
                title="Outlet"
                createRoute="outlet.create"
                editRoute="outlet.edit"
                serviceRoute="outlet.service.index"
            />
    </div>
</x-app-layout>
