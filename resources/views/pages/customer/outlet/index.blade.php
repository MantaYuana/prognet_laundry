<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-gray-800 mb-2">Find Laundry Outlets</h2>
                <p class="text-gray-600">Browse available laundry outlets and their services</p>
            </div>

            <!-- Search Bar -->
            <div class="mb-6">
                <form action="{{ route('customer.outlet.index') }}" method="GET" class="flex gap-2">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Search outlets by name, address, or phone..." 
                           class="input input-bordered flex-1">
                    <button type="submit" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                        Search
                    </button>
                    @if(request('search'))
                        <a href="{{ route('customer.outlet.index') }}" class="btn btn-ghost">Clear</a>
                    @endif
                </form>
            </div>

            @if($outlets->isEmpty())
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body text-center py-12">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <h3 class="text-xl font-semibold mb-2">No Outlets Found</h3>
                        <p class="text-gray-600">{{ request('search') ? 'Try adjusting your search terms' : 'No outlets available at the moment' }}</p>
                    </div>
                </div>
            @else
                <!-- Outlets Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                    @foreach($outlets as $outlet)
                        <div class="card bg-base-100 shadow-xl hover:shadow-2xl transition-shadow">
                            <div class="card-body">
                                <h2 class="card-title text-xl mb-2">
                                    {{ $outlet->name }}
                                </h2>
                                
                                <div class="space-y-2 text-sm mb-4">
                                    <div class="flex items-start gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="text-gray-600">{{ $outlet->address }}</span>
                                    </div>
                                    
                                    <div class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                        </svg>
                                        <span class="text-gray-600">{{ $outlet->phone_number }}</span>
                                    </div>

                                    @if($outlet->owner)
                                        <div class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                            </svg>
                                            <span class="text-gray-600">Owner: {{ $outlet->owner->profile->name ?? 'N/A' }}</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="badge badge-primary badge-outline">
                                    {{ $outlet->services->count() }} Services Available
                                </div>

                                <div class="card-actions justify-end mt-4">
                                    <a href="{{ route('customer.outlet.show', $outlet) }}" class="btn btn-primary btn-sm">
                                        View Services & Order
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $outlets->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>