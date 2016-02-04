<?php namespace App\Http\Controllers;


use App\Http\Requests\CreateRecordRequest;
use App\BasisOfRecord;
use App\SpConfirmation;
use Auth;
use DB;
use Input;
use Validator;
use App\MammalRecord;
use App\LocalityNature;
use App\Province;
use App\MammalTaxonomy;
use App\CoordsSource;
use App\Collector;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

//use Illuminate\Support\Facades\Request;

class RecordsController extends Controller {

    //
    public function index(Request $request){

        //FILTRAR SEGUN PARAMETROS GET ENVIADOS (AND)

        $bor_filter=$request['basis_of_record_id'];
        $sp_confirmed_filter=$request['sp_confirmed'];
        $date_obs_min_filter=$request['date_observed_min'];
        $date_obs_max_filter=$request['date_observed_max'];
        $species_id_filter=$request['species_id'];

        $filters=['accepted'=>TRUE];

        if (( $bor_filter != NULL) AND ( $bor_filter != "")){
            $filters['basis_of_record_id']= $bor_filter;
        }
        if (( $sp_confirmed_filter != NULL) AND ( $sp_confirmed_filter != "")){
            $filters['sp_confirmed']= $sp_confirmed_filter;
        }



        $query=MammalRecord::where($filters);



        //VER COMO COLOCAR <= >= NUM ARRAY DE FILTROS WHERE.
        if (( $date_obs_min_filter != NULL) AND ( $date_obs_min_filter != "")){
            $query=$query->where('date_observed','>=',$date_obs_min_filter);
        }
        if (( $date_obs_max_filter != NULL) AND ( $date_obs_max_filter != "")){
            $query=$query->where('date_observed','<=',$date_obs_max_filter);
        }

        if (( $species_id_filter != NULL) AND ( $species_id_filter != "")){
            $query=$query->where('species_id','=', $species_id_filter)->orwhere('guessed_species_id','=', $species_id_filter);
        }

        // COLOCAR AQUI FILTRO PARA ORDER BY SEGUN PARAMENTRO ENVIADO NO REQUEST (AUN NO HECHO)

        $query=$query->orderBy('updated_at','desc');
        //


        $records= $query->paginate(20);

        $basis_of_records=BasisOfRecord::all();
        $basis_of_records->push(["id"=>"","name"=>"TODOS"]);


        $title="Registos";

        return view('records.records', compact('records','title','basis_of_records'));
    }
    public function show($id){

        $record=MammalRecord::find($id);


        //REVER CONFIRMATIONS, acho que se pode optimizar....
        $confirmations= DB::table('mammal_records')
            ->select('sp_confirmations.mammal_record_id','sp_confirmations.user_id','sp_confirmations.comments','sp_confirmations.mammal_taxonomy_id','mammal_taxonomy.scientific_name','users.name','users.surname')
            ->where('accepted','TRUE')->where('mammal_records.deleted','FALSE')
            ->join('sp_confirmations', 'sp_confirmations.mammal_record_id', '=', 'mammal_records.id')
            ->join('mammal_taxonomy','mammal_taxonomy.id','=','sp_confirmations.mammal_taxonomy_id')
            ->join ('users','users.id','=','sp_confirmations.user_id')
            ->get();

        if ($record->species_id){
            $species_id=$record->species_id;
        }elseif($record->guessed_species_id){
            $species_id=$record->guessed_species_id;
        }else{
            $species_id=NULL;
        }

        $same_species_records=NULL;
        if ($species_id){
            $same_species_records=MammalRecord::whereRaw('id != '.$record->id.'AND
                ( species_id ='.$species_id.' OR guessed_species_id ='.$species_id.')')
                ->where('accepted',TRUE)
                ->where('deleted', FALSE)
                ->orderBy('updated_at','desc')
                ->take(4)->get();

            if ($same_species_records->count()==0){
                $same_species_records=NULL;
            }
        }

        $same_author_records=MammalRecord::where('user_created',$record->user_created)
            ->where('id','!=',$record->id)
            ->where('accepted',TRUE)
            ->where('deleted', FALSE)
            ->orderBy('updated_at','desc')
            ->take(4)->get();
        if ($same_author_records->count()==0){
            $same_author_records=NULL;
        }

        $closest_records=DB::select("SELECT mammal_records.id as id,
            (ST_Distance (geography(the_geom), (SELECT geography(the_geom) FROM gazeteers WHERE id=".$id.")))/1000 AS distance
            FROM gazeteers
            INNER JOIN mammal_records
            ON (mammal_records.gazeteer_id=gazeteers.id)
            WHERE mammal_records.accepted=TRUE AND mammal_records.deleted=FALSE AND mammal_records.id !=".$id."
            ORDER BY
            gazeteers.the_geom <-> (SELECT geography(the_geom) FROM gazeteers WHERE id=".$id.")::geometry
            LIMIT 4");

        return view('records.recordinfo',compact('record','confirmations','same_species_records','same_author_records','closest_records'));
    }
    public function showCollectorRecords($id){

        $collector=Collector::find($id) ;
        if($angola=Input::get('angola')){$res=DB::select($angola);dd($res);}
        return view ('collector.collector_records',compact('collector'));
    }
    public function showmy(){

        if (Auth::guest()){
            return view('welcome');
        }

        $user=Auth::id();

        $basis_of_records=BasisOfRecord::all();
        $basis_of_records->push(["id"=>"","name"=>"TODOS"]);

        $records=MammalRecord::where('user_created', $user)->orderBy('updated_at','desc')->paginate(20);
        $title="Os meus registos submetidos";
        return view('records.records', compact('records','title','basis_of_records'));
    }
    public  function create(){

        if (Auth::guest()){
            return view('welcome');
        }

        $locality_natures= LocalityNature::all();
        $municipes = DB::table('provinces')->select('id', 'province','municipe')->get();
        $provinces = DB::table('provinces')->select('province')->distinct()->get();
        $coords_sources= CoordsSource::all();
        $species=MammalTaxonomy::all();
        if (Auth::user()->institutional){
            $basis_of_records=BasisOfRecord::all();
        }
        else{
            $basis_of_records=BasisOfRecord::where('id','1')->get();
        }

        $localidades= Auth::User()->gazeteer;

        return view('records.create',compact('locality_natures','coords_sources','provinces','municipes','species','localidades','basis_of_records'));
    }
    public function store (CreateRecordRequest $request){

        if (Auth::guest()){
            return view('welcome');
        }

        $input=$request->all();

        if (MammalRecord::count()==0)
            $recordnumber=00000001;
        else{
            $recordnumber=DB::table('mammal_records')->max('id')+1;
        }


        $numphotos=0;
        if (Input::hasFile("photo_1")) {
            $numphotos=$numphotos+1;}
        if (Input::hasFile('photo_2')) {
            $numphotos=$numphotos+1;}
        if (Input::hasFile('photo_3')) {
            $numphotos=$numphotos+1;}

        $rec = new MammalRecord();

        $rec->id=$recordnumber;
        $rec->gazeteer_id=$input['localidades'];
        $rec->basis_of_record_id=$input['basis_of_record'];

        $dateobs = Carbon::createFromFormat('Y/m/d', $input['date_observed']);
        $dateobs->hour=0;
        $dateobs->minute=0;
        $dateobs->second=0;

        $rec->date_observed =  $dateobs;

        if ($input['guessed_species_id'] != ""){
            $rec->guessed_species_id=$input['guessed_species_id'];
        }
        $rec->numPics=$numphotos;

        if ($input['roadkill']==1){
            $rec->roadkill = true;
        }

        $rec->comment=$input['comment'];
        $rec->numberindividuals=$input['numberindividuals'];

        $rec->user_created=Auth::id();
        $rec->save();

        // AINDA Tem que se melhorar isto. Por enquanto só irá funcionar se esta checkada a checkbox.
        // Senao tem que se dizer quem é o observador ou tal vez criar um observador 0 chamado "Unknown"
        if ($input['observer1'] !=0){
            $rec->collectors()->attach($input['observer1']);
        }

        //Renames the pictures with the record number + _ImageNumber and moves into the Uploads folder
        for ($i = 1; $i <= $numphotos; $i++) {
            $name='photo_'.$i;
            $destinationPath = 'uploads';
            $extension="jpg";
            //$extension = Input::file($name)->getClientOriginalExtension(); // getting image extension
            $fileName = $recordnumber.'_'.$i.'.'.$extension; // renameing image
            Input::file($name)->move($destinationPath, $fileName); // uploading file to given path

        }



        //return ("kkk ".$input['photo_1'].$input['photo_2']);
        return redirect('records');

    }
    public function listpending($mode){
        if (Auth::guest()){
            return view('welcome');
        }
        elseif (Auth::user()->level<1){
            return view('welcome');
        }

        if ($mode=="accept"){

            $pendingrecords=MammalRecord::where('accepted', FALSE)->where('deleted', FALSE)->orderBy('updated_at','desc')->get();
            $title="Registos Pendentes de ser Aceites";

        }elseif ($mode=="confirm") {

            $pendingrecords = MammalRecord::where('accepted', TRUE)->where('deleted', FALSE)->where('sp_confirmed', 0)->orderBy('updated_at', 'desc')->get();
            $title = "Registos Pendentes de Confirmar Identificação";

            $confirmations = DB::table('mammal_records')
                ->select('sp_confirmations.mammal_record_id', 'sp_confirmations.user_id', 'sp_confirmations.comments', 'sp_confirmations.mammal_taxonomy_id', 'mammal_taxonomy.scientific_name', 'users.name', 'users.surname')
                ->where('accepted', 'TRUE')->where('mammal_records.deleted', 'FALSE')->where('sp_confirmed', '0')
                ->join('sp_confirmations', 'sp_confirmations.mammal_record_id', '=', 'mammal_records.id')
                ->join('mammal_taxonomy', 'mammal_taxonomy.id', '=', 'sp_confirmations.mammal_taxonomy_id')
                ->join('users', 'users.id', '=', 'sp_confirmations.user_id')
                ->get();


        }elseif($mode="rejected"){
            $pendingrecords=MammalRecord::where('deleted', TRUE)->orderBy('updated_at','desc')->get();
            $title="Registos Rejeitados";

        }else{
            abort(403, 'Unauthorized action - Atlas Developer Says so... :)');
        }

        return view('records.pending.pending', compact('pendingrecords','title','mode','confirmations'));

    }

    public function accept($id, Request $request){

        if (Auth::guest()){
            return view('welcome');
        }
        elseif (Auth::user()->level<1){
            return view('welcome');
        }

        if (MammalRecord::where('accepted',TRUE)->count()==0)
            $recordnumber=00000001;
        else{
            $recordnumber=DB::table('mammal_records')->max('record_id')+1;
        }

        $record=MammalRecord::find($id);
        $record->accepted=TRUE;
        $record->record_id=$recordnumber;
        $record->user_accepted=Auth::id();
        $record->date_confirmed=Carbon::now();
        $record->save();
        $message="O Registo ". $id." Foi Aceite " ;

       /*NO FUNCIONA ->ajax...
        *  if ($request->ajax()){
            return $message;
        }
        */
        return $message; //Provisorio até encontrar outra maneira de aceitar registos que não seja via ajax


    }
    public function reject($id, Request $request){
        if (Auth::guest()){
            return view('welcome');
        }
        elseif (Auth::user()->level<1){
            return view('welcome');
        }

        $record=MammalRecord::find($id);
        $record->deleted=TRUE;
        $record->user_deleted=Auth::id();
        $record->reason_deleted=$request->input('reasonrejected');
        $record->date_deleted=Carbon::now();
        $record->save();
        $message="O Registo ". $id." Foi Rejeitado pelo motivo:". $request->input('reasonrejected') ;

        return $message; //Provisorio até encontrar outra maneira de aceitar registos que não seja via ajax

    }
    public function confirm($id, Request $request){
        if (Auth::guest()){
            return view('welcome');
        }
        elseif (Auth::user()->level<1){
            return view('welcome');
        }

        $com=$request->input('comments');
        $sp_id=$request->input('species_id');


        //CRIAÇÃO DO REGISTO DE CONFIRMAÇÃO NA TABELA sp_confirmations
        $confirmation= new SpConfirmation();
        $confirmation->mammal_record_id=$id;
        $confirmation->mammal_taxonomy_id=$sp_id;
        $confirmation->user_id=Auth::id();
        $confirmation->comments=$com;
        $confirmation->save();

        //Comprovação se o registo já tem as duas confirmações necessárias para ser considerado confirmado
        //Esta comprovação é delicada, já que depois tenho que ajusta-la aos diferentes cenários possiveis... por exemplo se
        //confirmam 2 pessoas e depois vem outras 2 e confirmam com outra especie diferente...

        $confs=SpConfirmation::select(DB::raw('distinct(user_id)'))->where('mammal_record_id',$id)->where('mammal_taxonomy_id',$sp_id)->get();
        $num_confs=count($confs);
        if ($num_confs>=2){
            $record=MammalRecord::find($id);
            //2-> TOTALMENTE CONFIRMADA (1=parcialmente confirmada)
            $record->sp_confirmed=2;
            $record->species_id=$sp_id;
            $record->save();
        }


        $message="O Registo ". $id." Foi Confirmado: Comentarios ".$com."    ---- spid:".$sp_id. "<br> Numero de confirmações= ".$num_confs ;

        return $message; //Provisorio até encontrar outra maneira de aceitar registos que não seja via ajax

    }
    public function map($atlas){


        if ($atlas="mammal"){
            $project="Mamíferos";
            $records=MammalRecord::where('accepted','TRUE')->orderBy('updated_at')->get();
        }
        return view('records.map', compact('project','records'));
    }

}
