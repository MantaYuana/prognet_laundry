 <!-- It always seems impossible until it is done. - Nelson Mandela -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Promo for ') . $outlet->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('outlet.promo.store', $outlet->id) }}" method="POST" class="space-y-6">
                        @csrf

                        <div>
                            <label for="promo_code" class="block text-sm font-medium text-gray-700">Promo Code</label>
                            <input type="text" name="promo_code" id="promo_code" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                value="{{ old('promo_code') }}" placeholder="e.g. MERDEKA45" required maxlength="20">
                            @error('promo_code') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            <p class="text-xs text-gray-500 mt-1">Alphanumeric only, max 20 characters.</p>
                        </div>

                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Promo Name</label>
                            <input type="text" name="name" id="name" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                value="{{ old('name') }}" placeholder="e.g. Diskon Spesial Kemerdekaan" required>
                            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Description (Optional)</label>
                            <textarea name="description" id="description" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="type" class="block text-sm font-medium text-gray-700">Discount Type</label>
                                <select name="type" id="type" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required onchange="checkType()">
                                    <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>Fixed Amount (Rp)</option>
                                    <option value="percentage" {{ old('type') == 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                                </select>
                                @error('type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="value" class="block text-sm font-medium text-gray-700">Discount Value</label>
                                <input type="number" name="value" id="value" step="0.01" min="0"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    value="{{ old('value') }}" placeholder="0" required>
                                @error('value') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                <p id="value-hint" class="text-xs text-gray-500 mt-1 hidden">Max 100 for percentage.</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                                <input type="datetime-local" name="start_date" id="start_date" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    value="{{ old('start_date') }}" required>
                                @error('start_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                                <input type="datetime-local" name="end_date" id="end_date" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    value="{{ old('end_date') }}" required>
                                @error('end_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="flex items-center">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" id="is_active" value="1"
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                {{ old('is_active', 1) ? 'checked' : '' }}>
                            <label for="is_active" class="ml-2 block text-sm text-gray-900">
                                Active Status
                            </label>
                        </div>

                        <div class="flex justify-end gap-4">
                            <a href="{{ route('outlet.promo.index', $outlet->id) }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">Cancel</a>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Save Promo</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function checkType() {
            const type = document.getElementById('type').value;
            const valueInput = document.getElementById('value');
            const hint = document.getElementById('value-hint');

            if (type === 'percentage') {
                valueInput.setAttribute('max', '100');
                hint.classList.remove('hidden');
            } else {
                valueInput.removeAttribute('max');
                hint.classList.add('hidden');
            }
        }
        // Jalankan saat load halaman (untuk handle old input saat error)
        document.addEventListener('DOMContentLoaded', checkType);
    </script>
</x-app-layout>
