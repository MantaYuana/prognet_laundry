<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('customer.outlet.index') }}" class="btn btn-ghost btn-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Back to Outlets
                </a>
            </div>

            @if(session('error'))
                <div class="alert alert-error mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- Outlet Information -->
            <div class="card bg-base-100 shadow-xl mb-6">
                <div class="card-body">
                    <h2 class="card-title text-3xl mb-4">{{ $outlet->name }}</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div class="space-y-3">
                            <div class="flex items-start gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                </svg>
                                <div>
                                    <p class="font-semibold">Address</p>
                                    <p class="text-gray-600">{{ $outlet->address }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                </svg>
                                <div>
                                    <p class="font-semibold">Phone</p>
                                    <p class="text-gray-600">{{ $outlet->phone_number }}</p>
                                </div>
                            </div>
                        </div>

                        @if($outlet->owner)
                            <div class="space-y-3">
                                <div class="flex items-start gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                    </svg>
                                    <div>
                                        <p class="font-semibold">Owner</p>
                                        <p class="text-gray-600">{{ $outlet->owner->profile->name ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            @if($promos->count() > 0)
            <div class="mt-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    Available Promos
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($promos as $promo)
                    <div class="border border-pink-200 bg-pink-50 rounded-lg p-4 relative overflow-hidden group hover:shadow-md transition">
                        <div class="absolute -right-4 -top-4 w-16 h-16 bg-pink-100 rounded-full opacity-50"></div>
                        
                        <div class="relative z-10 flex justify-between items-start">
                            <div>
                                <span class="inline-block px-2 py-1 text-xs font-bold text-pink-600 bg-white rounded-md border border-pink-200 mb-2">
                                    {{ $promo->promo_code }}
                                </span>
                                <h4 class="font-bold text-gray-800">{{ $promo->name }}</h4>
                                <p class="text-sm text-gray-600 mt-1">{{ Str::limit($promo->description, 50) }}</p>
                                
                                <div class="mt-2 text-xs text-gray-500 flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Valid until {{ $promo->end_date->format('d M Y') }}
                                </div>
                            </div>

                            <div class="text-right">
                                @if($promo->type == 'percentage')
                                    <div class="text-2xl font-black text-pink-500">{{ $promo->value }}%</div>
                                    <div class="text-xs text-pink-400 font-medium">OFF</div>
                                @else
                                    <div class="text-lg font-black text-pink-500">Rp{{ number_format($promo->value/1000, 0) }}k</div>
                                    <div class="text-xs text-pink-400 font-medium">POTONGAN</div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Services Section -->
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="card-title text-2xl">Available Services</h3>
                        @if($outlet->services->isNotEmpty())
                            <a href="{{ route('customer.order.create', $outlet) }}" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                                </svg>
                                Place Order
                            </a>
                        @endif
                    </div>

                    @if($outlet->services->isEmpty())
                        <div class="text-center py-12">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                            <h4 class="text-xl font-semibold mb-2">No Services Available</h4>
                            <p class="text-gray-600">This outlet hasn't added any services yet.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="table table-zebra">
                                <thead>
                                    <tr>
                                        <th>Service Name</th>
                                        <th>Type</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($outlet->services as $service)
                                        <tr>
                                            <td class="font-semibold">{{ $service->name }}</td>
                                            <td>
                                                <span class="badge badge-secondary">{{ ucfirst(str_replace('_', ' ', $service->service_type)) }}</span>
                                            </td>
                                            <td class="text-primary font-semibold">Rp {{ number_format($service->price, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>