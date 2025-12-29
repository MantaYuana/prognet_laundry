<div class="card border border-line mt-6 overflow-hidden" datatheme="mytheme">
    {{-- HEADER --}}
    <div class="card-body py-0 bg-base-200 border-b flex flex-col md:flex-row justify-between items-center">

        {{-- SEARCH BAR --}}
        <form method="GET" class="flex items-center py-4 mt-3 md:mt-0">
            <input name="search" value="{{ request('search') }}" placeholder="Search..."
                class="input input-bordered border-base-300 rounded-field w-48 sm:w-48" />
            <button type="submit" class="hidden">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
            <p class="ml-3 font-medium">{{ $title }}</p>
        </form>

        {{-- INSERT BUTTON --}}
        @if ($createRoute)
            <a href="{{ route($createRoute, $routeParams) }}" class="btn btn-primary text-base-100">
                + Insert
            </a>
        @endif
    </div>

    {{-- TABLE --}}
    <div class="overflow-x-auto ">
        <table class="table w-full bg-base-100">
            <thead>
                <tr class="text-base font-semibold">
                    <th class="text-center py-4 w-[5%]">No</th>
                    @foreach ($columns as $col)
                        <th class="text-center">{{ ucwords(str_replace('_', ' ', $col)) }}</th>
                    @endforeach
                    <th class="text-center w-[15%]">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($rows as $i => $row)
                    <tr>
                        <td class="text-center py-4">{{ $rows->firstItem() + $i }}</td>

                        @foreach ($columns as $col)
                            <td class="text-center">{{ $row->$col }}</td>
                        @endforeach

                        <td class="text-center">
                            <div class="flex justify-center gap-2">
                                @if ($rowParamKey === 'outlet')
                                    <a href="{{ route('outlet.services.index', ['outlet' => $row->id]) }}"
                                        class="btn btn-square btn-info" title="Services">
                                        <i class="fa-solid fa-list text-base-100"></i>
                                    </a>
                                @endif

                                @php
                                    $editParams = $routeParams;
                                    $deleteParams = $routeParams;
                                    if ($rowParamKey) {
                                        $editParams[$rowParamKey] = $row;
                                        $deleteParams[$rowParamKey] = $row;
                                    }
                                @endphp

                                @if ($editRoute)
                                    <a href="{{ route($editRoute, $editParams) }}" class="btn btn-square btn-warning"
                                        title="Edit">
                                        <i class="fa-solid fa-pen-to-square text-base-100"></i>
                                    </a>
                                @endif

                                <form method="POST" action="{{ route($deleteRoute, $deleteParams) }}"
                                    onsubmit="return confirm('Delete this data?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-square bg-error" title="Delete">
                                        <i class="fa-solid fa-trash text-base-100"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ count($columns) + 2 }}" class="text-center italic opacity-70 py-6">
                            Data not found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINATION FOOTER --}}
    <div
        class="card-footer bg-base-200 border-t flex flex-col md:flex-row items-center justify-between gap-3 px-6 py-4">
        <div class="flex items-center gap-2">
            <span class="text-sm opacity-70">Items per page</span>
            <select class="select select-bordered select-md rounded-box w-fit cursor-pointer border-base-300">
                <option>5</option>
                <option>10</option>
                <option>25</option>
            </select>
        </div>

        <div class="text-sm opacity-70 ">
            Showing
            <span class="font-semibold">{{ $rows->firstItem() }}</span>
            <span>to</span>
            <span class="font-semibold">{{ $rows->lastItem() }}</span>
            <span>of</span>
            <span class="font-semibold">{{ $rows->total() }}</span>
        </div>

        {{-- PAGINATION BUTTONS --}}
        <div class="join">
            {{ $rows->links() }}
        </div>
    </div>
</div>