<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
use ComradesYodieProxy\Security\RequestValidator;

class UshahidiRequestValidator
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
        $requestValidator = new RequestValidator(env('PLATFORM_APP_TOKEN'));
        $isValid = $requestValidator->validate(
            $request->header('X-Platform-Signature'),
            $request->fullUrl(),
            $request->toArray()
        );

        if (!$isValid) {
            return new Response('Unauthorized.', 401);
        }

        return $next($request);
    }
}
