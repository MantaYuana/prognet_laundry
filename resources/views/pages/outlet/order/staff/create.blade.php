@php $isStaff = auth()->user()?->hasRole('staff'); @endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create New Order') }}
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
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if ($errors->any())
                <div class="alert alert-error mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <h3 class="font-bold">Error!</h3>
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form action="{{ $isStaff ? route('staff.orders.store') : route('outlet.staff.order.store', ['outlet' => request()->route('outlet'), 'staff' => request()->route('staff')]) }}" 
                  method="POST" 
                  id="orderForm">
                @csrf

                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body">
                        <h3 class="card-title mb-4">Order Details</h3>

                        <!-- Customer Selection -->
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">Customer <span class="text-xs opacity-60">(Optional - Leave empty for walk-in)</span></span>
                            </label>
                            <select name="customer_id" class="select select-bordered rounded-field border-base-300 w-full" id="customerSelect">
                                <option value="">Walk-in Customer</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}" 
                                            data-phone="{{ $customer->phone_number }}"
                                            data-address="{{ $customer->address }}"
                                            {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->profile->name ?? 'N/A' }} - {{ $customer->phone_number }}
                                    </option>
                                @endforeach
                            </select>
                            @error('customer_id')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <!-- Delivery Address -->
                        <div class="form-control flex flex-col w-full mb-4">
                            <label class="label">
                                <span class="label-text">Delivery Address <span class="text-xs opacity-60">(Optional - Leave empty for pickup)</span></span>
                            </label>
                            <textarea name="address" 
                                      class="textarea textarea-bordered rounded-field border-base-300 w-full h-24" 
                                      placeholder="Enter delivery address or leave empty for pickup at outlet"
                                      id="addressInput">{{ old('address') }}</textarea>
                            @error('address')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <div class="divider"></div>

                        <!-- Order Items -->
                        <div class="">
                            <div class="mb-4 flex flex-row justify-between w-full">
                                <h3 class="card-title ">Order Items</h3>
                                <button type="button" class="btn btn-sm bg-primary px-4 text-base-100 transition-all duration-300 hover:opacity-85" id="addItemBtn">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                    </svg>
                                    Add Item
                                </button>
                            </div>

                            <div id="orderItemsContainer">
                                <!-- Order items will be added dynamically -->
                            </div>

                            @error('items')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <div class="divider"></div>
                        
                        <h3 class="card-title">Order Summary</h3>

                        <!-- Order Summary -->
                        <div class="bg-base-200 rounded-lg p-4">
                            <div class="space-y-2" id="summaryContainer">
                                <div class="text-center text-gray-500 py-4">
                                    Add items to see summary
                                </div>
                            </div>
                            <div class="divider"></div>
                            <div class="flex justify-between items-center text-xl font-bold">
                                <span>Total</span>
                                <span class="text-primary" id="totalAmount">Rp 0</span>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="card-actions flex items-center gap-4 justify-end mt-6">
                            <button type="button" 
                                    onclick="window.location='{{ $isStaff ? route('staff.orders.index') : route('outlet.staff.order.index', ['outlet' => request()->route('outlet'), 'staff' => request()->route('staff')]) }}'" 
                                    class="btn btn-ghost">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-sm bg-primary px-4 text-base-100 transition-all duration-300 hover:opacity-85">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                Create Order
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        const services = @json($services);
        let itemCount = 0;

        // Auto-fill address when customer is selected
        document.getElementById('customerSelect').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const address = selectedOption.getAttribute('data-address');
            if (address && address !== 'null') {
                document.getElementById('addressInput').value = address;
            }
        });

        function addOrderItem() {
            itemCount++;
            const container = document.getElementById('orderItemsContainer');
            
            // TODO: make service_type so that it is a clean string, currently its just getting raw data from DB
            // NOTE: yeah ig we need to modify the whole frickin model, instead of just string we gonna use enums ig
            const itemHtml = `
                <div class="card bg-base-200 shadow-sm mb-4 order-item" data-item-id="${itemCount}">
                    <div class="card-body p-4">
                        <div class="flex justify-between items-start mb-3">
                            <h4 class="font-semibold">Item #${itemCount}</h4>
                            <button type="button" class="btn btn-ghost btn-xs btn-circle remove-item-btn" data-item-id="${itemCount}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text">Service</span>
                                </label>
                                <select name="items[${itemCount}][laundry_service_id]" 
                                        class="select select-bordered rounded-field border-base-300 w-full service-select" 
                                        data-item-id="${itemCount}"
                                        required>
                                    <option value="">Select Service</option>
                                    ${services.map(service => `
                                        <option value="${service.id}" data-price="${service.price}">
                                            ${service.name} - ${service.service_type} (Rp ${formatNumber(service.price)})
                                        </option>
                                    `).join('')}
                                </select>
                            </div>
                            
                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text">Quantity</span>
                                </label>
                                <input type="number" 
                                       name="items[${itemCount}][quantity]" 
                                       class="input input-bordered rounded-field border-base-300 w-full quantity-input" 
                                       data-item-id="${itemCount}"
                                       placeholder="Enter quantity" 
                                       min="1" 
                                       value="1"
                                       required>
                            </div>
                        </div>
                        
                        <div class="mt-3 flex justify-between items-center">
                            <span class="text-sm opacity-70">Subtotal:</span>
                            <span class="font-bold text-lg subtotal-display" data-item-id="${itemCount}">Rp 0</span>
                        </div>
                    </div>
                </div>
            `;
            
            container.insertAdjacentHTML('beforeend', itemHtml);
            
            // Attach event listeners to new elements
            const newItem = container.querySelector(`[data-item-id="${itemCount}"]`);
            newItem.querySelector('.service-select').addEventListener('change', updateSummary);
            newItem.querySelector('.quantity-input').addEventListener('input', updateSummary);
            newItem.querySelector('.remove-item-btn').addEventListener('click', function() {
                removeOrderItem(this.getAttribute('data-item-id'));
            });
            
            updateSummary();
        }

        function removeOrderItem(itemId) {
            const item = document.querySelector(`.order-item[data-item-id="${itemId}"]`);
            if (item) {
                item.remove();
                updateSummary();
            }
        }

        function updateSummary() {
            const items = document.querySelectorAll('.order-item');
            const summaryContainer = document.getElementById('summaryContainer');
            let total = 0;
            let summaryHtml = '';

            if (items.length === 0) {
                summaryContainer.innerHTML = '<div class="text-center text-gray-500 py-4">Add items to see summary</div>';
                document.getElementById('totalAmount').textContent = 'Rp 0';
                return;
            }

            items.forEach((item, index) => {
                const itemId = item.getAttribute('data-item-id');
                const serviceSelect = item.querySelector('.service-select');
                const quantityInput = item.querySelector('.quantity-input');
                const subtotalDisplay = item.querySelector('.subtotal-display');

                if (serviceSelect.value && quantityInput.value) {
                    const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
                    const price = parseFloat(selectedOption.getAttribute('data-price')) || 0;
                    const quantity = parseInt(quantityInput.value) || 0;
                    const subtotal = price * quantity;
                    total += subtotal;

                    // Update individual subtotal
                    subtotalDisplay.textContent = `Rp ${formatNumber(subtotal)}`;

                    summaryHtml += `
                        <div class="flex justify-between items-center py-2 border-b border-base-300">
                            <div>
                                <div class="font-medium">${selectedOption.text.split(' - ')[0]}</div>
                                <div class="text-xs opacity-60">${quantity} x Rp ${formatNumber(price)}</div>
                            </div>
                            <div class="font-semibold">Rp ${formatNumber(subtotal)}</div>
                        </div>
                    `;
                } else {
                    subtotalDisplay.textContent = 'Rp 0';
                }
            });

            summaryContainer.innerHTML = summaryHtml || '<div class="text-center text-gray-500 py-4">Complete item details to see summary</div>';
            document.getElementById('totalAmount').textContent = `Rp ${formatNumber(total)}`;
        }

        function formatNumber(num) {
            return new Intl.NumberFormat('id-ID').format(num);
        }

        // Add first item on page load
        document.addEventListener('DOMContentLoaded', function() {
            addOrderItem();
            document.getElementById('addItemBtn').addEventListener('click', addOrderItem);
        });

        // Form validation before submit
        document.getElementById('orderForm').addEventListener('submit', function(e) {
            const items = document.querySelectorAll('.order-item');
            if (items.length === 0) {
                e.preventDefault();
                alert('Please add at least one item to the order');
                return false;
            }

            let hasValidItem = false;
            items.forEach(item => {
                const serviceSelect = item.querySelector('.service-select');
                const quantityInput = item.querySelector('.quantity-input');
                if (serviceSelect.value && quantityInput.value > 0) {
                    hasValidItem = true;
                }
            });

            if (!hasValidItem) {
                e.preventDefault();
                alert('Please complete at least one item with service and quantity');
                return false;
            }
        });
    </script>
</x-app-layout>