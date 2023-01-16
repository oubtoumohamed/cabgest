<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Traits\MainModel;

class Rendezvous extends Model
{
    use MainModel;

    protected $fillable = [
        'date','duree','etat','commentaire','user_id', 'patient_id', 'service_id'
    ];

    public const ETAT_ANULEE = 'annulee';
    public const ETAT_ATTENTE = 'En Attent';
    public const ETAT_VALIDE = 'valide';

    protected $appends = array('hour', 'from', "to");

    public function __toString(){
        return $this->date;
    }

    public function getHourAttribute()
    {
        return date('H', strtotime( $this->date ) );  
    }
    public function getFromAttribute()
    {
        return date('H:i', strtotime( $this->date ) );  
    }
    public function getToAttribute()
    {
        return date('H:i', strtotime( $this->date ) + 60 * $this->duree );  
    }
    public function patient()
    {
       return $this->belongsTo('App\Models\Patient');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function service()
    {
        return $this->belongsTo('App\Models\Service');
    }

    public function toArray()
    {
        $array = parent::attributesToArray();

        $filter = request('filter');
        if( $filter && array_key_exists('dataonly', $filter) and $filter["dataonly"]['value'] )
            return $array;

        $array['patient'] = $this->patient;

        return $array;
    }

}
