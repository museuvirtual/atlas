<?php namespace App\Http\Controllers;
use App\Article;
use App\MammalRecord;
use Carbon\Carbon;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
        $lastRecords=MammalRecord::where('numPics','>',0)->where('accepted',TRUE)->orderBy('updated_at','desc')->get();
		return view('home3', compact('lastRecords'));
	}
    public function home()
    {
        $lastRecords=MammalRecord::where('numPics','>',0)->where('accepted',TRUE)->orderBy('updated_at','desc')->take(4)->get();
        $fixedArticles=Article::latest('date_to_publish')->where('approved',true)->where('fixed_position','>',0)->where('date_to_publish','<=', Carbon::now())->get();
        $lastArticles=Article::latest('date_to_publish')->where('approved',true)->where('date_to_publish','<=', Carbon::now())->get();
        return view('home4', compact('lastRecords','lastArticles','fixedArticles'));
    }

    public function about()
    {
        return view('about');
    }
    public function support()
    {
        return view('support');
    }

}
