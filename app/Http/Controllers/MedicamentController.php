<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Medicament;
use App\Models\Media;

class MedicamentController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');

    }
    public function index()
    {
        $medicaments = Medicament::list();

        return view('medicament.list', [
            'results'=>$medicaments
        ]);
    }

    public function ajaxlist()
    {
        $medicaments = Medicament::select('id', 'code', 'nom')->filter()->get();

        return response()->json( $medicaments );
    }

    /*
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('medicament.update',[
            'object'=> new Medicament(),
        ]);
    }

    /*
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /*$validated = $request->validate([
            'numero' => ['required'],
            'nom' => ['required'],
        ]);*/


        foreach ($request->data as $data) {
            # code...
            $medicament = Medicament::create($data);
        }


       /*return redirect()
                ->route('medicament_edit', $medicament->id)
                ->with('success', __('global.create_succees'));*/
    }

    /*
     * Display the specified resource.
     */

    public function show($id)
    {
        $object = Medicament::findOrFail($id);

        return view('medicament.show',compact('object'));
        // return $this->edit($id);
    }

    public function edit($id)
    {
        $medicament = Medicament::findOrFail($id);

        return view('medicament.update', [
            'object'=>$medicament,
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

        $medicament = Medicament::findOrFail($id);

        $medicament->update($validated);

        return redirect()
                ->route('medicament_edit', $medicament->id)
                ->with('success', __('global.edit_succees'));
    }

    /*
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $msg = 'delete_error';
        $flash_type = 'error';
        $medicament = Medicament::findOrFail($id);

        if( $medicament->delete() ){
            $flash_type = 'success';
            $msg = 'delete_succees';
        }

        return redirect()
            ->route('medicament')
            ->with($flash_type, __('global.'.$msg));
    }
}