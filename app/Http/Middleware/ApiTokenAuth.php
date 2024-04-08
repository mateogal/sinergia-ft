<?php

namespace App\Http\Middleware;

use Closure;
use Cookie;
use Illuminate\Http\Request;
use \League\OAuth2\Server\ResourceServer;
use \Laravel\Passport\TokenRepository;
use \Laravel\Passport\Guards\TokenGuard;
use \Laravel\Passport\ClientRepository;
use \Illuminate\Support\Facades\Auth;
use Laravel\Passport\PassportUserProvider;

class ApiTokenAuth
{
    function getUser($bearerToken) {
        $tokenguard = new TokenGuard(
            \App::make(ResourceServer::class),
            new PassportUserProvider(Auth::createUserProvider('users'), 'users'),
            \App::make(TokenRepository::class),
            \App::make(ClientRepository::class),
            \App::make('encrypter')
          );
        $request = Request::create('/');
        $request->headers->set('Authorization', 'Bearer ' . $bearerToken);
        return $tokenguard->user($request);
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
        if($request->hasCookie('sinergia_token') == false){
            return redirect(route('login'));
        }

        $bearerToken = Cookie::get('sinergia_token');
        $user = $this->getUser($bearerToken);
        if (!isset($user)){
            return redirect(route('login'));
        }

        $request->attributes->add(['auth' => $user]);
        return $next($request);
    }


}
