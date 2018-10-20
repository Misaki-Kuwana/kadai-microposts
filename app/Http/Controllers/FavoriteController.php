<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function store(Request $request, $id)
    {
        \Auth::user()->favorite($id);
        return redirect()->back();
    }
    
    public function destroy($id)
    {
        \Auth::user()->unfavorite($id);
        return redirect()->back();
    }
    
    public function favoriting()    
    {
       $data = [];
       $user = \Auth::user();
       $microposts = $user->favorite_microposts()->orderBy('created_at', 'desc')->paginate(10); 
       
       $data = [
           'user' => $user,
           'microposts' => $microposts,
       ];
       
       $data += $this->counts($user);
       return view('favorites.favoriting', $data);
    }
}
