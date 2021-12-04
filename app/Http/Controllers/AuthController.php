<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use Exception;
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
        // $credentials = Validator::make(
        //     $request->all(),[
        //     'firstname' => 'required',
        //     'lastname' => 'required',
        //     'email' => ['required','email','unique'],
        //     'password' => ['required'],
        //     'date_naissance' => 'required',
        //     'sexe' => 'required'
        // ]);

        $credentials = Validator::make(
            $request->all(),[
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => ['required','email','unique:users,email'],
            'password' => ['required','confirmed'],
            'date_naissance' => 'required',
            'sexe' => 'required'
        ]);
        
        if($credentials->fails()){
            return response()->json([
                'error' => true,
                'message' => 'un ou plusieurs données obligatoire sont manquants',
                'email' => $credentials->failed()
            ]);
        }
    
        $user = new User($request->except('password'));
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json([
            'error' => false,
            'message' => 'L\'utilisateur a été créé avec succès',
            'user' =>  $user
        ]);
    }

    /**
     * login a user
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $this->checkTooManyFailedAttempts();
       
        $credentials = Validator::make(
            $request->only(['email','password']),[
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        if($credentials->fails()){
            return response()->json([
                'error' => true,
                'message' => 'Email/password manquants',
                'email' => $credentials->failed()
            ],400);
        }

        $user = User::where('email', $request->email)->first();
        if(!$user || !Hash::check($request->password, $user->password)){
            return response()->json([
                'error' => true,
                'message' => 'Email/password incorrect',
            ],400);
        }

        if(Auth::attempt($credentials->validated())){
           
            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'error' => false,
                'message' => 'L\'utilisateur a été authentifié avec succès',
                'user' => $user,
                'token' => $token
            ]);
        }

        RateLimiter::hit($this->throttleKey(), $seconds = 60);
        return response()->json([
            'error' => true,
            'message' => 'trop de tentative sur l\'email '.request('email').'  ... veuillez patientez'
        ]);

        // if (!Auth::attempt($credentials->validated()))
        // {
        //     RateLimiter::hit($this->throttleKey(), $seconds = 20);

        //     return response()->json([
        //         'error' => true,
        //         'message' => 'trop de tentative sur l\'email '.request('email').'  ... veuillez patientez'
        //     ]);
        // }

    }

  
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Get the rate limiting throttle key for the request.
     *
     * @return string
     */
    public function throttleKey()
    {
        return Str::lower(request('email'));
    }

     /**
     * Ensure the login request is not rate limited.
     *
     * @return void
     */
    public function checkTooManyFailedAttempts()
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 2)) {
            return;
        }

        RateLimiter::hit($this->throttleKey(), $seconds = 60);

        return response()->json([
            'error' => true,
            'message' => 'trop de tentative sur l\'email '.request('email').'  ... veuillez patientez'
        ]);
    }
}
