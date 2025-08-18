<?php

namespace App\Http\Middleware;

use App\Models\UserSection;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class RoleInjector
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        Session::put('is_superadmin', in_array(auth()->user()->is_superadmin, ['1',1]));

        $userSections = UserSection::with([
            'section',
            'user'
        ])
        ->where('user_id', auth()->user()->id)
        ->get()
        ->toArray();

        $sectionIds = [];
        foreach ($userSections as $us) {
            if (!in_array($us['section_id'], $sectionIds)) {
                $sectionIds[] = $us['section_id'];
            }
        }
        Session::put('section_ids', $sectionIds);

        return $next($request);
    }
}
