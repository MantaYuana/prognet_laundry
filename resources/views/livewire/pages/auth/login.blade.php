<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;

new #[Layout('layouts.guest'), Title('Luxe - Login')] class extends Component {
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="login-container flex w-full max-w-5xl h-150 bg-white shadow-xl rounded-lg overflow-hidden">
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <section class="login-form-section flex flex-col justify-center items-center p-10 w-full lg:w-1/2 bg-surface">
        <div class="text-center mb-8">
            <h1 class="logo text-4xl font-serif font-bold italic text-primary mb-1">Yuhu</h1>
            <p class="subtitle text-sm text-gray-500">Dashboard Login</p>
        </div>

        <form wire:submit="login">
            <!-- Email Address -->
            <div>
                <!-- <x-input-label for="email" :value="__('Email')" /> -->
                <label for="Label" class="block text-sm font-medium text-gray-700">Label</label>
                <!-- <x-text-input wire:model="form.email" id="email" class="block mt-1 w-full" type="email" name="email" required autofocus autocomplete="username" /> -->
                <input
                    wire:model="form.email"
                    type="email"
                    id="email"
                    name="email"
                    required autofocus autocomplete="username"
                    placeholder="Enter your email"
                    class="mt-1 block w-full px-3 py-2 border border-line rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>

                <!-- <x-text-input wire:model="form.password" id="password" class="block mt-1 w-full"
                    type="password"
                    name="password"
                    required autocomplete="current-password" /> -->
                <input
                    wire:model="form.password"
                    type="password"
                    id="password"
                    name="password"
                    required autocomplete="current-password"
                    placeholder="Enter your Password"
                    class="mt-1 block w-full px-3 py-2 border border-line rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">

                <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember" class="inline-flex items-center">
                    <input wire:model="form.remember" id="remember" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}" wire:navigate>
                    {{ __('Forgot your password?') }}
                </a>
                @endif

                <x-primary-button class="btn-login cursor-pointer w-full py-2 px-4 bg-primary text-white font-semibold rounded-md shadow-md hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition duration-150 ease-in-out">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
        </form>
        <div class="register-info mt-4 text-xs text-gray-600">
            No Account?
            <a href="{{ route('register') }}" class="register-link text-link hover:underline font-medium">Register Here</a>
        </div>
        <div class="divider flex items-center w-full max-w-xs my-6">
            <div class="grow border-t border-line"></div>
            <span class="shrink mx-4 text-gray-400 text-xs">OR</span>
            <div class="grow border-t border-line"></div>
        </div>
        <a href="#" class="btn-google flex items-center justify-center w-full max-w-xs py-2 px-4 border border-line rounded-md shadow-sm bg-white text-gray-700 font-medium hover:bg-gray-50 transition duration-150 ease-in-out">
            <img
                src="{{ asset('images/logogoogle.webp') }}"
                alt="Google Logo"
                class="w-5 h-5 mr-2">
            Login with Google
        </a>
    </section>
    <section class="image-section w-1/2 hidden lg:block h-screen">
        <img class="h-screen" src="{{ asset('images/loginpageimage.jpeg') }}" alt="">
    </section>
</div>