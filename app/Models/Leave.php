<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\MainModel;

class Leave extends Model 
{
    use MainModel;

    protected $fillable = [
        'from','to','days','user_id','notes','state','comment'
    ];

    public function __toHtml(){
        return ( $this->id ) ? '<a href="'.route('leave_edit',$this->id).'" target="_blank">'.$this->__toString().'</a>' : "";
    }

    
    public function getfrom(){ return Leave::dateFormat( $this->from, 'd-m-Y' ); }
    public function getto(){ return Leave::dateFormat( $this->to, 'd-m-Y' ); }
    public function getdays(){ return $this->days; }
    public function getuser_id(){ return $this->user; }
    public function getnotes(){ return $this->notes; }
    public function getstate(){ return __('leave.'.$this->state); }
    public function getcomment(){ return $this->comment; }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
