<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('customer.outlet.show', $outlet) }}" class="btn btn-ghost btn-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Back to Outlet
                </a>
            </div>

            @if ($errors->any())
                <div class="alert alert-error mb-6">
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

            <!-- Outlet Info Header -->
            <div class="card bg-base-100 shadow-xl mb-6">
                <div class="card-body">
                    <h2 class="card-title text-2xl">{{ $outlet->name }}</h2>
                    <div class="flex items-center gap-2 text-sm opacity-70">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                        </svg>
                        {{ $outlet->address }}
                    </div>
                </div>
            </div>

            <form action="{{ route('customer.order.store', $outlet) }}" 
                  method="POST" 
                  id="orderForm">
                @csrf

                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body">
                        <h3 class="card-title mb-4">Create Your Order</h3>

                        <!-- Delivery Address -->
                        <div class="form-control w-full mb-4">
                            <label class="label">
                                <span class="label-text">Delivery Address <span class="text-xs opacity-60">(Optional - Leave empty for pickup at outlet)</span></span>
                            </label>
                            <textarea name="address" 
                                      class="textarea textarea-bordered rounded-field border-base-300 w-full h-24" 
                                      placeholder="Enter delivery address or leave empty to pickup at outlet"
                                      id="addressInput">{{ old('address') }}</textarea>
                            <label class="label">
                                <span class="label-text-alt opacity-60">If left empty, your registered address will be used</span>
                            </label>
                            @error('address')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <div class="divider"></div>

                        <!-- Order Items -->
                        <div class="mb-4">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="card-title">Select Services</h3>
                                <button type="button" class="btn btn-sm bg-primary px-4 text-base-100 transition-all duration-300 hover:opacity-85" id="addItemBtn">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                    </svg>
                                    Add Service
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

                        <!-- Promo Code Section -->
                        <div class="mb-4">
                            <h3 class="card-title mb-4">Apply Promo Code</h3>
                            <div class="flex gap-2">
                                <div class="form-control flex-1">
                                    <input type="text" 
                                           name="promo_code" 
                                           id="promoCodeInput"
                                           class="input input-bordered rounded-field border-base-300 w-full" 
                                           placeholder="Enter promo code"
                                           value="{{ old('promo_code') }}">
                                </div>
                                <button type="button" 
                                        id="applyPromoBtn"
                                        class="btn btn-outline btn-primary">
                                    Apply
                                </button>
                                <button type="button" 
                                        id="removePromoBtn"
                                        class="btn btn-outline btn-error hidden">
                                    Remove
                                </button>
                            </div>
                            <div id="promoMessage" class="mt-2"></div>
                            <div id="promoDetails" class="mt-3 hidden">
                                <div class="alert alert-success">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <div>
                                        <h3 class="font-bold" id="promoName"></h3>
                                        <div class="text-xs" id="promoDescription"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <h3 class="card-title mb-4">Order Summary</h3>

                       <!-- Order Summary -->
                        <div class="bg-base-200 rounded-lg p-4">
                            <div class="space-y-2" id="summaryContainer">
                                <div class="text-center text-gray-500 py-4">
                                    Add services to see summary
                                </div>
                            </div>
                            <div class="divider"></div>
                            
                            <!-- Subtotal -->
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-lg">Subtotal</span>
                                <span class="text-lg" id="subtotalAmount">Rp 0</span>
                            </div>
                            
                            <!-- Discount (hidden by default) -->
                            <div class="flex justify-between items-center mb-2 text-success hidden" id="discountRow">
                                <span class="text-lg">Discount</span>
                                <span class="text-lg" id="discountAmount">- Rp 0</span>
                            </div>
                            
                            <div class="divider my-2"></div>
                            
                            <!-- Total -->
                            <div class="flex justify-between items-center text-xl font-bold">
                                <span>Total</span>
                                <span class="text-primary" id="totalAmount">Rp 0</span>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="card-actions flex items-center gap-4 justify-end mt-6">
                            <button type="button" 
                                    onclick="window.location='{{ route('customer.outlet.show', $outlet) }}'" 
                                    class="btn btn-ghost">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-sm bg-primary px-4 text-base-100 transition-all duration-300 hover:opacity-85">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                                </svg>
                                Place Order
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

        function addOrderItem() {
            itemCount++;
            const container = document.getElementById('orderItemsContainer');
            
            const itemHtml = `
                <div class="card bg-base-200 shadow-sm mb-4 order-item" data-item-id="${itemCount}">
                    <div class="card-body p-4">
                        <div class="flex justify-between items-start mb-3">
                            <h4 class="font-semibold">Service #${itemCount}</h4>
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
                                    <option value="">Choose a service</option>
                                    ${services.map(service => `
                                        <option value="${service.id}" data-price="${service.price}">
                                            ${service.name} - ${ucwords(service.service_type.replace(/_/g, ' '))} (Rp ${formatNumber(service.price)})
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
                            <span class="font-bold text-lg text-primary subtotal-display" data-item-id="${itemCount}">Rp 0</span>
                        </div>
                    </div>
                </div>
            `;
            
            container.insertAdjacentHTML('beforeend', itemHtml);
            
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

        function calculateSubtotal() {
            const items = document.querySelectorAll('.order-item');
            let total = 0;

            items.forEach((item) => {
                const serviceSelect = item.querySelector('.service-select');
                const quantityInput = item.querySelector('.quantity-input');

                if (serviceSelect.value && quantityInput.value) {
                    const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
                    const price = parseFloat(selectedOption.getAttribute('data-price')) || 0;
                    const quantity = parseInt(quantityInput.value) || 0;
                    total += price * quantity;
                }
            });

            return total;
        }

        function updateSummary() {
            const items = document.querySelectorAll('.order-item');
            const summaryContainer = document.getElementById('summaryContainer');
            const subtotal = calculateSubtotal();
            let summaryHtml = '';

            if (items.length === 0) {
                summaryContainer.innerHTML = '<div class="text-center text-gray-500 py-4">Add services to see summary</div>';
                document.getElementById('subtotalAmount').textContent = 'Rp 0';
                document.getElementById('totalAmount').textContent = 'Rp 0';
                return;
            }

            items.forEach((item) => {
                const itemId = item.getAttribute('data-item-id');
                const serviceSelect = item.querySelector('.service-select');
                const quantityInput = item.querySelector('.quantity-input');
                const subtotalDisplay = item.querySelector('.subtotal-display');

                if (serviceSelect.value && quantityInput.value) {
                    const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
                    const price = parseFloat(selectedOption.getAttribute('data-price')) || 0;
                    const quantity = parseInt(quantityInput.value) || 0;
                    const itemSubtotal = price * quantity;

                    subtotalDisplay.textContent = `Rp ${formatNumber(itemSubtotal)}`;

                    const serviceName = selectedOption.text.split(' - ')[0];

                    summaryHtml += `
                        <div class="flex justify-between items-center py-2 border-b border-base-300">
                            <div>
                                <div class="font-medium">${serviceName}</div>
                                <div class="text-xs opacity-60">${quantity} x Rp ${formatNumber(price)}</div>
                            </div>
                            <div class="font-semibold">Rp ${formatNumber(itemSubtotal)}</div>
                        </div>
                    `;
                } else {
                    subtotalDisplay.textContent = 'Rp 0';
                }
            });

            summaryContainer.innerHTML = summaryHtml || '<div class="text-center text-gray-500 py-4">Complete service details to see summary</div>';
            document.getElementById('subtotalAmount').textContent = `Rp ${formatNumber(subtotal)}`;
            
            // update total with discount if promo is applied
            const finalTotal = subtotal - currentDiscount;
            document.getElementById('totalAmount').textContent = `Rp ${formatNumber(finalTotal)}`;
            
            // revalidate promo if applied
            if (appliedPromo) {
                validatePromoCode(document.getElementById('promoCodeInput').value, true);
            }
        }

        async function validatePromoCode(promoCode, silent = false) {
            if (!promoCode.trim()) {
                if (!silent) showPromoMessage('Please enter a promo code', 'error');
                return;
            }

            const subtotal = calculateSubtotal();
            if (subtotal === 0) {
                if (!silent) showPromoMessage('Please add items to your order first', 'error');
                return;
            }

            const applyBtn = document.getElementById('applyPromoBtn');
            applyBtn.disabled = true;
            applyBtn.innerHTML = '<span class="loading loading-spinner loading-xs"></span> Validating...';

            try {
                const response = await fetch(validatePromoUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        promo_code: promoCode,
                        amount: subtotal
                    })
                });

                const result = await response.json();

                if (response.ok && result.success) {
                    appliedPromo = result.data;
                    currentDiscount = result.data.discount_amount;
                    
                    // show promo details
                    document.getElementById('promoName').textContent = result.data.promo_name;
                    document.getElementById('promoDescription').textContent = 
                        result.data.promo_description || 
                        `${result.data.promo_type === 'percentage' ? result.data.promo_value + '%' : 'Rp ' + formatNumber(result.data.promo_value)} discount`;
                    document.getElementById('promoDetails').classList.remove('hidden');
                    
                    // update discount display
                    document.getElementById('discountAmount').textContent = `- Rp ${formatNumber(currentDiscount)}`;
                    document.getElementById('discountRow').classList.remove('hidden');
                    
                    // update total
                    const finalTotal = subtotal - currentDiscount;
                    document.getElementById('totalAmount').textContent = `Rp ${formatNumber(finalTotal)}`;
                    
                    // toggle buttons
                    document.getElementById('applyPromoBtn').classList.add('hidden');
                    document.getElementById('removePromoBtn').classList.remove('hidden');
                    document.getElementById('promoCodeInput').disabled = true;
                    
                    if (!silent) showPromoMessage('Promo code applied successfully!', 'success');
                } else {
                    if (!silent) showPromoMessage(result.message || 'Invalid promo code', 'error');
                    removePromo();
                }
            } catch (error) {
                console.error('Error validating promo:', error);
                if (!silent) showPromoMessage('Failed to validate promo code', 'error');
                removePromo();
            } finally {
                applyBtn.disabled = false;
                applyBtn.innerHTML = 'Apply';
            }
        }

        function removePromo() {
            appliedPromo = null;
            currentDiscount = 0;
            
            document.getElementById('promoDetails').classList.add('hidden');
            document.getElementById('discountRow').classList.add('hidden');
            document.getElementById('applyPromoBtn').classList.remove('hidden');
            document.getElementById('removePromoBtn').classList.add('hidden');
            document.getElementById('promoCodeInput').disabled = false;
            document.getElementById('promoCodeInput').value = '';
            document.getElementById('promoMessage').innerHTML = '';
            
            updateSummary();
        }

        function showPromoMessage(message, type) {
            const messageDiv = document.getElementById('promoMessage');
            const alertClass = type === 'success' ? 'alert-success' : 'alert-error';
            messageDiv.innerHTML = `
                <div class="alert ${alertClass}">
                    <span>${message}</span>
                </div>
            `;
            
            setTimeout(() => {
                if (type === 'error') {
                    messageDiv.innerHTML = '';
                }
            }, 5000);
        }

        function formatNumber(num) {
            return new Intl.NumberFormat('id-ID').format(num);
        }

        function ucwords(str) {
            return str.replace(/\b\w/g, l => l.toUpperCase());
        }

        // event listeners for promo
        document.addEventListener('DOMContentLoaded', function() {
            addOrderItem();
            
            document.getElementById('addItemBtn').addEventListener('click', addOrderItem);
            
            document.getElementById('applyPromoBtn').addEventListener('click', function() {
                const promoCode = document.getElementById('promoCodeInput').value;
                validatePromoCode(promoCode);
            });
            
            document.getElementById('removePromoBtn').addEventListener('click', removePromo);
            
            document.getElementById('promoCodeInput').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    document.getElementById('applyPromoBtn').click();
                }
            });
        });

        // Form validation before submit
        document.getElementById('orderForm').addEventListener('submit', function(e) {
            const items = document.querySelectorAll('.order-item');
            if (items.length === 0) {
                e.preventDefault();
                alert('Please add at least one service to the order');
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
                alert('Please select at least one service with quantity');
                return false;
            }
        });
    </script>
</x-app-layout>