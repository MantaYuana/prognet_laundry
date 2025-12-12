<div class="bg-surface">

    <!-- TOP BAR -->
    <div class="w-full mt-6 flex flex-row justify-between">

        <!-- SEARCH -->
        <div class="h-16 flex justify-start flex-row items-center">
            <div class="flex justify-start items-center">
                <input 
                    wire:model.debounce.300ms="search"
                    type="text"
                    placeholder="Search..."
                    class="pl-3 outline-none bg-surface border border-r-0 border-line rounded-bl-md rounded-tl-md py-2"
                >
                <button class="px-3 bg-surface py-2 rounded-br-md border border-l-0 border-line rounded-tr-md">
                    <i class="fa-solid fa-search text-slate-950"></i>
                </button>
            </div>

            <p class="ml-3">{{ $title }}</p>
        </div>

        <!-- INSERT BUTTON -->
        <div class="flex items-center justify-center">
            <a href="#" class="w-[150px] text-center bg-primary py-2 px-3 rounded-md hover:opacity-80 font-bold text-white">
                + Insert
            </a>
        </div>

    </div>

    <!-- TABLE -->
    <table class="w-full bg-surface border border-line rounded-t-lg border-separate border-spacing-0 overflow-hidden">

        <tr>
            <th class="border-b border-line px-6 py-4 font-medium bg-odd-row">No</th>

            @foreach($columns as $col)
                <th class="border-b border-line px-6 py-4 font-medium bg-odd-row">
                    {{ ucfirst($col) }}
                </th>
            @endforeach

            <th class="border-b border-line px-6 py-4 font-medium bg-odd-row">Action</th>
        </tr>

        @foreach($rows as $i => $row)
        <tr class="border border-line">
            <td class="text-center py-6 p-3">{{ $rows->firstItem() + $i }}</td>

            @foreach($columns as $col)
                <td class="text-center">{{ $row->$col }}</td>
            @endforeach

            <td class="text-center">
                <button wire:click="edit({{ $row->id }})" class="text-warning underline px-3">Edit</button>
                <button wire:click="delete({{ $row->id }})" class="text-destructive underline px-3">Delete</button>
            </td>
        </tr>
        @endforeach

    </table>

    <!-- PAGINATION -->
    <div class="bg-odd-row border-t-0 rounded-b-lg text-black border border-line flex flex-row justify-between items-center py-3 w-full">
        <p class="ml-5 font-medium">
            Showing {{ $rows->firstItem() }} to {{ $rows->lastItem() }} of {{ $rows->total() }}
        </p>
        <div class="mr-5">
            {{ $rows->links() }}
        </div>
    </div>

</div>
