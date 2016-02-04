<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Input;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\MammalTaxonomy;

class TaxonomyController extends Controller {


	public function index ($group){

        if (Auth::guest()){
            return view('welcome');
        }
        elseif (Auth::user()->level<1){
            return view('welcome');
        }

        //Por defeito, quando não ha parametros no url, angola vai a 1 e africa a 0
        $ang=Input::get('angola');
        $afr=Input::get('africa');
        $angola=1;
        $africa=0;
        $order="All";
        if (Input::get('order')){
            $order=Input::get('order');
        }
        if($ang != NULL AND $ang !=""){
            $angola=Input::get('angola');
        }
        if($afr != NULL AND $afr !=""){
            $africa=Input::get('africa');
        }


        $orderlist=MammalTaxonomy::select(DB::raw('DISTINCT "order"'))->get();
        //Adiciona o valor All na lista
        $orderlist->add(["order" => "All"]);

        $species_list=DB::table($group."_taxonomy");

        if ($order!="All" AND $order!="" AND $order != NULL ){
            $species_list=$species_list->where('order',$order);
        }
        if ($angola==1){
            $species_list=$species_list->where('angola',1);
        }
        if ($africa==1){
            $species_list=$species_list->where('africa',1);
        }


        $species_list=$species_list->paginate(100);


        return view('taxonomy.list',compact('species_list','group','order','orderlist','angola','africa'));

    }
    public function show ($id){


        $specie= MammalTaxonomy::find($id);
        $taxaitems=array('kingdom','phylum','class','subclass','order','suborder','infraorder','superfamily','family',
            'subfamily','tribe','genus','subgenus','species','subspecies');

        return view('taxonomy.info',compact('specie','taxaitems'));
    }
	//
    public function listnames($group,$name){


        $term=Input::get('term');
        $angola=Input::get('angola');
        $list=array();

        //Procura TODAS as Taxa do grupo (mamiferos,etc..)
        if ($name=="names"){
            $search=DB::table($group."_taxonomy")
                ->select('id',"common_name_en","scientific_name")
                ->where(function($query) {
                    $query->where("common_name_en", 'ILIKE', '%'.Input::get('term').'%')
                        ->orwhere("scientific_name",'ILIKE', '%'.Input::get('term').'%');
                });

            if ($angola==1){
                $search=$search->where('angola',1);
            }

            $search=$search->get();

            //dd($search);
        }
        //Procura Unicamente as Taxa do grupo (mamiferos,etc..) dos registos existentes para o grupo
        if ($name=="records"){
            $search=DB::table($group."_taxonomy AS tax")
                ->select(DB::raw('DISTINCT "tax"."id","common_name_en","scientific_name"'))
                ->join($group."_records AS recs", function($join)
                {
                    $join->on('tax.id', '=', 'recs.species_id')->orOn('tax.id', '=', 'recs.guessed_species_id');
                })
                ->where("common_name_en", 'ILIKE', '%'.$term.'%')
                ->orwhere("scientific_name",'ILIKE', '%'.$term.'%')
                ->get();
        }


        foreach ($search as $result){
            $list[]= ['id'=>$result->id, 'scientific_name'=>$result->scientific_name,'common_name_en'=>$result->common_name_en];
        }
        return json_encode($list);
    }
    public function edit ($group,$id,$field){

        if (Auth::guest()){
            return redirect('/');
        }
        elseif (Auth::user()->level<1){
            return redirect('/');
        }

        $specie=DB::table($group."_taxonomy")->where('id', $id);


        if ($field=="distribution"){
            $angola=Input::get('angola');
            $africa=Input::get('africa');

            $specie->update(['angola' => $angola,'africa'=>$africa]);

        }
        if ($field=="common_name") {
            $cn_en=Input::get('common_name_en');
            $cn_pt=Input::get('common_name_pt');
            $cn_alt=Input::get('common_name_alt');
            $specie->update(['common_name_en' => $cn_en,'common_name_pt'=>$cn_pt,'common_name_alt'=>$cn_alt]);

        }





        return redirect('taxonomy/'.$id);
    }

}
