<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\Customer;
use App\Models\Staff;
use App\Models\Owner;
use App\Models\Outlet;

class RegisteredUserController extends Controller {
    /**
     * Display the registration view.
     */
    public function create(): View {
        $outlets = Outlet::select('id', 'name')->orderBy('name')->get();
        return view('auth.register', compact('outlets'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:staff,owner,customer'],
            'address' => ['required', 'string', 'max:500'],
            'phone_number' => ['required', 'string', 'max:13'],
            'outlet_id' => ['required_if:role,staff', 'exists:outlets,id'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($data['role']);

        if ($data['role'] === 'staff') {
            Staff::create([
                'title' => 'Staff',
                'address' => $data['address'] ?? null,
                'phone_number' => $data['phone_number'] ?? null,
                'outlet_id' => $data['outlet_id'],
                'user_id' => $user->id,
            ]);
        } 
        if ($data['role'] === 'owner') {
            Owner::create([
                'address' => $data['address'] ?? null,
                'phone_number' => $data['phone_number'] ?? null,
                'user_id' => $user->id,
            ]);
        } 
        if ($data['role'] === 'owner') {
            Customer::create([
                'address' => $data['address'] ?? null,
                'phone_number' => $data['phone_number'] ?? null,
                'user_id' => $user->id,
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
