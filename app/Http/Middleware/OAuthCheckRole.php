<?php

namespace CodeDelivery\Http\Middleware;

use Closure;
use CodeDelivery\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Collection;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class OAuthCheckRole
{
    private $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle($request, Closure $next, $role) //aqui adicionamos um parametro para o middleware
    {
        $id = Authorizer::getResourceOwnerId();

        $user = $this->userRepository->find($id);

        /*if(!$user instanceof Collection){
            dd($user['data']['role']);
        }*/

        if($user->role != $role){
            abort(403, 'Acesso Negado!');
        }

        return $next($request);
    }
}
