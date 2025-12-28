<x-guest-layout>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div
            class="flex w-full max-w-4xl overflow-hidden bg-white rounded-xl shadow-xl
                   min-h-[520px]">

            <!-- LEFT : FORM -->
            <section
                class="flex flex-col justify-center w-full px-10 py-8 lg:w-1/2 bg-surface">

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <!-- Logo -->
                <div class="mb-6 text-center">
                    <h1 class="mb-1 font-serif text-4xl italic font-bold text-primary">
                        Luxe
                    </h1>
                    <p class="text-sm text-gray-500">
                        Dashboard Login
                    </p>
                </div>

                <form method="POST" action="{{ route('login') }}" class="w-full max-w-sm mx-auto">
                    @csrf

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
                            autofocus
                            autocomplete="username"
                            placeholder="Enter your email"
                            class="block w-full px-3 py-2 mt-1 text-sm border rounded-md border-line focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700">
                            Password
                        </label>
                        <input
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            placeholder="Enter your password"
                            class="block w-full px-3 py-2 mt-1 text-sm border rounded-md border-line focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                        <x-input-error :messages="$errors->get('password')" class="mt-1" />
                    </div>

                    <!-- Remember -->
                    <div class="flex items-center mt-4">
                        <input
                            id="remember_me"
                            type="checkbox"
                            name="remember"
                            class="border-gray-300 rounded text-primary focus:ring-primary">
                        <label for="remember_me" class="ml-2 text-sm text-gray-600">
                            Remember me
                        </label>
                    </div>

                    <!-- Action -->
                    <x-primary-button
                    class="w-full mt-6 text-sm font-medium normal-case transition-all duration-200 rounded-lg shadow-lg btn btn-primary hover:shadow-xl hover:brightness-110 active:scale-95">
                    Log in
                    </x-primary-button>
                        
                    <!-- Forgot -->
                    @if (Route::has('password.request'))
                        <div class="mt-4 text-center">
                            <a
                                href="{{ route('password.request') }}"
                                class="text-sm text-gray-500 hover:underline">
                                Forgot your password?
                            </a>
                        </div>
                    @endif
                </form>

                <!-- Register -->
                <div class="mt-4 text-xs text-center text-gray-600">
                    No Account?
                    <a href="{{ route('register') }}"
                       class="font-medium text-primary hover:underline">
                        Register Here
                    </a>
                </div>

                <!-- Divider -->
                <div class="flex items-center w-full max-w-xs mx-auto my-6">
                    <div class="flex-1 border-t border-line"></div>
                    <span class="mx-4 text-xs text-gray-400">OR</span>
                    <div class="flex-1 border-t border-line"></div>
                </div>

                <!-- Google -->
                <a
                    href="#"
                     class="grid w-full max-w-sm grid-flow-col gap-3 mx-auto text-sm font-medium normal-case transition-all duration-200 rounded-lg shadow-lg btn btn-outline h-11 auto-cols-max place-content-center place-items-center border-line hover:shadow-xl hover:bg-gray-50 active:scale-95">
                    <img
                         src="{{ asset('images/logogoogle.webp') }}"
                        alt="Google"
                        class="block w-5 h-5">
                        <span class="leading-none">
                            Login with Google
                    </span>
                </a>
            </section>

            <!-- RIGHT : IMAGE -->
            <section class="hidden lg:block lg:w-1/2">
                <img
                    src="{{ asset('images/loginpageimage.jpeg') }}"
                    class="object-cover w-full h-full"
                    alt="Login Image">
            </section>
        </div>
    </div>
</x-guest-layout>
