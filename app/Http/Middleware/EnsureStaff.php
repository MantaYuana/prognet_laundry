<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Staff;
use App\Models\Outlet;

class EnsureStaff {
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response {
        $staff = Staff::where('user_id', $request->user()->id ?? null)->first();
        if (!$staff) {
            abort(403, 'Staff profile not found');
        }

        $request->attributes->set('staff', $staff);

        if ($request->route('outlet')) {
            $outletParam = $request->route('outlet');
            $outlet = $outletParam instanceof Outlet
                ? $outletParam
                : Outlet::findOrFail($outletParam);

            if ($outlet->id !== $staff->outlet_id) {
                abort(403, 'You are not assigned to this outlet');
            }
        }

        return $next($request);
    }
}
