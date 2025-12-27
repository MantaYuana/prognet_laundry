<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Owner;
use App\Models\Outlet;

class EnsuerOwner {
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response {
        $owner = Owner::where('user_id', $request->user()->id ?? null)->first();
        if (!$owner) {
            abort(403, 'Owner profile not found');
        }

        $request->attributes->set('owner', $owner);

        if ($request->route('outlet')) {
            $outletParam = $request->route('outlet');
            $outlet = $outletParam instanceof Outlet
                ? $outletParam
                : Outlet::findOrFail($outletParam);
                
            if ($outlet->owner_id !== $owner->id) {
                abort(403, 'You do not own this outlet');
            }
        }

        return $next($request);
    }
}
