<?php
namespace App\Http\Middleware;
use Closure;
class PreflightResponse
{
    #TODO fix this middleware, so i don't have to use .htaccess for CORS
    /**
    * Handle an incoming request.
    *
    * @param \Illuminate\Http\Request $request
    * @param \Closure $next
    * @return mixed
    */
    public function handle($request, Closure $next )
    {
        if ($request->getMethod() === "OPTIONS") {
            return response('');
        }
        return $next($request);
     }
 }
