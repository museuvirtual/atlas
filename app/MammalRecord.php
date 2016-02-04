<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class MammalRecord extends Model {

	//
    protected $table='mammal_records';
    protected $dates = ['date_observed'];

    /**
     * Get the Collectors Associated with the mammal Record
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function collectors (){

        return $this->belongsToMany('App\Collector','collector_mammal_record','mammalRecord_id','collector_id')->withTimestamps();
    }
    public function gazeteer(){
        return $this->belongsTo('App\Gazeteer','gazeteer_id');
    }
    //
    public function type_of_record (){

        return $this->belongsTo('App\BasisOfRecord','basis_of_record_id');
    }
    //
    public function created_by (){

        return $this->belongsTo('App\User','user_created');
    }
    //
    public function updated_by (){

        return $this->belongsTo('App\User','user_updated');
    }
    //
    public function deleted_by (){

        return $this->belongsTo('App\User','user_deleted');
    }
    //
    public function accepted_by (){

        return $this->belongsTo('App\User','user_accepted');
    }
    //
    public function guessed_species (){

        return $this->belongsTo('App\MammalTaxonomy','guessed_species_id');
    }
    public function species (){

        return $this->belongsTo('App\MammalTaxonomy','species_id');
    }

}
