<div class="">

    {{-- TOP BAR --}}
    <div class="w-full mt-6 flex flex-row justify-between">

        {{-- SEARCH --}}
        <div class="h-16 flex justify-start flex-row items-center">
            <div class="flex justify-start items-center">
                <input wire:model.debounce.300ms="search" type="text" placeholder="Search..."
                    class="pl-3 outline-none bg-surface border border-r-0 border-line rounded-bl-md rounded-tl-md py-2">

                <button class="px-3 bg-surface py-2 rounded-br-md border border-l-0 border-line rounded-tr-md">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>

            <p class="ml-3 font-medium">{{ $title }}</p>
        </div>

        {{-- INSERT BUTTON --}}
        <div class="flex items-center justify-center">
            @if($createRoute)
                <a href="{{ route($createRoute) }}"
                    class="w-37.5 text-center bg-primary py-2 px-3 rounded-md hover:opacity-80 font-bold text-white">
                    + Insert
                </a>
            @endif
        </div>

    </div>

    {{-- TABLE --}}
    <table class="w-full bg-surface border border-line rounded-t-lg border-separate border-spacing-0 overflow-hidden">

        {{-- <tr>
            <th class="border-b border-line px-6 w-[5%] py-4 font-medium bg-odd-row">No</th>
            <th class="border-b border-line px-6 w-[20%] py-4 font-medium bg-odd-row">Nama Outlet</th>
            <th class="border-b border-line px-12 w-[25%] py-4 font-medium bg-odd-row">Alamat</th>
            <th class="border-b border-line px-12 w-[15%] py-4 font-medium bg-odd-row">Telp</th>
            <th class="border-b border-line w-[15%] font-medium bg-odd-row">Action</th>
        </tr> --}}
        <tr>
            {{-- NO --}}
            <th class="border-b border-line px-6 py-4 font-medium bg-odd-row text-center w-[5%]">
                No
            </th>

            {{-- DYNAMIC COLUMNS --}}
            @foreach($columns as $col)
                <th class="border-b border-line px-6 py-4 font-medium bg-odd-row text-center">
                    {{ ucfirst($col) }}
                </th>
            @endforeach

            {{-- ACTION --}}
            <th class="border-b border-line px-6 py-4 font-medium bg-odd-row text-center w-[15%]">
                Action
            </th>
        </tr>

        @foreach($rows as $i => $row)
            <tr class="border border-line">

                {{-- NO --}}
                <td class="text-center py-6 p-3">
                    {{ $rows->firstItem() + $i }}
                </td>

                {{-- DYNAMIC COLUMNS --}}
                @foreach($columns as $col)
                    <td class="text-center">
                        {{ $row->$col }}
                    </td>
                @endforeach

                {{-- ACTION --}}
                <td class="text-center">
                    <button wire:click="edit({{ $row->id }})"
                        class="text-warning cursor-pointer hover:opacity-80 transition-all px-3 underline rounded-md">
                        Edit
                    </button>

                    <button wire:click="delete({{ $row->id }})"
                        class="text-destructive cursor-pointer hover:opacity-80 transition-all px-3 underline rounded-md">
                        Delete
                    </button>
                </td>

            </tr>
        @endforeach


        {{-- @foreach($rows as $i => $row)
        <tr class="border border-line">
            <td class="text-center py-6 p-3">{{ $rows->firstItem() + $i }}</td>
            <td class="text-center">{{ $row->nama }}</td>
            <td class="text-center">{{ $row->alamat }}</td>
            <td class="text-center">{{ $row->telp }}</td>
            <td class="text-center">
                <button wire:click="edit({{ $row->id }})"
                    class="text-warning cursor-pointer hover:opacity-80 transition-all px-3 underline rounded-md">Edit</button>
                <button wire:click="delete({{ $row->id }})"
                    class="text-destructive cursor-pointer hover:opacity-80 transition-all px-3 underline rounded-md">Delete</button>
            </td>
        </tr>
        @endforeach --}}
    </table>

    {{-- PAGINATION --}}
    <div
        class="bg-odd-row border-t-0 rounded-b-lg text-black border border-line flex flex-row justify-between items-center py-3 w-full">

        {{-- PAGE INDICATOR --}}
        <p class="ml-5 font-medium">
            Page {{ $rows->currentPage() }} of {{ $rows->lastPage() }}
        </p>

        {{-- CONTROLS --}}
        <div class="mr-5 flex items-center">

            {{-- Previous Button --}}
            @if ($rows->onFirstPage())
                <button class="border mr-3 cursor-not-allowed opacity-40 bg-surface rounded-md border-line px-3 py-2">
                    <i class="fa-solid fa-arrow-left"></i>
                </button>
            @else
                <button wire:click="previousPage"
                    class="border mr-3 hover:text-primary hover:opacity-90 cursor-pointer transition-all duration-300 bg-surface rounded-md border-line px-3 py-2">
                    <i class="fa-solid fa-arrow-left"></i>
                </button>
            @endif

            {{-- Next Button --}}
            @if ($rows->hasMorePages())
                <button wire:click="nextPage"
                    class="border mr-3 hover:text-primary hover:opacity-90 cursor-pointer transition-all duration-300 bg-surface rounded-md border-line px-3 py-2">
                    <i class="fa-solid fa-arrow-right"></i>
                </button>
            @else
                <button class="border mr-3 cursor-not-allowed opacity-40 bg-surface rounded-md border-line px-3 py-2">
                    <i class="fa-solid fa-arrow-right"></i>
                </button>
            @endif

        </div>

    </div>


</div>