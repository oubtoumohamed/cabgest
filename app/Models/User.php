<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\MainModel;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, MainModel;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'firstname',
        'lastename',
        'username',
        'role',
        'cin',
        'phone',
        'adresse',
        'avatar',

    ];

    public static function selectable(){ return ['id','firstname', 'lastename', DB::raw('concat(firstname, " ", lastename) as text')]; }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function __toString(){
        return ( $this->id ) ? $this->firstname." ".$this->lastename." " : "";
    }

    public function __toHtml(){
        return ( $this->id ) ? '<a href="'.route('user_edit',$this->id).'" target="_blank">'.$this->__toString().'</a>' : "";
    }
    

    public function getfirstname(){ return $this->firstname; }
    public function getlastename(){ return $this->lastename; }
    public function getusername(){ return $this->username; }
    public function getrole(){ return $this->role; }
    public function getemail(){ return $this->email; }
    public function getphone(){ return $this->phone; }
    public function getgroupes(){ return $this->groupes; }

    public function getavatar($size="xxs"){
        return $this->picture ? $this->getavatarlink($size) : $this->getavatartext($size);
    }
    
    
    public function groupes(){
        return $this->belongsToMany('App\Models\Groupe','usergroupes','user_id');
    }

    public function picture(){
        return $this->belongsTo('App\Models\Media','avatar','id');
    }

    public function avatar(){
        return  '<span class="avatar">' . ($this->picture ? $this->picture->reference : substr($this->firstname, 0, 2) ).'</span>';
    }

    public function getavatartext($size="lg"){
        return $this->picture ? '' : '<div class="avatar-'.$size.'"><span class="avatar-title rounded-circle bg-info text-white">'.substr($this->firstname, 0, 1).'</span></div>';
    }

    public function getavatarlink($size="lg", $link = null){
        return '<img src="'.( $link == null ? $this->picture->link() : $link ).'" title="'.$this->firstname.'" class="avatar-'.$size.' rounded-circle me-2 shadow">';
    }

    public function getavatarfulllink(){
        return $this->picture ? $this->picture->link() : asset('avatar.jpg');
    }

    public function roles(){

        $storedRoles = \Session::get('roles');
        if( !$storedRoles ){
            
            \Session::forget('roles');
            $roles = [];
            $roles[] = strtolower($this->role);

            foreach ($this->groupes as $groupe) {
                foreach (explode(',', $groupe->roles) as $role) {
                    $roles[] = strtolower($role) ;

                }
            }

            \Session::put('roles', $roles);

            return \Session::get('roles');
        }

        return $storedRoles;
    }
    
    public function isGranted($role){
        
        if($this->role == "ADMIN")
           return true;
        
        $roles = $this->roles();
        
        return in_array( strtolower($role), $roles );
    }

    public function scopeGroupe($query)
    {
        global $filter;
        $filter = request('filter');

        if( $filter["groupes"] and $filter["groupes"]['value'] ){
            return $query->whereHas('groupes', function ($query) {
                global $filter;


                $query->where('groupe_id', $filter["groupes"]['value']);
            });
        }
    }

}
