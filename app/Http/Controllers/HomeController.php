<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

use App\Services\FrequentWords;
use App\Services\RSSFeed;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $this->middleware('auth');

        // $fw = new FrequentWords();
        $rss = new RSSFeed();
        $rss->findFrequentWords();
        dd($rss);

        return view('home');
    }

    
    public function checkEmail(Request $request)
    {
        $email_exist = User::where('email', $request->email)->first();

        if (isset($email_exist->email)) {

            if ($request->email == $email_exist->email) return 'taken';
        }
        return 'not_taken';
    }
}
