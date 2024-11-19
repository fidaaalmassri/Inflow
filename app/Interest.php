<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Interest extends Model
{
    //
    public function Influence()
    {
        return $this->belongsToMany(Influence::class,'interests_influences','influence_id','interest_id');
    }
}
