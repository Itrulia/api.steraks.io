<?php namespace App\Http\Middleware;

use App\Exceptions\UnauthenticatedException;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use JWTAuth;

class AuthenticationTokenHeader
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
		/**
		 * @var \Illuminate\Http\Request $response
		 */
		$response = $next($request);
		$headers = [];

		if ($this->auth->check()) {
			$headers['X-Auth-Token'] = JWTAuth::fromUser($this->auth->user());
		}

		foreach ($headers as $key => $value) {
			$response->header($key, $value);
		}

		return $response;
	}

}
