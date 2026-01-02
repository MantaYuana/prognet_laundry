<x-guest-layout>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div
            class="w-full max-w-md px-8 py-6 bg-white shadow-lg rounded-xl">

            <!-- Header -->
            <div class="mb-6 text-center">
                <h1 class="mb-1 font-serif text-3xl italic font-bold text-primary">
                    Luxe
                </h1>
                <p class="text-sm text-gray-500">
                    Register a new account
                </p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <!-- Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Name
                    </label>
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        autofocus
                        autocomplete="name"
                        placeholder="Your full name"
                        class="block w-full px-3 py-2 mt-1 text-sm border rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                    <x-input-error :messages="$errors->get('name')" />
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Email
                    </label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autocomplete="username"
                        placeholder="Enter your email"
                        class="block w-full px-3 py-2 mt-1 text-sm border rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                    <x-input-error :messages="$errors->get('email')" />
                    {{-- <div class="validator-hint">Enter valid email address</div> --}}
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Password
                    </label>
                    <input
                        type="password"
                        name="password"
                        required
                        autocomplete="new-password"
                        placeholder="Create a password"
                        class="block w-full px-3 py-2 mt-1 text-sm border rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                    <x-input-error :messages="$errors->get('password')" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Confirm Password
                    </label>
                    <input
                        type="password"
                        name="password_confirmation"
                        required
                        autocomplete="new-password"
                        placeholder="Repeat your password"
                        class="block w-full px-3 py-2 mt-1 text-sm border rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                    <x-input-error :messages="$errors->get('password_confirmation')" />
                </div>
                     
                <!-- Role Select -->    
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Select Your Type of Account
                    </label>
                    <select name="role" id="roleSelect" required class="select">
                        <option value="customer" @selected(old('role') === 'customer')>Customer</option>
                        <option value="owner" @selected(old('role') === 'owner')>Owner</option>
                        <option value="staff" @selected(old('role') === 'staff')>Staff</option>
                    </select>
                    <x-input-error :messages="$errors->get('role')" />
                </div>
                
                <!-- Phone -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Phone Number</label>
                    <input
                        type="text"
                        name="phone_number"
                        value="{{ old('phone_number') }}"
                        placeholder="Enter your phone number"
                        class="block w-full px-3 py-2 mt-1 text-sm border rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                    <x-input-error :messages="$errors->get('phone_number')" />
                </div>

                <!-- Address -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Address</label>
                    <input
                        type="text"
                        name="address"
                        value="{{ old('address') }}"
                        placeholder="Enter where you live"
                        class="block w-full px-3 py-2 mt-1 text-sm border rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                    <x-input-error :messages="$errors->get('address')" />
                </div>

                <!-- Staff-only outlet -->
                <div id="staffOutletField" class="{{ old('role') === 'staff' ? '' : 'hidden' }}">
                    <label class="block text-sm font-medium text-gray-700">Outlet</label>
                    <select name="outlet_id" class="select">
                        <option value="">Select outlet</option>
                        @foreach ($outlets as $outlet)
                            <option value="{{ $outlet->id }}" @selected(old('outlet_id') == $outlet->id)>
                                {{ $outlet->name }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('outlet_id')" />
                </div>

                <!-- Button -->
                <x-primary-button
                            class="w-full mt-6 text-sm font-medium normal-case transition-all duration-200 rounded-lg shadow-lg btn btn-primary hover:shadow-xl hover:brightness-110 active:scale-95">
                             Register
                </x-primary-button>

            </form>

            <!-- Login link -->
            <div class="mt-4 text-xs text-center text-gray-600">
                Already registered?
                <a
                    href="{{ route('login') }}"
                    class="font-medium text-primary hover:underline">
                    Log in
                </a>
            </div>

        </div>
    </div>
</x-guest-layout>

<script>
    const roleSelect = document.getElementById('roleSelect');
    const staffOutletField = document.getElementById('staffOutletField');
    roleSelect.addEventListener('change', () => {
        staffOutletField.classList.toggle('hidden', roleSelect.value !== 'staff');
    });
</script>