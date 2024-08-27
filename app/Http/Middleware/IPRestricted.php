<?php

namespace App\Http\Middleware;

use App\Helpers\Constant;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IPRestricted
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Define allowed IP addresses
        $allowedIPs = Constant::ALLOWED_IDS;

        // Check if the request's IP address is in the allowed list     
        // if (!in_array(getUserIp(), $allowedIPs)) {
        //     // IP address is not allowed, return a forbidden response
        //     return notAllowedResponse();
        // }

        // IP address is allowed, proceed with the request
        return $next($request);
    }
}
