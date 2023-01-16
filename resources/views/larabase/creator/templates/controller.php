<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\__Module__;

class __Module__Controller extends Controller
{
    public $model = '__ModuleLower__';
    public function filter_fields(){
        return [
__ModuleFilterField__
        ];
    }

    public function __construct()
    {
        //$this->middleware('auth');

    }
    public function index()
    {
        $__ModuleLower__s = __Module__::where($this->filter(false))
                        ->orderBy($this->orderby, 'desc')->paginate($this->perpage())
                        ->withPath($this->url_params(true,['page'=>null]));

        return $this->view_('__ModuleLower__.list', [
            'results'=>$__ModuleLower__s
        ]);
    }

    /*
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->view_('__ModuleLower__.update',[
            'object'=> new __Module__(),
        ]);
    }

    /*
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //$this->validate(request(), [ ]);

        $__ModuleLower__ = __Module__::create([

__ModuleCreationFields__
        ]);

       return redirect()
                ->route('__ModuleLower___edit', $__ModuleLower__->id)
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
        $__ModuleLower__ = __Module__::findOrFail($id);

        return $this->view_('__ModuleLower__.update', [
            'object'=>$__ModuleLower__,
        ]);
    }

    /*
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //$this->validate(request(), [ ]);
      
        $__ModuleLower__ = __Module__::findOrFail($id);

__ModuleUpdateFields__
        $__ModuleLower__->save();

        return redirect()
                ->route('__ModuleLower___edit', $__ModuleLower__->id)
                ->with('success', __('global.edit_succees'));
    }

    /*
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $msg = 'delete_error';
        $flash_type = 'error';
        $__ModuleLower__ = __Module__::findOrFail($id);

        if( $__ModuleLower__->delete() ){
            $flash_type = 'success';
            $msg = 'delete_succees';
        }

        return redirect()
            ->route('__ModuleLower__')
            ->with($flash_type, __('global.'.$msg));
    }
}