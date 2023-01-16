<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Rendezvous;

class RendezvousController extends Controller
{

    public function __construct()
    {
        //$this->middleware('auth');

    }
    public function index(Request $req)
    {
        $wheres = [];

        if( $req->from ){
            $wheres[] = ['date', '>=', $req->from.' 00:00'];
        }
        if( $req->to ){
            $wheres[] = ['date', '<=', $req->to.' 23:59'];
        }

        if( request('forAction') == 'loadSelect' ){            
            $rendezvouss = Rendezvous::where($wheres)->get();
            return response()->json( $rendezvouss );
        }

        $rendezvouss = Rendezvous::where($wheres)->list();

        return view('rendezvous.list', [
            'results'=>$rendezvouss,
            'object'=> new Rendezvous()
        ]);
    }

    /*
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('rendezvous.update',[
            'object'=> new Rendezvous(),
        ]);
    }

    /*
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
            'service_id' => 'required|integer',
            'patient_id' => 'required|integer',
            'from' => 'required',
        ]);

        $rendezvous = Rendezvous::create([
            'service_id' => $request->service_id,
            'date' => Rendezvous::dateTimeFormat( $request->from ),
            'duree' => $request->duree ?? 5,
            'patient_id' => $request->patient_id,
            'etat' => $request->etat ?? 'normal',
            'commentaire' => $request->commentaire,
            'user_id' => user()->id,
        ]);

       return redirect()
                ->back()
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
        $rendezvous = Rendezvous::findOrFail($id);

        return view('rendezvous.update', [
            'object'=>$rendezvous,
        ]);
    }

    /*
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->validate(request(), [
            'nom' => 'required|string|max:255|unique:rendezvouss,nom,'.$id
        ]);

        //dd(request('reference'));
      
        $rendezvous = Rendezvous::findOrFail($id);
        $rendezvous->reference = request('reference') ? request('reference') : substr(request('nom'), 0, 2);
        $rendezvous->nom = request('nom');
        
        $rendezvous->save();

        return redirect()
                ->route('rendezvous_edit', $rendezvous->id)
                ->with('success', __('global.edit_succees'));
    }

    /*
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $msg = 'delete_error';
        $flash_type = 'error';
        $rendezvous = Rendezvous::findOrFail($id);

        if( $rendezvous->delete() ){
            $flash_type = 'success';
            $msg = 'delete_succees';
        }

        return redirect()
            ->route('rendezvous')
            ->with($flash_type, __('global.'.$msg));
    }
}