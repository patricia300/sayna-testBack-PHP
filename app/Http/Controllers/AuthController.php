<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use Exception;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    /**
     * register a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $credentials = Validator::make(
            $request->all(),[
            'firstname' => 'bail|required|string',
            'lastname' => 'bail|required|string',
            'email' => 'bail|required|email|unique:users,email',
            'password' => 'bail|required|string|confirmed',
            'date_naissance' => 'bail|required|date',
            'sexe' => 'bail|required|string' ,
        ],[
            'required' => 'un ou plusieurs données obligatoire sont manquants',
            'string' => 'un ou plusieurs données sont eronnés',
            'unique' => 'Un compte utilisant cette adresse mail est déja enrégistré',
            'email' => 'Email/password incorrect',
            'confirmed' => 'Email/password incorrect'
        ]);
        
        if($credentials->fails()){
            return response()->json([
                'error' => true,
                'message' => $credentials->errors()->first(),
            ]);
        }

        $new_user = $credentials->validated();

        $user = User::create([
            'firstname' => $new_user['firstname'],
            'lastname' => $new_user['lastname'],
            'email' => $new_user['email'],
            'password' => bcrypt($new_user['password']),
            'date_naissance' => $new_user['date_naissance'],
            'sexe' => $new_user['sexe']
        ]);

      
        $cart = Cart::create(['user_id' => $user->id]);
        $user->fill(['cart_id' => $cart->id])->save();
        
        return response()->json([
            'error' => false,
            'message' => 'L\'utilisateur a été créé avec succès',
            'user' =>  $user
        ]);
    }

  
    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user = Auth::user();
        $user_delete = User::where('email',$user->email)->get()->first();

        if(!$user){
            return response()->json([
                'error' => true,
                'message' => 'Votre token n\'est pas correct'
            ]);
        }

       if($user_delete)
        {
            $request->user()->tokens()->delete();
            $cart = $user->cart;
            $cart->delete();
            $user_delete->delete();
           return response()->json([
                'error' => false,
                'message' => 'Votre compte a été supprimé avec succès',
            ]);
        }       
    }

    /**
     * login a user
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        if($this->checkTooManyFailedAttempts()){
            return response()->json([
                'error' => true,
                'message' => 'trop de tentative sur l\'email '.request('email').'  ... veuillez patientez',
            ],423);
        }

        $credentials = Validator::make(
        $request->only(['email','password']),[
            'email' => 'required|email',
            'password' => 'required',
        ],[
            'required' => 'Email/password manquants',
        ]);

        if($credentials->fails()){
            return response()->json([
                'error' => true,
                'message' => $credentials->errors()->first(),
            ],400);
        }

        $credentials = $credentials->validated();
        $user = User::where('email', $credentials['email'])->first();
        if (!Auth::attempt($credentials))
        {
            RateLimiter::hit($this->throttleKey(),120);

                return response()->json([
                    'error' => true,
                    'message' => 'Email/password incorrect',
                ],400);
        }
        RateLimiter::clear($this->throttleKey());
        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'error' => false,
            'message' => 'L\'utilisateur a été authentifié avec succès',
            'user' => $user,
            'token' => $token
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     *
     * @return string
     */
    public function throttleKey()
    {
        return Str::lower(request('email')) . '|' . request()->ip();
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @return void
     */
    public function checkTooManyFailedAttempts()
    {
        return RateLimiter::tooManyAttempts($this->throttleKey(),5);    
    }
}
