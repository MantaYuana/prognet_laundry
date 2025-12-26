<div>

    {{-- TOP BAR --}}
    <div class="w-full mt-6 flex justify-between items-center">

        {{-- SEARCH --}}
        <form method="GET" class="flex items-center">
            <div class="flex items-center">
                <input name="search" value="{{ request('search') }}" placeholder="Search..."
                    class="pl-3 outline-none border-r-0 bg-surface border border-line rounded-l-md py-2" />

                <button type="submit" class="px-3 bg-surface py-2 rounded-r-md border border-l-0 border-line">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>

            <p class="ml-3 font-medium">{{ $title }}</p>
        </form>

        {{-- INSERT BUTTON --}}
        @if ($createRoute)
            <a href="{{ route($createRoute, $routeParams) }}"
                class="bg-primary py-2 px-3 rounded-md hover:opacity-80 font-bold text-white">
                + Insert
            </a>
        @endif
    </div>

    {{-- TABLE --}}
    <table
        class="w-full mt-4 bg-surface border border-line rounded-t-lg border-separate border-spacing-0 overflow-hidden">

        <thead>
            <tr>
                <th class="border-b border-line px-6 py-4 bg-odd-row text-center w-[5%]">No</th>

                @foreach ($columns as $col)
                    <th class="border-b border-line px-6 py-4 bg-odd-row text-center">
                        {{ ucwords(str_replace('_', ' ', $col)) }}
                    </th>
                @endforeach

                <th class="border-b border-line px-6 py-4 bg-odd-row text-center w-[15%]">
                    Action
                </th>
            </tr>
        </thead>

        <tbody>
            @forelse ($rows as $i => $row)
                <tr class="border-t border-line">

                    <td class="text-center py-4">
                        {{ $rows->firstItem() + $i }}
                    </td>

                    @foreach ($columns as $col)
                        <td class="text-center py-4">
                            {{ $row->$col }}
                        </td>
                    @endforeach

                    <td class="text-center py-4 flex justify-center gap-3">
                        <!-- Services, only for outlet CRUD -->
                        @if ($rowParamKey === 'outlet')
                            <a href="{{ route('outlet.services.index', ['outlet' => $row->id]) }}"
                                class="text-primary underline">
                                Services
                            </a>
                        @endif

                        @php
                            $editParams = $routeParams;

                            if ($rowParamKey) {
                                $editParams[$rowParamKey] = $row->id;
                            }
                        @endphp

                        @if ($editRoute)
                            <a href="{{ route($editRoute, $editParams) }}" class="text-warning underline">
                                Edit
                            </a>
                        @endif

                        <form method="POST" action="{{ route('outlet.destroy', $row) }}"
                            onsubmit="return confirm('Delete this data?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-destructive underline">
                                Delete
                            </button>
                        </form>
                        
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($columns) + 2 }}" class="text-center py-6 text-gray-500 italic">
                        Data not found
                    </td>
                </tr>
            @endforelse
        </tbody>

    </table>

    {{-- PAGINATION --}}
    <div class="bg-odd-row border border-line border-t-0 rounded-b-lg px-4 py-3">
        {{ $rows->links() }}
    </div>

</div>