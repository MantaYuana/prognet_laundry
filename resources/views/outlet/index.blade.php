<x-app-layout>
    <div class="px-24 py-8">
        <livewire:crud-table
            model="Outlet"
            :columns="['nama', 'alamat', 'telp']"
            title="Outlet"
            createRoute="outlet.create"
        />
    </div>
</x-app-layout>
