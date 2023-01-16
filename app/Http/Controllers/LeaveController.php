<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use App\Models\Leave;

class LeaveController extends Controller
{

    public function __construct()
    {
        //$this->middleware('auth');

    }
    public function index()
    {
        $leaves = Leave::list();

        if( request('forAction') == 'loadSelect' )
            return response()->json( $leaves );

        return view('leave.list', [
            'results'=>$leaves
        ]);
    }

    /*
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('leave.update',[
            'object'=> new Leave(),
        ]);
    }

    /*
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
            'from'=>'required',
            'to'=>'required',
            'user_id'=>'required',
        ]);

        $date_debut = $request->from ? Date::createFromFormat('d-m-Y', $request->from) : Null;
        $date_fin = $request->to ? Date::createFromFormat('d-m-Y', $request->to) : Null;

        $date_count = $date_debut->diff($date_fin)->d;

        $leave = Leave::create([
            'from'=> $date_debut,
            'to'=> $date_fin,
            'days'=> $date_count+1,
            'user_id'=>request('user_id'),
            'notes'=>request('notes'),
            'state'=>request('state'),
            'comment'=>request('comment'),
        ]);

       return redirect()
                ->route('leave_edit', $leave->id)
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
        $leave = Leave::findOrFail($id);

        return view('leave.update', [
            'object'=>$leave,
        ]);
    }

    /*
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'from' => 'required',
            'to' => 'required',
            'user_id' => 'required',
        ]);

        $date_debut = $request->from ? Date::createFromFormat('d-m-Y', $request->from) : Null;
        $date_fin = $request->to ? Date::createFromFormat('d-m-Y', $request->to) : Null;

        $date_count = $date_debut->diff($date_fin)->d;
        
        $leave = Leave::findOrFail($id);


        $leave->from= $date_debut;
        $leave->to= $date_fin;
        $leave->days= $date_count+1;
        $leave->user_id=request('user_id');
        $leave->notes=request('notes');
        $leave->state=request('state');
        $leave->comment=request('comment');
        
        $leave->save();

        return redirect()
                ->route('leave_edit', $leave->id)
                ->with('success', __('global.edit_succees'));
    }

    /*
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $msg = 'delete_error';
        $flash_type = 'error';
        $leave = Leave::findOrFail($id);

        if( $leave->delete() ){
            $flash_type = 'success';
            $msg = 'delete_succees';
        }

        return redirect()
            ->route('leave')
            ->with($flash_type, __('global.'.$msg));
    }
}