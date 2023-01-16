<?php

namespace App\Http\Controllers;

use App\Models\Dossier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DossierController extends Controller
{
    public function index()
    {
        $dossiers = Dossier::list();

        return view('dossier.list', [
            'results'=>$dossiers
        ]);
    }

    public function today()
    {
        $dossiers = Dossier::where('datetime', 'like', date('Y-m-d').'%')->list();

        return view('dossier.list', [
            'results'=>$dossiers
        ]);
    }

    /*
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dossier.update',[
            'object'=> new Dossier(),
        ]);
    }

    /*
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->all());

        /*$valds =   [
            'nom'     => 'required|string|max:250|',
            'prenom'  => 'required|string|max:250|',
        ];
        if( request('email') ){
            $valds['email'] = 'required|email|unique:dossiers|';
        }*/

        //$this->validate($request, $valds);
        //return explode(',', request('roles') );
        $dossier_count =Dossier::where('created_at','like',date('Y-m-d').'%')->count();
        
        $ref = Dossier::refgenerate($dossier_count);

        $dossier = Dossier::create([
            'numero'     => $ref,
            'patient_id' => $request->patient_id,
            'datetime'   => date('Y-m-d H:i'),
            'motif_id'   => $request->motif_id,
            'caisse_id'  => $request->caisse_id,
            'poids'      => $request->poids,
            'taille'     => $request->taille,
            'tension'    => $request->tension,
            'comment'    => $request->comment
        ]);

       return redirect()
                ->route('dossier_edit', $dossier->id)
                ->with('success', __('global.create_succees'));
    }

    
    /*
     * Display the specified resource.
     */

    public function show($id)
    {
        return $this->edit($id);
    }

    
    public function edit($id)
    {
        $dossier = Dossier::findOrFail($id);

        return view('dossier.update', [
            'object'=>$dossier,
        ]);
    }

    /*
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $valds = [
            'nom'      =>'required|string|max:250|',
            'prenom'   =>'required|string|max:250',
        ];
        if( request('email') ){
            $valds['email'] = 'required|email|unique:dossiers,email,'.$id;
        }

        $this->validate(request(), $valds);

        $dossier = Dossier::findOrFail($id);

        $dossier->nom                     = request('nom');
        $dossier->prenom                  = request('prenom');
        $dossier->cin                     = request('cin');
        $dossier->sexe                    = request('sexe');
        $dossier->date_naissance          = ( $request->date_naissance && $request->date_naissance != '__-__-____' ? dateFormat( $request->date_naissance ) : null );
        $dossier->ville                   = request('ville');
        $dossier->adresse                 = request('adresse');
        $dossier->fax                     = request('fax');
        $dossier->tele                    = request('tele');
        $dossier->email                   = request('email');
        $dossier->civilite                = request('civilite');
        $dossier->commentaire             = request('commentaire');
        //$dossier->passeport               = request('passeport');
        $dossier->epoux                   = request('epoux');
        
        /*if( !$dossier->login )
            $dossier->login = Str::random(4);

        if( !$dossier->password )
            $dossier->password = Str::random(5);*/
        
        $dossier->save();

        return redirect()
                ->route('dossier_edit', $dossier->id)
                ->with('success', __('global.update_succees'));
    }

    /*
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $msg = 'delete_error';
        $flash_type = 'error';
        $dossier = Dossier::findOrFail($id);

        //dd($dossier->can_delete());

        if($dossier->can_delete()){
            $msg = 'dossier_have_demande';
            $flash_type = 'warning';
        }else{
            if( $dossier->delete() ){
                $flash_type = 'success';
                $msg = 'delete_succees';
            }
        }

       return redirect()
                ->route('dossier', $dossier->id)
                ->with($flash_type, __('global.'.$msg));

    }

}
