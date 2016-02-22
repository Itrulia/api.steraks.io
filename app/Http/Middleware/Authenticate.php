<?php namespace App\Http\Middleware;

use App\Exceptions\UnauthenticatedException;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use JWTAuth;

class Authenticate
{

	/**
	 * The Guard implementation.
	 *
	 * @var Guard
	 */
	protected $auth;

	/**
	 * Create a new filter instance.
	 *
	 * @param  Guard $auth
	 *
	 */
	public function __construct(Guard $auth)
	{
		$this->auth = $auth;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure $next
	 *
	 * @return mixed
	 * @throws UnauthenticatedException
	 */
	public function handle($request, Closure $next)
	{
		$token = $request->header('X-Auth-Token');

		if (!is_null($token)) {
			JWTAuth::authenticate($token);
		}

		return $next($request);
	}
}
