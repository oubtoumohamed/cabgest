<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Caisse;
use App\Models\Media;

class CaisseController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');

    }
    public function index()
    {
        $caisses = Caisse::list();

        if( request('forAction') == 'loadSelect' )
            return response()->json( $caisses );

        return view('caisse.list', [
            'results'=>$caisses
        ]);
    }

    public function ajaxlist()
    {
        $caisses = Caisse::select('id', 'numero', 'nom')->filter()->get();

        return response()->json( $caisses );
    }

    /*
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('caisse.update',[
            'object'=> new Caisse(),
        ]);
    }

    /*
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'numero' => ['required'],
            'nom' => ['required'],
        ]);

        $caisse = Caisse::create($validated);

       return redirect()
                ->route('caisse_edit', $caisse->id)
                ->with('success', __('global.create_succees'));
    }

    /*
     * Display the specified resource.
     */

    public function show($id)
    {
        $object = Caisse::findOrFail($id);

        return view('caisse.show',compact('object'));
        // return $this->edit($id);
    }

    public function edit($id)
    {
        $caisse = Caisse::findOrFail($id);

        return view('caisse.update', [
            'object'=>$caisse,
        ]);
    }

    /*
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //dd($request->all());
        $validated = $request->validate([
            'numero' => ['required'],
            'nom' => ['required'],
        ]);

        $caisse = Caisse::findOrFail($id);

        $caisse->update($validated);

        return redirect()
                ->route('caisse_edit', $caisse->id)
                ->with('success', __('global.edit_succees'));
    }

    /*
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $msg = 'delete_error';
        $flash_type = 'error';
        $caisse = Caisse::findOrFail($id);

        if( $caisse->delete() ){
            $flash_type = 'success';
            $msg = 'delete_succees';
        }

        return redirect()
            ->route('caisse')
            ->with($flash_type, __('global.'.$msg));
    }
}