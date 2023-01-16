<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class __ModuleName__ extends Model 
{
    protected $fillable = [
        __FillableFields__
    ];

    public function __toHtml(){
        return ( $this->id ) ? '<a href="'.route('__ModuleLower___edit',$this->id).'" target="_blank">'.$this->__toString().'</a>' : "";
    }

    __Getters__

}
