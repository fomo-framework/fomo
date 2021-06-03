<?php

namespace Core\Authentication\Middleware;

use Core\DB;
use Core\Response;
use Core\Authentication\Auth as AuthParent;

class Auth
{
    public function handle(): bool|Response
    {
        if (bearerToken()){
            $user = DB::table('access_tokens')
                ->where('token' , hash('sha256' , bearerToken()))
                ->join('users' , 'access_tokens.user_id' , '=' , 'users.id')->select('users.*')->first();

            if ($user){
                AuthParent::setInstance($user);
                return true;
            }
        }

        return $this->unauthorized();
    }

    protected function unauthorized(): Response
    {
        return json([
            'message' => 'Unauthorized'
        ] , Response::HTTP_UNAUTHORIZED);
    }
}