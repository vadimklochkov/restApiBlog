<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Models\Auth;
use Illuminate\Http\Request;
use random_int;

class AuthController extends Controller
{
    public function register(AuthRequest $user){
        $auth = new Auth;
        $date = $auth->where('login', '=', $user->input('login'))->get();

		if(empty($date[0])){
            $auth->login = $user->input('login');
            $auth->password = $user->input('password');
            $auth->save();
            return 'Регистрация нового пользователя выполнена';
        } else {
            return 'Пользователь с таким логином уже зарегестрирован.';
        }
        
    }
    public function login(AuthRequest $user){
        $auth = new Auth();
        $date = $auth->where('login', '=', $user->input('login'))->where('password', '=', $user->input('password'))->get();
        
		if(empty($date[0])){
            return 'Неверный логин или пароль.';
        } else {
            $auth = Auth::where('login', '=', $user->input('login'))->first();
            $rand = md5(rand(-999999999999999999, 999999999999999999));
            $auth->api_token = $rand;
            $auth->save();
            return "Токен для аккаунта с логином {$user->input('login')}: {$rand}";
        }
    }
}
