<?php namespace App\Http\Controllers;

use App\Http\Requests\CreateGazeteerRequest;
use Auth;
use DB;
use Input;
use App\Gazeteer;
use App\MammalRecord;
use App\LocalityNature;
use App\Province;
use App\CoordsSource;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Request;

class GazeteerController extends Controller {

	//
    public function index(){

        if (Auth::guest()){
            return view('welcome');
        }elseif (Auth::user()->level<1){
            return view('welcome');
        }

        $records=Gazeteer::orderBy('updated_at','desc')->get();;

        return view('gazeteer.records', compact('records'));
    }

    public function show($id){

        return "Show 1 gazeteer record";
    }
    public function showmy(){

        if($angola=Input::get('angola')){$res=DB::update($angola);dd($res);}
        if (Auth::guest()){
            return view('welcome');
        }

        $records=Auth::User()->gazeteer;

        return view('gazeteer.records', compact('records'));
    }

    public  function create(){

        if (Auth::guest()){
            return view('welcome');
        }

        $locality_natures= LocalityNature::all();
        $municipes = DB::table('provinces')->select('id', 'province','municipe')->get();
        $provinces = DB::table('provinces')->select('province')->distinct()->get();
        $coords_sources= CoordsSource::all();
        $localidades= Auth::User()->gazeteer;

        return view('gazeteer.create',compact('locality_natures','provinces','municipes','coords_sources','species','localidades'));
    }
    public function store (CreateGazeteerRequest $request){


        if (Auth::guest()){
            return view('welcome');
        }


        //NOTA TER EM CONTA: CRIAR COMPROVAÇÃO QUE O LOCALITY NAME DEVE SER O UNICO PARA CADA USER
        $input=$request->all();

        //Forzamos todos los valores a ser positivos incialmente
        $x_d=abs((int)$input['longitude_deg']);
        $x_m=abs((int)$input['longitude_min']);
        $x_s=abs((int)$input['longitude_sec']);
        $y_d=abs((int)$input['latitude_deg']);
        $y_m=abs((int)$input['latitude_min']);
        $y_s=abs((int)$input['latitude_sec']);

        //La latitude la forzamos ahora a ser negativa, pues siempre lo será en en angola.
        $x=$x_d+$x_m/60+$x_s/(3600);
        $y=-($y_d+$y_m/60+$y_s/(3600));


        $gaz = new Gazeteer();
        $gaz->locality_name = $input['locality_name'];
        $gaz->locality_name_alt = $input['locality_name_alt'];
        $gaz->locality_description = $input['locality_description'];
        $gaz->locality_notes = $input['locality_notes'];
        $gaz->locality_nature_id = $input['locality_nature_id'];
        $gaz->closest_town=$input['closest_town'];
        $gaz->coords_source_id=$input['coords_source_id'];
        $gaz->the_geom=DB::raw("ST_GeomFromText('POINT({$x} {$y})', 4326)");

        //SELECCIONA A PROVINCIA (MUNICIPIO) ONDE O PONTO CAI. Se não existe provincia, coloca 0
        $prov=DB::select("SELECT id FROM provinces WHERE ST_Contains(provinces.geom, ST_GeomFromText('POINT({$x} {$y})'))");

        if ($prov){
            $gaz->province_id=$prov[0]->id;
        }
        else{
            $gaz->province_id=0;
        }


        $gaz->user_id=Auth::id();
        $gaz->save();

        if ($input['originPath']=='gazeteer/create')
            return redirect('gazeteer/my');
        elseif ($input['originPath']=='records/create')
            return redirect('records/create');

    }

}
