<?php namespace App\Http\Controllers;

use App\Article;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateArticleRequest;
use Auth;
use Carbon\Carbon;
use DB;

use Illuminate\Http\Request;

class ArticlesController extends Controller {

	//
    public  function create(){
        if (Auth::guest()){
            return view('welcome');
        }elseif (Auth::user()->level<1){
            return view('welcome');
        }


        return view('articles.create');
    }
    public function store (CreateArticleRequest $request){

        if (Auth::guest()){
            return view('welcome');
        } elseif (Auth::user()->level<1){
            return view('welcome');
        }
        $input=$request->all();
        $article = new Article();
        $article->title = $input['title'];
        $article->text = $input['body'];

        $date_to_pub = Carbon::createFromFormat('Y/m/d', $input['date_to_publish']);
        $date_to_pub->hour=0;
        $date_to_pub->minute=0;
        $date_to_pub->second=0;
        $article->date_to_publish = $date_to_pub;

        $article->created_by=Auth::id();
        $article->approved=1; // De momento vamos aprovar directamente os artgios, pois são escritos por experts só.
        $article->save();

        return redirect('home');


    }
}
