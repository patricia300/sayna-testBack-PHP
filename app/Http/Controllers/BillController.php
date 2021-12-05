<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
            $user = Auth::user();
            if(!Gate::allows('abonne_access',$user))
            {
                return response()->json([
                    'error' => true,
                    'message' => 'vos droits d\'accès ne permettent pas d\'accéder à la ressource'
                ]);
            }

            return response()->json([
                'error' => false,
                'bill' => $user->bills
            ]);
    }
}
