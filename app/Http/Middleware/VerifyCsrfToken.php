<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		return parent::handle($request, $next);
	}
        
        protected function tokensMatch($request)
        {
            // If request is an ajax request, then check to see if token matches token provider in
            // the header. This way, we can use CSRF protection in ajax requests also.
            $token = $request->ajax() ? $request->header('X-CSRF-Token') : $request->input('_token');

            return $request->session()->token() == $token;
        }
}
