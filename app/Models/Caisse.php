<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\MainModel;

class Caisse extends Model 
{
    use MainModel;
    
    protected $fillable = ['numero','nom'];

    protected $appends = array('text');

    public function __toString(){
        return $this->numero.' '.$this->nom;
    }

    public function __toHtml(){
        return ( $this->id ) ? '<a href="'.route('caisse_edit',$this->id).'" target="_blank">'.$this->__toString().'</a>' : "";
    }

    public function getTextAttribute(){
        return $this->__toString();
    }

    public function getnumero(){ return $this->numero; }
    public function getnom(){ return $this->nom; }

}
