<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profiles extends Model
{
    protected $guarded = array('id');

    public static $rules = array(
        'name' => 'required',
        'gender' => 'required',
        'hobby' => 'required',
        'introduction' =>  'required',

    );

    public function histories()
    {
        return $this->hasMany('App\ProfileHistory','foreign_key','profile_id');

    }
}
