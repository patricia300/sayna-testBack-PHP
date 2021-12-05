<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class SongController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!Gate::allows('abonne_access',[Auth::user()]))
        {
            return response()->json([
                'error' => true,
                'songs' => 'votre abonnement ne permet pas d\'accéder à la ressource'
            ]);
        }
        $songs = Song::all();
        return response()->json([
            'error' => false,
            'songs' => $songs
        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(!Gate::allows('abonne_access',[Auth::user()]))
        {
            return response()->json([
                'error' => true,
                'songs' => 'votre abonnement ne permet pas d\'accéder à la ressource'
            ]);
        }
        
        $song = Song::find($id);

        if(!$song)
        {
            return response()->json([
                'error' => true,
                'message' => 'L\'audio n\'est pas accèssibles'
            ]);
        }

        return response()->json([
            'error' => false,
            'song' => $song
        ]);
    }
}
