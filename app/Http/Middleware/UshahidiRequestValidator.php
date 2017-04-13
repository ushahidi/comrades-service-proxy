<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
use App\Security\RequestValidator;

use Log;
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
        $requestValidator = new RequestValidator(config('options.ushahidi.shared_secret'));

        $isValid = $requestValidator->validate(
            $request->header('X-Ushahidi-Signature'),
            $request->fullUrl(),
            json_encode($request->all())
        );


        if (!$isValid) {
            return new Response('Unauthorized.', 401);
        }

        return $next($request);
    }
}
