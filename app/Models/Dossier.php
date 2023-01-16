<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Traits\MainModel;

class Dossier extends Model
{
    use MainModel;

    protected $fillable = ['numero','patient_id','motif_id','datetime','poids','taille','tension','caisse_id','user_id','comment'];

    public function __toString(){
        return $this->numero;
    }

    public function patient(){
        return $this->belongsTo('App\Models\Patient');
    }

    public function user()
    {
        return $this->hasMany('App\Models\User');
    }

    public function caisse()
    {
        return $this->hasMany('App\Models\Caisse');
    }

    public function motif()
    {
        return $this->hasMany('App\Models\Motif');
    }


    public function getnumero(){ return $this->numero; }
    public function getpatient_id(){ return $this->patient_id; }
    public function getdatetime(){ return $this->datetime; }
    public function getpoids(){ return $this->poids; }
    public function gettaille(){ return $this->taille; }
    public function gettension(){ return $this->tension; }
    public function getcaisse_id(){ return $this->caisse_id; }
    public function getmotif_id(){ return $this->motif; }
    public function getuser_id(){ return $this->user_id; }
    public function getcomment(){ return $this->comment; }

    public function can_delete(){
        $can = 0;
        /*if(request('force')){
            
            $can += DB::table('demandes')->where('demandes.patient_id', $this->id)->whereNull('demandes.deleted_at')->count();
            $can += DB::table('rendezvouses')->where('rendezvouses.patient_id', $this->id)->whereNull('rendezvouses.deleted_at')->count();
        }*/

        return $can;
    }

}


