<x-app-layout>
    <div class="px-24">
        <livewire:crud-table 
            model="Outlet"
            title="Outlet"
            :columns="['nama', 'alamat', 'telp']"
        />
    </div>
</x-app-layout>
