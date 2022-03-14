<?php

namespace App\Http\Middleware;
use Illuminate\Contracts\Auth\Factory as AuthFactory;
use Illuminate\Http\Request;

use Closure;

class BasicAuth
{
    /**
     * The guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param \Illuminate\Contracts\Auth\Factory $auth
     * @return void
     */
    public function __construct(AuthFactory $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($this->auth->guard('sanctum')->check()) {
            $this->auth->shouldUse('sanctum');
        } else {
            $AUTH_USER = env('API_USERNAME');
            $AUTH_PASS = env('API_PASSWORD');

            header('Cache-Control: no-cache, must-revalidate, max-age=0');

            $has_supplied_credentials = !(empty($_SERVER['PHP_AUTH_USER']) && empty($_SERVER['PHP_AUTH_PW']));

            $is_not_authenticated = (
                !$has_supplied_credentials || $_SERVER['PHP_AUTH_USER'] != $AUTH_USER || $_SERVER['PHP_AUTH_PW'] != $AUTH_PASS
            );

            if ($is_not_authenticated) {
                header('HTTP/1.1 401 Authorization Required');
                header('WWW-Authenticate: Basic realm="Access denied"');
                exit;
            }
        }

        return $next($request);
    }
}
