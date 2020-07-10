<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Dashboard;

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
        $dados=[
            "cards"=>Dashboard::getCards(),
        ];
     
        return view('dashboard.home',$dados);
    }
}
