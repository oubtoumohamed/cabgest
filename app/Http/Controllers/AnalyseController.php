<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Analyse;
use App\Models\Media;

class AnalyseController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');

    }

    public function index()
    {
        $analyses = Analyse::list();

        return view('analyse.list', [
            'results'=>$analyses
        ]);
    }

    public function ajaxlist()
    {
        $analyses = Analyse::select('id', 'code', 'nom')->filter()->get();

        return response()->json( $analyses );
    }

    /*
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('analyse.update',[
            'object'=> new Analyse(),
        ]);
    }

    /*
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => ['required'],
            'nom' => ['required'],
        ]);

        $analyse = Analyse::create($validated);

       return redirect()
                ->route('analyse_edit', $analyse->id)
                ->with('success', __('global.create_succees'));
    }

    /*
     * Display the specified resource.
     */

    public function show($id)
    {
        $object = Analyse::findOrFail($id);

        return view('analyse.show',compact('object'));
        // return $this->edit($id);
    }

    public function edit($id)
    {
        $analyse = Analyse::findOrFail($id);

        return view('analyse.update', [
            'object'=>$analyse,
        ]);
    }

    /*
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //dd($request->all());
        $validated = $request->validate([
            'code' => ['required'],
            'nom' => ['required'],
        ]);

        $analyse = Analyse::findOrFail($id);

        $analyse->update($validated);

        return redirect()
                ->route('analyse_edit', $analyse->id)
                ->with('success', __('global.edit_succees'));
    }

    /*
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $msg = 'delete_error';
        $flash_type = 'error';
        $analyse = Analyse::findOrFail($id);

        if( $analyse->delete() ){
            $flash_type = 'success';
            $msg = 'delete_succees';
        }

        return redirect()
            ->route('analyse')
            ->with($flash_type, __('global.'.$msg));
    }
}