<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $user = Auth::user() ; 

        $credentials = Validator::make($request->all(),[
            'cartNumber' => 'required|unique:carts,cartNumber',
            'month' => 'required|string',
            'year' => 'required',
            'default' => 'required'
        ]);

        if($credentials->fails()){
            return response()->json([
                'error' => true,
                'message' => 'informations bancaire incorrectes'
            ]);
        }

        $cart = new Cart($credentials->validated());
        $cart->save();
        $cart->user()->associate($user)->save();
        $user->cart = $cart->id;
        $cart->update();

        return response()->json([
            'error' => false,
            'message' => 'Vos données ont été mis à jour',
            'cart' => $cart
        ]);
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
}
