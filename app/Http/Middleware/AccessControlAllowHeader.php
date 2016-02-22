<?php namespace App\Http\Middleware;

use App\Exceptions\UnauthenticatedException;
use Closure;
use Illuminate\Contracts\Auth\Guard;

class AccessControlAllowHeader
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
		// ALLOW OPTIONS METHOD
		$headers = [
			'Access-Control-Allow-Origin' => '*',
			'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS, PUT, DELETE',
			'Access-Control-Allow-Headers' => 'Content-Type, X-Auth-Token, Origin',
			'Access-Control-Expose-Headers' => 'X-Auth-Token'
		];

		/**
		 * @var \Illuminate\Http\Request $response
		 */
		$response = $next($request);
		foreach ($headers as $key => $value) {
			$response->header($key, $value);
		}

		return $response;
	}

}
