<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::list();

        if( request('forAction') == 'loadSelect' )
            return response()->json( $patients );

        return view('patient.list', [
            'results'=>$patients
        ]);
    }

    public function ajaxlist()
    {
        $patients = Patient::select('id', 'nom', 'prenom', 'cin')->filter()->get();

        return response()->json( $patients );
    }

    /*
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('patient.update',[
            'object'=> new Patient(),
        ]);
    }

    /*
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $valds =   [
            'nom'     => 'required|string|max:250|',
            'prenom'  => 'required|string|max:250|',
        ];
        if( request('email') ){
            $valds['email'] = 'required|email|unique:patients|';
        }

        $this->validate(request(), $valds);
        //return explode(',', request('roles') );
        $patient_count =Patient::where('created_at','like',date('Y-m-d').'%')->count();
        
        $ref = Patient::refgenerate($patient_count);

        $patient = Patient::create([
            'numero'                  => $ref,
            'nom'                     => request('nom'),
            'prenom'                  => request('prenom'),
            'cin'                     => request('cin'),
            'sexe'                    => Patient::get_code_sexe( request('civilite') ),
            'date_naissance'          => ( $request->date_naissance ? Patient::dateFormat( $request->date_naissance ) : date('Y-m-d H:i') ),
            'ville'                   => request('ville'),
            'adresse'                 => request('adresse'),
            'fax'                     => request('fax'),
            'tele'                    => request('tele'),
            'email'                   => request('email'),
            'civilite'                => request('civilite'),
            'commentaire'             => request('commentaire'),
            //'passeport'               => request('passeport'),
            'epoux'                   => request('epoux'),
            'login'                   => Str::random(4),
            'password'                => Str::random(5)
        ]);

       return redirect()
                ->route('patient_edit', $patient->id)
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
        $patient = Patient::findOrFail($id);

        return view('patient.update', [
            'object'=>$patient,
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
            $valds['email'] = 'required|email|unique:patients,email,'.$id;
        }

        $this->validate(request(), $valds);

        $patient = Patient::findOrFail($id);

        $patient->nom                     = request('nom');
        $patient->prenom                  = request('prenom');
        $patient->cin                     = request('cin');
        $patient->sexe                    = request('sexe');
        $patient->date_naissance          = ( $request->date_naissance && $request->date_naissance != '__-__-____' ? dateFormat( $request->date_naissance ) : null );
        $patient->ville                   = request('ville');
        $patient->adresse                 = request('adresse');
        $patient->fax                     = request('fax');
        $patient->tele                    = request('tele');
        $patient->email                   = request('email');
        $patient->civilite                = request('civilite');
        $patient->commentaire             = request('commentaire');
        //$patient->passeport               = request('passeport');
        $patient->epoux                   = request('epoux');
        
        /*if( !$patient->login )
            $patient->login = Str::random(4);

        if( !$patient->password )
            $patient->password = Str::random(5);*/
        
        $patient->save();

        return redirect()
                ->route('patient_edit', $patient->id)
                ->with('success', __('global.update_succees'));
    }

    /*
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $msg = 'delete_error';
        $flash_type = 'error';
        $patient = Patient::findOrFail($id);

        //dd($patient->can_delete());

        if($patient->can_delete()){
            $msg = 'patient_have_demande';
            $flash_type = 'warning';
        }else{
            if( $patient->delete() ){
                $flash_type = 'success';
                $msg = 'delete_succees';
            }
        }

       return redirect()
                ->route('patient', $patient->id)
                ->with($flash_type, __('global.'.$msg));

    }

}
