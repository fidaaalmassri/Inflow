<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InterestInfluences extends Model
{
    //
    protected $table='interests_influences';
    // public $timestamps = false;
    protected $fillable=['interest_id','influence_id'];

}
