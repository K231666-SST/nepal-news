<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\URL;

class ForceHttps {
    public function handle($request, Closure $next) {
        if ($request->header('x-forwarded-proto') === 'https') {
            URL::forceScheme('https');
        }
        return $next($request);
    }
}
