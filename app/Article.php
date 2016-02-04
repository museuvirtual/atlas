<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model {

	//
    protected $table='articles';
    protected $dates = ['date_to_publish'];

    public function user_created (){

        return $this->belongsTo('App\User','created_by');
    }
    //
    public function user_updated (){

        return $this->belongsTo('App\User','approved_by');
    }
    //
    public function user_deleted (){

        return $this->belongsTo('App\User','deleted_by');
    }

}
