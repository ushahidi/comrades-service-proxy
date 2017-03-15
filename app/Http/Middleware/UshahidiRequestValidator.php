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
        $requestValidator = new RequestValidator(config('shared_secret'));
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
