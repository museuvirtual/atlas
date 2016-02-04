<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Collector extends Model {

	//
    protected $fillable = [
        'name',
        'id_user'
    ];

    /**
     * Devolve os mammal records do collector
     * Um Collector pode ter varios Registos
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    public function mammalrecords(){
        //REVER ISTO-> Foreing Key, Local Key...
        return $this->belongsToMany('App\MammalRecord','collector_mammal_record','collector_id','mammal_record_id')->withTimestamps();

    }

    /**
     * Get the user associated with the collector
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Collector');
    }

}
