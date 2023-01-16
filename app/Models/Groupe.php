<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\MainModel;

class Groupe extends Model 
{
    use MainModel;

    protected $fillable = [
        'name','roles'
    ];

    public static function selectable(){ return ['id','name']; }

    public function __toString(){
        return $this->name;
    }

    public function getname(){
        return $this->name;
    }

    public function __toHtml(){
        return ( $this->id ) ? '<a href="'.route('groupe_edit',$this->id).'" target="_blank">'.$this->name.'</a>' : "";
    }

    public function users(){
        return $this->hasMany('User','usergroupe','groupe_id');
    }
    
    public function get__roles(){

        $actions = [
            'LIST'=>'Listage',
            'CREATE'=>'Création',
            'UPDATE'=>'Modification',
            'DELETE'=>'Suppression',
        ];

        return [
            'USER' =>[
                'name' => 'Utilisateurs',
                'actions' => $actions,
            ],
            'Groupe' =>[
                'name' => 'Fonctions',
                'actions' => $actions,
            ],
            'Client' =>[
                'name' => 'Clients',
                'actions' => $actions,
            ]
        ];
    }
}
