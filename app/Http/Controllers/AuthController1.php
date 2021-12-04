<?php

namespace App\Http\Controllers;

use Exception;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * register user
     * 
     * @return Response $response
     */

    public function register(Request $request)
    {
        // $credentials = Validator::make(
        //     $request->all(),[
        //     'firstname' => 'required',
        //     'lastname' => 'required',
        //     'email' => 'required|email|unique',
        //     'password' => 'required',
        //     'date_naissance' => 'required',
        //     'sexe' => 'required'
        // ],['error']);
        
        // if($credentials->fails()){
        //     return response()->json([
        //         'error' => true,
        //         'message' => 'un ou plusieurs données sont erronées',
        //         'failed' => $credentials->failed()
        //     ]);
        // }

        // $user = new User($request->except('password'));
        // $user->password = bcrypt($request->password);
        // $user->save();
        return response()->json([
            'error' => false,
            'message' => 'L\'utilisateur a été créé avec succès',
            'user' => $request->all()
        ]);
    }


    public function validate_requirement(Request $request){
        $missing_data = Validator::make(
            $request->only(['firstname',
            'lastname',
            'email',
            'password',
            'date_naissance',
            'sexe'
        ]),[
            'lastname' => 'required',
            'email' => 'required',
            'password' => 'required',
            'date_naissance' => 'required',
            'sexe' => 'required'
        ]);

        if($missing_data->fails()){
            return [
                'message' => 'Une ou plusieurs données obligatoire sont manquantes'
            ];
        }
    }

    public function data_no_conform(Request $request)
    {
        $data_non_conform =  Validator::make(
            $request->only(['firstname',
            'lastname',
            'email',
            'password',
            'date_naissance',
            'sexe'
        ]),[
            'lastname' => 'string',
            'email' => 'string',
            'password' => 'string|min:8',
            'date_naissance' => 'date',
            'sexe' => 'string'
        ]);

        if($data_non_conform->fails())
        {
            return [
              'message' => 'Une ou plusieurs données sont eronnés'
            ];
        }

    }

    public function email_exist($email)
    {
        $exist_email = Validator::make($email,['email' => 'unique']);
    
        if($exist_email->fails())
        {
            return [ 
                'message' => 'Un compte utilisant cette adresse mail est déjà enregistré'
            ];
        }
    }

    public function validate_password_and_email(Request $request)
    {
        $validate =  Validator::make(
            $request->only([
            'email',
            'password'
        ]),[
            
            'email' => 'email',
            'password' => 'string|min:8',
        ]);
    }


     /**
     * Log in a user
     */
    public function login(Request $request)
    {
        $this->checkTooManyFailedAttempts();

        $user = User::where('email', $request->email)->first();

        try {
            $credentials = request(['email', 'password']);

            if (!Auth::attempt($credentials))
            {
                RateLimiter::hit($this->throttleKey(), $seconds = 120);

                return response()->json([
                    'status_code' => 401,
                    'message' => 'Unauthorized',
                ]);
            }

            if (!Hash::check($request->password, $user->password, [])) {
                throw new Exception('Error occured while logging in.');
            }

            $token = $user->createToken('authToken')->plainTextToken;

            RateLimiter::clear($this->throttleKey());

            return response()->json([
                'status_code' => 200,
                'message' => 'Success',
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user,
            ]);
        } catch (Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Error occured while loggin in.',
                'error' => $error,
            ]);
        }
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
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        throw new Exception('IP address banned. Too many login attempts.');
    }
}

