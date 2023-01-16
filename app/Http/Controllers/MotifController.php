<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Motif;

class MotifController extends Controller
{

    public function __construct()
    {
        //$this->middleware('auth');

    }

    public function index()
    {
        $motifs = Motif::list();

        return view('motif.list', [
            'results'=>$motifs
        ]);
    }

    public function ajaxlist()
    {
        $motifs = Motif::select('id', 'reference', 'nom')->filter()->get();

        return response()->json( $motifs );
    }

    /*
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('motif.update',[
            'object'=> new Motif(),
        ]);
    }

    /*
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
            'nom' => 'required|string'
        ]);

        $motif = Motif::create([
            'reference'=> request('reference') ? request('reference') : substr(request('nom'), 0, 2),
            'nom'=>request('nom'),
        ]);

       return redirect()
                ->route('motif_edit', $motif->id)
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
        $motif = Motif::findOrFail($id);

        return view('motif.update', [
            'object'=>$motif,
        ]);
    }

    /*
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->validate(request(), [
            'nom' => 'required|string|max:255|unique:motifs,nom,'.$id
        ]);

        //dd(request('reference'));
      
        $motif = Motif::findOrFail($id);
        $motif->reference = request('reference') ? request('reference') : substr(request('nom'), 0, 2);
        $motif->nom = request('nom');
        
        $motif->save();

        return redirect()
                ->route('motif_edit', $motif->id)
                ->with('success', __('global.edit_succees'));
    }

    /*
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $msg = 'delete_error';
        $flash_type = 'error';
        $motif = Motif::findOrFail($id);

        if( $motif->delete() ){
            $flash_type = 'success';
            $msg = 'delete_succees';
        }

        return redirect()
            ->route('motif')
            ->with($flash_type, __('global.'.$msg));
    }
}