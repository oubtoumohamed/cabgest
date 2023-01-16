<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Traits\MainModel;

class Patient extends Model
{
    use MainModel;

    protected $fillable = [
        'numero','nom','prenom','cin','date_naissance','ville','adresse',
        'fax','tele','email','commentaire','sexe','civilite', 'passeport', 'epoux', 'login', 'password'
    ];

    protected $appends = array('text','textsearch');
    
    public static function selectable(){ return ['id','numero', 'nom', 'prenom', DB::raw('concat(nom, " ", prenom, " - ", cin) as text')]; }

    public function __toString(){
        return $this->nom.' '.$this->prenom;
    }

    public function getTextAttribute(){
        return $this->__toString();
    }

    public function getTextsearchAttribute(){
        return $this->cin.' - '.$this->nom.' '.$this->prenom;
    }

    public function demandes(){
        return $this->hasMany('App\Demande');
    }

    public function rendezvous()
    {
        return $this->hasMany('App\Rendezvous');
    }

    public function getnumero(){ return $this->numero; }
    public function getnom(){ return $this->nom; }
    public function getprenom(){ return $this->prenom; }
    public function getcin(){ return $this->cin; }
    public function getdate_naissance(){ return $this->date_naissance; }
    public function getville(){ return $this->ville; }
    public function getadresse(){ return $this->adresse; }
    public function getfax(){ return $this->fax; }
    public function gettele(){ return $this->tele; }
    public function getemail(){ return $this->email; }
    public function getcommentaire(){ return $this->commentaire; }
    public function getsexe(){ return $this->sexe; }
    public function getcivilite(){ return $this->civilite; }
    public function getpasseport(){ return $this->passeport; }
    public function getepoux(){ return $this->epoux; }
    public function getlogin(){ return $this->login; }
    public function getpassword(){ return $this->password; }

    public function can_delete(){
        $can = 0;
        /*if(request('force')){
            
            $can += DB::table('demandes')->where('demandes.patient_id', $this->id)->whereNull('demandes.deleted_at')->count();
            $can += DB::table('rendezvouses')->where('rendezvouses.patient_id', $this->id)->whereNull('rendezvouses.deleted_at')->count();
        }*/

        return $can;
    }

}


