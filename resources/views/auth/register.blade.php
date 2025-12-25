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

                <!-- Button -->
                <button
                    type="submit"
                    class="w-full py-2 mt-2 text-sm font-semibold text-white transition rounded-md bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                    Register
                </button>
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
