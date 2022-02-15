<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function saveFeedback(Request $request){

        $user = User::find(auth()->user()->id);
        $user->feedback = $request->feedback;
        $user->rightFeedback = $request->right;
        $user->save();
        return redirect(route('home'));
    }
}
