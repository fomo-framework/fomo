<?php

namespace Core\Authentication;

use Core\DB;
use Workerman\Protocols\Http\Response;

class AuthMiddleware
{
    public function handle(): bool|Response
    {
        if (bearerToken()){
            $user = DB::table('access_tokens')
                ->where('token' , hash('sha256' , bearerToken()))
                ->join('users' , 'access_tokens.user_id' , '=' , 'users.id')->select('users.*')->first();

            if ($user){
                Auth::setInstance($user);
                return true;
            }
        }

        return $this->unauthorized();
    }

    protected function unauthorized(): Response
    {
        return json([
            'message' => 'Unauthorized'
        ] , 401);
    }
}