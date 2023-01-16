<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Traits\MainModel;

class Motif extends Model
{
    use MainModel;

    protected $fillable = [
        'reference','nom'
    ];
    protected $appends = array('text');

    public static function selectable(){ return ['id','reference', 'nom', DB::raw('concat(reference, " ", nom) as text')]; }

    public function __toString(){
        return $this->nom;
    }

    public function getTextAttribute(){
        return $this->__toString();
    }

    public function getreference(){ return $this->reference; }
    public function getnom(){ return $this->nom; }
    
    public function can_delete(){
        $can = 0;
        /*if(request('force')){
            
            $can += DB::table('demandes')->where('demandes.patient_id', $this->id)->whereNull('demandes.deleted_at')->count();
            $can += DB::table('rendezvouses')->where('rendezvouses.patient_id', $this->id)->whereNull('rendezvouses.deleted_at')->count();
        }*/

        return $can;
    }

}


