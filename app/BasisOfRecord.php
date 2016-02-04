<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class BasisOfRecord extends Model
{

    //
    protected $table = 'basis_of_records';

    //

    public function mammalrecords()
    {

        return $this->hasMany('App\MammalRecord');

    }
}
