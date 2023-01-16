<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\MainModel;

class Medicament extends Model 
{
    use MainModel;
    
    protected $fillable = ['code','nom'];
    protected $appends = array('text');

    public function __toHtml(){
        return ( $this->id ) ? '<a href="'.route('medicament_edit',$this->id).'" target="_blank">'.$this->__toString().'</a>' : "";
    }

    public function __toString(){
        return $this->code;
    }


    public function getTextAttribute(){
        return $this->__toString();
    }

    public function getcode(){ return $this->code; }
    public function getnom(){ return $this->nom; }

}
