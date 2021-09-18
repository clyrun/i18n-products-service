<?php

namespace App\Http\Middleware;

use App\Services\APIResponse;
use Closure;
use Illuminate\Http\Response;

class LocalizationMiddleware
{
    /**
     * Array of Supported Languages
     *
     * @var array|string[]
     */
    private array $supported_locales = [
        'en-gb',
        'fr-ch'
    ];

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //Requested locale /api/en-gb/
        $requested_locale = $request->route('locale');

        //Set the preferred locale type if supported
        if (!in_array($requested_locale, $this->supported_locales)) {
            return APIResponse::errorResponse(Response::HTTP_BAD_REQUEST, trans('api/general.invalid_locale_provided'));
        }

        app()->setLocale($requested_locale);

        return $next($request);
    }
}
