@php $isCustomer = auth()->user()?->hasRole('customer'); @endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h2 class="text-xl font-semibold">
                {{ __('Order Management') }}
            </h2>

            
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="alert alert-success mb-4">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">

                    <!-- Filters -->
                    <div class="grid grid-cols-1 md:grid-cols-4 md:w-full gap-4 mb-6">
                        <input
                            type="text"
                            placeholder="Search by order code..."
                            class="input input-bordered rounded-field border-base-300"
                            id="searchInput"
                        />

                        <select class="select select-bordered  border-base-300 rounded-field" id="statusFilter">
                            <option value="">All Statuses</option>
                            <option value="ordered">Ordered</option>
                            <option value="accepted">Accepted</option>
                            <option value="being_washed">Being Washed</option>
                            <option value="ready_for_pickup">Ready for Pickup</option>
                            <option value="done">Done</option>
                        </select>

                        <select class="select select-bordered  border-base-300 rounded-field" id="paymentFilter">
                            <option value="">All Payments</option>
                            <option value="paid">Paid</option>
                            <option value="unpaid">Unpaid</option>
                        </select>

                        <div class="w-full text-right">
                        <a
                            href=""
                            class="btn btn-primary text-base-100"
                        >
                            <i class="fa-solid fa-plus"></i>
                            Create Order
                        </a>
                        </div>
                    </div>

                    <!-- Orders Table -->
                    <div class="overflow-x-auto">
                        <table class="table table-zebra w-full">
                            <thead>
                                <tr>
                                    <th>Order Code</th>
                                    <!-- <th>Customer</th> -->
                                    <th>Status</th>
                                    <th>Payment</th>
                                    <th>Total</th>
                                    <th>Date</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($orders as $order)
                                    <tr>
                                        <td class="font-bold">{{ $order->code }}</td>

                                        <td>
                                            @if ($order->customer)
                                                <div class="font-medium">{{ $order->customer->profile->name ?? 'N/A' }}</div>
                                                <div class="text-sm opacity-60">{{ $order->customer->phone_number }}</div>
                                            @else
                                                <span class="badge badge-ghost">Walk-in</span>
                                            @endif
                                        </td>

                                        <td>
                                            @php
                                                $statusColors = [
                                                    'ordered' => 'badge-info text-base-100',
                                                    'accepted' => 'badge-primary text-base-100',
                                                    'being_washed' => 'badge-warning',
                                                    'ready_for_pickup' => 'badge-accent text-base-100',
                                                    'done' => 'badge-success text-base-100',
                                                ];
                                            @endphp
                                            <span class="badge {{ $statusColors[$order->status] ?? 'badge-ghost' }}">
                                                {{ ucwords(str_replace('_', ' ', $order->status)) }}
                                            </span>
                                        </td>

                                        <td>
                                            @if ($order->payment_confirm)
                                                <span class="badge badge-success badge-soft gap-2">
                                                    <i class="fa-solid fa-circle-check"></i>
                                                    Paid
                                                </span>
                                            @else
                                                <span class="badge badge-error badge-soft gap-2">
                                                    <i class="fa-solid fa-circle-xmark"></i>
                                                    Unpaid
                                                </span>
                                            @endif
                                        </td>

                                        <td class="font-bold text-primary">
                                            Rp {{ number_format($order->total, 0, ',', '.') }}
                                        </td>

                                        <td>
                                            <div class="text-sm">{{ $order->created_at->format('d M Y') }}</div>
                                            <div class="text-xs opacity-60">{{ $order->created_at->format('H:i') }}</div>
                                        </td>

                                        <td class="text-center">
                                            <a
                                                href="{{ $isCustomer
                                                    ? route('customer.orders.show', ['order' => $order])
                                                    : route('outlet.customer.order.show', [
                                                        'outlet' => request()->route('outlet'),
                                                        'customer'  => request()->route('customer'),
                                                        'order'  => $order,
                                                    ]) }}"
                                                class="btn btn-square btn-ghost btn-md"
                                                title="View"
                                            >
                                                <i class="fa-solid fa-eye text-primary"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7">
                                            <div class="py-10 text-center text-base-content/60">
                                                <i class="fa-solid fa-box-open text-4xl mb-3"></i>
                                                <div class="text-lg font-semibold">No orders found</div>
                                                <div class="text-sm">Create your first order to get started</div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div
        class="card-footer flex flex-col md:flex-row items-center justify-between gap-3 py-4">
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
            <span class="font-semibold">{{ $orders->firstItem() }}</span>
            <span>to</span>
            <span class="font-semibold">{{ $orders->lastItem() }}</span>
            <span>of</span>
            <span class="font-semibold">{{ $orders->total() }}</span>
        </div>

        {{-- PAGINATION BUTTONS --}}
        <div class="join">
            {{ $orders->links() }}
        </div>
    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
