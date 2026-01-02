@php $isStaff = auth()->user()?->hasRole('staff'); @endphp
{{-- NOTE: fuckk i just realized how stupid owner route name was, but im balls deep, no turning back now shit --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Order Details') }} - {{ $order->code }}
            </h2>
            <a href="{{ $isStaff ? route('staff.orders.index') : route('outlet.staff.order.index', ['outlet' => request()->route('outlet'), 'staff' => request()->route('staff')]) }}" 
               class="btn btn-ghost btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back to Orders
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

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Order Information -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Order Details Card -->
                    <div class="card bg-base-100 shadow-xl">
                        <div class="card-body">
                            <h3 class="card-title">Order Information</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <div class="text-sm opacity-70">Order Code</div>
                                    <div class="font-bold">{{ $order->code }}</div>
                                </div>
                                <div>
                                    <div class="text-sm opacity-70">Created At</div>
                                    <div class="font-medium">{{ $order->created_at->format('d M Y, H:i') }}</div>
                                </div>
                                <div>
                                    <div class="text-sm opacity-70">Customer</div>
                                    @if ($order->customer)
                                        <div class="font-medium">{{ $order->customer->profile->name ?? 'N/A' }}</div>
                                        <div class="text-sm opacity-70">{{ $order->customer->phone_number }}</div>
                                    @else
                                        <span class="badge badge-ghost">Walk-in Customer</span>
                                    @endif
                                </div>
                                <div>
                                    <div class="text-sm opacity-70">Delivery Address</div>
                                    <div class="font-medium">{{ $order->address ?: 'Pickup at outlet' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items Card -->
                    <div class="card bg-base-100 shadow-xl">
                        <div class="card-body">
                            <h3 class="card-title">Order Items</h3>
                            <div class="overflow-x-auto">
                                <table class="table w-full">
                                    <thead>
                                        <tr>
                                            <th>Service</th>
                                            <th>Type</th>
                                            <th class="text-right">Quantity</th>
                                            <th class="text-right">Unit Price</th>
                                            <th class="text-right">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->items as $item)
                                            <tr>
                                                <td class="font-medium">{{ $item->laundryService->name }}</td>
                                                <td>
                                                    <span class="badge badge-outline">
                                                        {{ ucwords(str_replace('_', ' ', $item->laundryService->service_type)) }}
                                                    </span>
                                                </td>
                                                <td class="text-right">{{ $item->quantity }}</td>
                                                <td class="text-right">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                                                <td class="text-right font-bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="font-bold text-lg">
                                            <td colspan="4" class="text-right">Total</td>
                                            <td class="text-right text-primary">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status and Actions Sidebar -->
                <div class="space-y-6">
                    <!-- Status Card -->
                    <div class="card bg-base-100 shadow-xl">
                        <div class="card-body">
                            <h3 class="card-title">Status</h3>
                            
                            @php
                                $statusColors = [
                                    'ordered' => 'badge-info',
                                    'accepted' => 'badge-primary',
                                    'being_washed' => 'badge-warning',
                                    'ready_for_pickup' => 'badge-accent',
                                    'done' => 'badge-success',
                                ];
                            @endphp
                            
                            <div class="space-y-4">
                                <div class="flex items-center justify-center">
                                    <span class="badge {{ $statusColors[$order->status] ?? 'badge-ghost' }} badge-lg">
                                        {{ ucwords(str_replace('_', ' ', $order->status)) }}
                                    </span>
                                </div>

                                <!-- Status Timeline -->
                                <ul class="steps steps-vertical">
                                    <li class="step {{ in_array($order->status, ['ordered', 'accepted', 'being_washed', 'ready_for_pickup', 'done']) ? 'step-primary' : '' }}">Ordered</li>
                                    <li class="step {{ in_array($order->status, ['accepted', 'being_washed', 'ready_for_pickup', 'done']) ? 'step-primary' : '' }}">Accepted</li>
                                    <li class="step {{ in_array($order->status, ['being_washed', 'ready_for_pickup', 'done']) ? 'step-primary' : '' }}">Being Washed</li>
                                    <li class="step {{ in_array($order->status, ['ready_for_pickup', 'done']) ? 'step-primary' : '' }}">Ready for Pickup</li>
                                    <li class="step {{ $order->status === 'done' ? 'step-primary' : '' }}">Done</li>
                                </ul>

                                <!-- Update Status Buttons -->
                                <div class="divider">Update Status</div>
                                
                                @if ($order->status !== 'done')
                                    <div class="flex flex-col gap-2">
                                        @if ($order->status === 'ordered')
                                            <form action="{{ $isStaff ? route('staff.orders.show', $order) : route('outlet.staff.order.show', ['outlet' => request()->route('outlet'), 'order' => $order]) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="accepted">
                                                <button type="submit" class="btn btn-primary btn-sm w-full">Accept Order</button>
                                            </form>
                                        @endif
                                        
                                        @if ($order->status === 'accepted')
                                            <form action="{{ $isStaff ? route('staff.orders.show', $order) : route('outlet.staff.order.show', ['outlet' => request()->route('outlet'), 'order' => $order]) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="being_washed">
                                                <button type="submit" class="btn btn-warning btn-sm w-full">Start Washing</button>
                                            </form>
                                        @endif
                                        
                                        @if ($order->status === 'being_washed')
                                            <form action="{{ $isStaff ? route('staff.orders.show', $order) : route('outlet.staff.order.show', ['outlet' => request()->route('outlet'), 'order' => $order]) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="ready_for_pickup">
                                                <button type="submit" class="btn btn-accent btn-sm w-full">Ready for Pickup</button>
                                            </form>
                                        @endif
                                        
                                        @if ($order->status === 'ready_for_pickup')
                                            <form action="{{ $isStaff ? route('staff.orders.show', $order) : route('outlet.staff.order.show', ['outlet' => request()->route('outlet'), 'order' => $order]) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="done">
                                                <button type="submit" class="btn btn-success btn-sm w-full">Complete Order</button>
                                            </form>
                                        @endif
                                    </div>
                                @else
                                    <div class="alert alert-success">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>Order completed!</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Payment Status Card -->
                    <div class="card bg-base-100 shadow-xl">
                        <div class="card-body">
                            <h3 class="card-title">Payment</h3>
                            
                            <div class="flex flex-col items-center gap-4">
                                @if ($order->payment_confirm)
                                    <div class="alert alert-success">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>Payment Confirmed</span>
                                    </div>
                                @else
                                    <div class="alert alert-warning">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                        <span>Payment Pending</span>
                                    </div>
                                @endif
                                
                                <div class="stat bg-base-200 rounded-lg">
                                    <div class="stat-title">Total Amount</div>
                                    <div class="stat-value text-primary">Rp {{ number_format($order->total, 0, ',', '.') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>