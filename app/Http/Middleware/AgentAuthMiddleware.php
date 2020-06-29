<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use DB;

class AgentAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::guard('agent')->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('agent/login');
            }
        }

        DB::table('sessions')
            ->where('id', $request->session()->getId())
            ->update(['agent_id' => Auth::guard('agent')->id()]);

        return $next($request);
    }
}
