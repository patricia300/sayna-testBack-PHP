<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
         $user = Auth::user(); 

        
        if(!Gate::allows('abonne_access',[$user]))
        {
            return response()->json([
                'error' => true,
                'message' => 'vos droit d\'accès ne permettent pas d\'accéder à la ressource'
            ]);
        }

        $credentials = Validator::make($request->all(),[
            'cartNumber' => 'bail|required|string|unique:carts,cartNumber',
            'month' => 'bail|required|string',
            'year' => 'bail|required',
            'default' => 'bail|required|string'
        ],[
            'required' => 'Informations bancaire incorrectes',
            'string' =>  'Une ou plusieurs données sont eronnées',
            'unique' => 'La carte existe déjà'
        ]);

        if($credentials->fails()){
            return response()->json([
                'error' => true,
                'message' => $credentials->errors()->first()
            ],402);
        }

        $cart = Cart::find($user->cart_id);
        $cart->update($credentials->validated());

        return response()->json([
            'error' => false,
            'message' => 'Vos données ont été mises à jour',
        ]);
    }
}
