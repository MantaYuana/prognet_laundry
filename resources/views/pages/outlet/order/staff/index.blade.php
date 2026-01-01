@php $isStaff = auth()->user()?->hasRole('staff'); @endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Order Management') }}
            </h2>
            {{-- <a href="{{ route('outlet.staff.order.create', ['outlet' => request()->route('outlet')]) }}" 
               class="btn btn-primary btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Create Order
            </a> --}}
            <a href="{{ $isStaff ? route('staff.orders.create') : route('outlet.staff.order.create', ['outlet' => request()->route('outlet'), 'staff' => request()->route('staff')]) }}" 
               class="btn btn-primary btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Create Order
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="alert alert-success mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <!-- Filters -->
                    <div class="flex flex-col md:flex-row gap-4 mb-6">
                        <div class="form-control flex-1">
                            <input type="text" placeholder="Search by order code..." class="input input-bordered w-full" id="searchInput" />
                        </div>
                        <div class="form-control">
                            <select class="select select-bordered" id="statusFilter">
                                <option value="">All Statuses</option>
                                <option value="ordered">Ordered</option>
                                <option value="accepted">Accepted</option>
                                <option value="being_washed">Being Washed</option>
                                <option value="ready_for_pickup">Ready for Pickup</option>
                                <option value="done">Done</option>
                            </select>
                        </div>
                        <div class="form-control">
                            <select class="select select-bordered" id="paymentFilter">
                                <option value="">All Payments</option>
                                <option value="paid">Paid</option>
                                <option value="unpaid">Unpaid</option>
                            </select>
                        </div>
                    </div>

                    <!-- Orders Table -->
                    <div class="overflow-x-auto">
                        <table class="table table-zebra w-full">
                            <thead>
                                <tr>
                                    <th>Order Code</th>
                                    <th>Customer</th>
                                    <th>Status</th>
                                    <th>Payment</th>
                                    <th>Total</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($orders as $order)
                                    <tr>
                                        <td>
                                            <div class="font-bold">{{ $order->code }}</div>
                                        </td>
                                        <td>
                                            @if ($order->customer)
                                                <div class="font-medium">{{ $order->customer->profile->name ?? 'N/A' }}</div>
                                                <div class="text-sm opacity-50">{{ $order->customer->phone_number }}</div>
                                            @else
                                                <span class="badge badge-ghost">Walk-in</span>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $statusColors = [
                                                    'ordered' => 'badge-info',
                                                    'accepted' => 'badge-primary',
                                                    'being_washed' => 'badge-warning',
                                                    'ready_for_pickup' => 'badge-accent',
                                                    'done' => 'badge-success',
                                                ];
                                            @endphp
                                            <span class="badge {{ $statusColors[$order->status] ?? 'badge-ghost' }}">
                                                {{ ucwords(str_replace('_', ' ', $order->status)) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if ($order->payment_confirm)
                                                <span class="badge badge-success gap-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-4 h-4 stroke-current">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    Paid
                                                </span>
                                            @else
                                                <span class="badge badge-error gap-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-4 h-4 stroke-current">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                    Unpaid
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="font-bold text-primary">
                                                Rp {{ number_format($order->total, 0, ',', '.') }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-sm">{{ $order->created_at->format('d M Y') }}</div>
                                            <div class="text-xs opacity-50">{{ $order->created_at->format('H:i') }}</div>
                                        </td>
                                        <td>
                                            <div class="flex gap-2">
                                                <a href="{{ $isStaff ? route('staff.orders.show', ['order' => $order]) : route('outlet.staff.order.show', ['outlet' => request()->route('outlet'), 'staff' => request()->route('staff'), 'order' => $order]) }}" 
                                                   class="btn btn-ghost btn-xs">
                                                    View
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-8">
                                            <div class="text-gray-400">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto mb-4 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                                </svg>
                                                <p class="text-lg font-semibold">No orders found</p>
                                                <p class="text-sm">Create your first order to get started</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>