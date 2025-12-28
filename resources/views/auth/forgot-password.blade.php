<x-guest-layout>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="w-full max-w-md px-8 py-10 bg-white shadow-xl rounded-xl">

            <!-- Title -->
            <div class="mb-6 text-center">
                <h1 class="mb-1 font-serif text-3xl italic font-bold text-primary">
                    Luxe
                </h1>
                <p class="text-sm text-gray-500">
                    Reset Password
                </p>
            </div>

            <!-- Description -->
            <div class="mb-6 text-sm text-center text-gray-600">
                {{ __('Forgot your password? No problem. Just enter your email and we’ll send you a reset link.') }}
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                @csrf

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Email
                    </label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        placeholder="Enter your email"
                        class="block w-full px-3 py-2 mt-1 text-sm border rounded-md border-line focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                    <x-input-error :messages="$errors->get('email')" class="mt-1" />
                </div>

                <!-- Action -->
                <x-primary-button
                    class="grid w-full max-w-sm mx-auto mt-6 text-sm font-medium normal-case transition-all duration-200 rounded-lg shadow-lg btn btn-primary h-11 place-items-center hover:shadow-xl hover:brightness-110 active:scale-95">
                    {{ __('Send Reset Link') }}
                    </x-primary-button>
            </form>

            <!-- Back to Login -->
            <div class="mt-6 text-xs text-center text-gray-600">
                Remember your password?
                <a href="{{ route('login') }}"
                   class="font-medium text-primary hover:underline">
                    Back to Login
                </a>
            </div>

        </div>
    </div>
</x-guest-layout>
