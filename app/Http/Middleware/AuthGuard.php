<?php

namespace App\Http\Middleware;

use App\Models\GroupAccess;
use App\Models\GroupPath;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthGuard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('isLoggedIn')) {
            return redirect()->route('signin')->with('error', 'Silahkan login terlebih dahulu');
        }

        $expires_in = session('expires_in');
        $current_time = time();

        if ($expires_in < $current_time) {
            session()->flush();
            return redirect()->route('signin')->with('error', 'Sesi login telah berakhir, silahkan login kembali');
        }

        $controller = $request->route()->getPrefix();
        $group_id = session()->get('group_id');


        $groupAccess = GroupAccess::join('access_path', 'group_access.access_id', '=', 'access_path.id')
            ->where('group_id', $group_id)
            ->where('link', $controller)
            ->first();

        if (!$groupAccess) {
            $landingPage = GroupPath::where('id', $group_id)->first();
            return redirect()->to($landingPage->landing_page);
        }

        return $next($request);
    }
}
