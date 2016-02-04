<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Gazeteer extends Model {

    protected $table='gazeteers';

    public function user(){

        return $this->belongsTo('App\User', 'user_id', 'id');

    }
    public function coordenadas ($id_gazeteer)
    {
        $coordenadas = DB::table('gazeteers')
            ->select(DB::raw('ST_X(the_geom) as lon, ST_Y(the_geom) AS lat'))
            ->where('id',$id_gazeteer)
            ->first();
        return $coordenadas;
    }
    public function province (){

        return $this->belongsTo('App\Province','province_id');
    }


	//

}
