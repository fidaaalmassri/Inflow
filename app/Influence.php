<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Influence extends Model
{
    //
      protected $fillable = [
        'user_id','birthday','fname','lname','gender','birthday','location','description'
    ];
  protected $dates = ['birthday'];

    public function getBirthdayAttribute($value) {
        return \Carbon\Carbon::parse($value)->format('m/d/Y');
    }
    public function interests()
    {
        return $this->belongsToMany(Interest::class,'interests_influences','interest_id','influence_id');
    }

   
}
