<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Socialite;
use Log;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }


    /*
     * Redirect the user to the Facebook authentication page.
     *
     * @return Response
    */
        public function redirectToFacebookAuth()
        {
            return Socialite::driver('facebook')->redirect();
        }

        /*
         * Obtain the user information from GitHub.
         * 
         * @return Response
        */
        public function handleFacebookAuthCallback()
        {
            $user = Socialite::driver('facebook')->user();
            $token = $user->token;
            $userId = $user->getId();
            //$userNickName = $user->getNickname();
            $userName = $user->getName();
            $userEmail = $user->getEmail();
            $userAvatar = $user->getAvatar();
            Log::info($token);
            Log::info($userId);
            //Log::info($userNickname);
            Log::info($userName);
            Log::info($userEmail);
            Log::info($userAvatar);

        }





















}
