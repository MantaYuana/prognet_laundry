<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('customer.order.index') }}" class="btn btn-ghost btn-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Back to Orders
                </a>
            </div>

            @if (session('success'))
                <div class="alert alert-success mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Order Header -->
            <div class="card bg-base-100 shadow-xl mb-6">
                <div class="card-body">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <div>
                            <h2 class="card-title text-3xl">Order {{ $order->code }}</h2>
                            <p class="text-sm opacity-70 mt-1">Placed on {{ $order->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        <div class="flex gap-2">
                            @php
                                $statusColors = [
                                    'ordered' => 'badge-info text-base-100',
                                    'accepted' => 'badge-primary text-base-100',
                                    'being_washed' => 'badge-warning',
                                    'ready_for_pickup' => 'badge-accent text-base-100',
                                    'done' => 'badge-success text-base-100',
                                ];
                            @endphp
                            <span class="badge {{ $statusColors[$order->status] ?? 'badge-ghost' }} badge-lg">
                                {{ ucwords(str_replace('_', ' ', $order->status)) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column - Order Details -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Order Items -->
                    <div class="card bg-base-100 shadow-xl">
                        <div class="card-body">
                            <h3 class="card-title mb-4">Order Items</h3>
                            <div class="overflow-x-auto">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Service</th>
                                            <th>Type</th>
                                            <th class="text-right">Qty</th>
                                            <th class="text-right">Price</th>
                                            <th class="text-right">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->items as $item)
                                            <tr>
                                                <td class="font-medium">{{ $item->laundryService->name }}</td>
                                                <td>
                                                    <span class="badge badge-outline badge-sm">
                                                        {{ ucwords(str_replace('_', ' ', $item->laundryService->service_type)) }}
                                                    </span>
                                                </td>
                                                <td class="text-right">{{ $item->quantity }}</td>
                                                <td class="text-right">Rp {{ number_format($item->item_price, 0, ',', '.') }}</td>
                                                <td class="text-right font-semibold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="font-bold text-lg border-t-2">
                                            <td colspan="4" class="text-right">Total</td>
                                            <td class="text-right text-primary">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Delivery Info -->
                    <div class="card bg-base-100 shadow-xl">
                        <div class="card-body">
                            <h3 class="card-title mb-4">Delivery Information</h3>
                            <div class="space-y-4">
                                <div>
                                    <div class="text-sm opacity-70 mb-1">Outlet</div>
                                    <div class="font-semibold">{{ $order->outlet->name }}</div>
                                    <div class="text-sm flex items-start gap-2 mt-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mt-0.5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                        </svg>
                                        <span>{{ $order->outlet->address }}</span>
                                    </div>
                                </div>
                                
                                <div class="divider"></div>
                                
                                <div>
                                    <div class="text-sm opacity-70 mb-1">Delivery Address</div>
                                    @if ($order->address)
                                        <div class="font-medium">{{ $order->address }}</div>
                                    @else
                                        <div class="badge badge-ghost">Pickup at outlet</div>
                                    @endif
                                </div>

                                @if ($order->staff)
                                    <div class="divider"></div>
                                    <div>
                                        <div class="text-sm opacity-70 mb-1">Handled By</div>
                                        <div class="font-medium">{{ $order->staff->profile->name ?? 'N/A' }}</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Status & Payment -->
                <div class="space-y-6">
                    <!-- Order Status Timeline -->
                    <div class="card bg-base-100 shadow-xl">
                        <div class="card-body">
                            <h3 class="card-title mb-4">Order Status</h3>
                            <ul class="steps steps-vertical w-full">
                                <li class="step {{ in_array($order->status, ['ordered', 'accepted', 'being_washed', 'ready_for_pickup', 'done']) ? 'step-primary' : '' }}">
                                    <div class="text-left">
                                        <div class="font-semibold">Ordered</div>
                                        <div class="text-xs opacity-60">Order placed</div>
                                    </div>
                                </li>
                                <li class="step {{ in_array($order->status, ['accepted', 'being_washed', 'ready_for_pickup', 'done']) ? 'step-primary' : '' }}">
                                    <div class="text-left">
                                        <div class="font-semibold">Accepted</div>
                                        <div class="text-xs opacity-60">Order confirmed</div>
                                    </div>
                                </li>
                                <li class="step {{ in_array($order->status, ['being_washed', 'ready_for_pickup', 'done']) ? 'step-primary' : '' }}">
                                    <div class="text-left">
                                        <div class="font-semibold">Being Washed</div>
                                        <div class="text-xs opacity-60">In progress</div>
                                    </div>
                                </li>
                                <li class="step {{ in_array($order->status, ['ready_for_pickup', 'done']) ? 'step-primary' : '' }}">
                                    <div class="text-left">
                                        <div class="font-semibold">Ready for Pickup</div>
                                        <div class="text-xs opacity-60">Available</div>
                                    </div>
                                </li>
                                <li class="step {{ $order->status === 'done' ? 'step-primary' : '' }}">
                                    <div class="text-left">
                                        <div class="font-semibold">Done</div>
                                        <div class="text-xs opacity-60">Completed</div>
                                    </div>
                                </li>
                            </ul>

                            @if ($order->status === 'done')
                                <div class="alert alert-success mt-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Order completed!</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Payment Status -->
                    <div class="card bg-base-100 shadow-xl">
                        <div class="card-body">
                            <h3 class="card-title mb-4">Payment</h3>
                            
                            <div class="stat bg-base-200 rounded-lg mb-4">
                                <div class="stat-title">Total Amount</div>
                                <div class="stat-value text-primary text-2xl">Rp {{ number_format($order->total, 0, ',', '.') }}</div>
                            </div>

                            @if ($order->payment_status === 'paid' && $order->payment_confirm)
                                <div class="alert alert-success">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Payment Confirmed</span>
                                </div>
                                @if ($order->payment_method)
                                    <div class="mt-2 text-sm opacity-70">
                                        Method: {{ ucfirst($order->payment_method) }}
                                    </div>
                                @endif
                            @elseif ($order->payment_status === 'pending')
                                <div class="alert alert-warning mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    <span>Payment verification in progress</span>
                                </div>
                            @elseif ($order->payment_status === 'rejected')
                                <div class="alert alert-error mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Payment rejected. Please upload again.</span>
                                </div>
                            @else
                                <div class="alert alert-warning mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    <span>Payment not confirmed</span>
                                </div>
                            @endif

                            @if (!$order->payment_confirm || $order->payment_status === 'rejected')
                                <button class="btn btn-primary w-full" onclick="payment_modal.showModal()">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" />
                                        <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd" />
                                    </svg>
                                    Upload Payment Proof
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Upload Modal -->
    <dialog id="payment_modal" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg mb-4">Upload Payment Proof</h3>
            <form action="{{ route('customer.order.payment-proof', $order) }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="form-control w-full mb-4">
                    <label class="label">
                        <span class="label-text">Payment Method</span>
                    </label>
                    <select name="payment_method" class="select select-bordered rounded-field border-base-300 w-full" required>
                        <option value="">Choose payment method</option>
                        <option value="bank_transfer">Bank Transfer</option>
                        <option value="qris">QRIS</option>
                        <option value="cash">Cash</option>
                    </select>
                </div>

                <div class="form-control w-full mb-4">
                    <label class="label">
                        <span class="label-text">Payment Proof (Image/PDF)</span>
                    </label>
                    <input type="file" name="proof" class="file-input file-input-bordered rounded-field border-base-300 w-full" accept="image/*,.pdf" required />
                    <label class="label">
                        <span class="label-text-alt">Max file size: 4MB. Formats: JPG, PNG, PDF</span>
                    </label>
                </div>

                <div class="modal-action">
                    <button type="button" class="btn btn-ghost" onclick="payment_modal.close()">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                        Upload
                    </button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>
</x-app-layout>