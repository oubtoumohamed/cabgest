<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class LarabaseController extends Controller
{
    public function create()
    {
        return view('larabase.creator.update');
    }

    public function store(Request $rqst)
    {        
        $this->validate(request(), [
            'name' => 'required|string',
        ]);

        $module = new Creator();
        $module->name = $rqst->name;
        $module->description = $rqst->description;
        $module->fields = $rqst->fields;
        $module->make();

        return redirect()->back();
    }



    public function translator_create(Request $rqst, $lang='', $module='')
    {
        $translator = new Translator($lang, $module);
        $translator->make();

        return $this->view_('larabase.translator.update',[
            'data'=>$translator->data,
            'modules'=>$translator->modules,
            'lang'=>$translator->lang,
            'module'=>$translator->module,
        ]);
    }


    public function translator_store()
    {

        $lang = request('lang');
        $module = request('module');
        $trans = request('trans');
        $fields = request('fields');

        if( $lang and $module and count($trans) ){

            $translator = new Translator($lang, $module, $trans, $fields);
            $translator->save();

        }

        return redirect()
                ->route('translator_create', [$lang, $module] )
                ->with('success', __('global.create_succees'));

    }


}


class Translator
{
    public $path;
    public $lang;
    public $module;
    public $modules;
    public $data;

    public $trans;
    public $fields;

    public function __construct($lng, $mdl, $trns=null, $flds=null)
    {
        $this->lang = $lng;
        $this->module = $mdl;
        $this->path = base_path().'/resources/lang';


        $this->trans = $trns;
        $this->fields = $flds;
    }

    public function save()
    {
        $fullpath = $this->path.'/'.$this->lang.'/'.$this->module.'.php';
        $contents = "<?php \n\nreturn [ \n";

        foreach ($this->trans as $key => $value) {
            $contents .= '    "'.$key.'"=>"'.$value.'",'."\n";
        }

        if( $this->fields ){
            foreach ($this->fields as $k => $v) {
                $contents .= '"' .$v['key'].'"   =>  "'.$v['value'].'",'."\n";
            }
        }

        $contents .= "];";

        File::put($fullpath, $contents);
    }

    public function make()
    {
        $this->data = [];

        if (isset( $this->lang )){
            $this->scan_path($this->lang);
            $this->modules[] = '-----------------';
        }
        
        $this->scan_path('en');

        if( $this->lang && $this->module ){
            $data = $this->get_file_data( $this->lang , $this->module );
            $sourcedata = $this->get_file_data( 'en' , $this->module );

            foreach ($sourcedata as $key => $value) {
                if( !array_key_exists($key, $data) )
                    $data[ $key ] = $value;
            }
        }

        $this->data = $data;
    }


    public function scan_path($lng){
        foreach ( scandir($this->path.'/'.$lng) as $mdl) {
            if( $mdl != '.' && $mdl != '..'  ){
                $mdl =  str_replace('.php', '', $mdl);
                $this->modules[ $mdl ] = $mdl;
            }
        }

        return $this->modules;
    }

    public function get_file_data($lng, $mdl){
        $fullpath = $this->path.'/'.$lng.'/'.$mdl.'.php';
        $this->data = [];
        if( file_exists($fullpath) ) {
            $contents = File::get($fullpath);

            $contents = str_replace("<?php", '', $contents);
            $contents = str_replace('return ', '$this->data = ', $contents);

            eval($contents);
        }

        return $this->data;
    }

}



class Creator
{
    public $name;
    public $description;
    public $fields;
    
    public $translation = "";
    public $migration = "";
    public $module = "";
    public $controller = "";
    public $route = "";
    public $views = "";

    public function template($part){
        return File::get( base_path().'/resources/views/larabase/creator/templates/'.$part );
    }

    public function make(){
        $controllerFile = $this->template('controller.php');
        $migrationFile  = $this->template('migration.php');
        $moduleFile     = $this->template('module.php');
        $routeFile      = $this->template('route.php');
        
        $listview       = $this->template('views/list.blade.php');
        $updateview     = $this->template('views/update.blade.php');

        if( !$migrationFile || !$moduleFile || !$routeFile || !$controllerFile || !$listview || !$updateview )
            return false;

        $translate__ = "<?php \nreturn [\n";
        $translate__ .= "    'module_name'  => '".ucfirst($this->name)."',\n";
        $translate__ .= "    'list_'  => 'List of ".ucfirst($this->name)."s',\n";
        $translate__ .= "    '".$this->name."'  => '".ucfirst($this->name)."',\n";
        $translate__ .= "    '".$this->name."_create'  => 'Add ".ucfirst($this->name)."',\n";
        $translate__ .= "    '".$this->name."_edit'  => 'Edit ".ucfirst($this->name)."',\n";
        $translate__ .= "    '".$this->name."_show'  => 'Show ".ucfirst($this->name)."',\n";
        $translate__ .= "    'description_'  => '".$this->description."',\n\n\n";

        $mgr_flds__ = '';

        $mdl_flds__ = '';
        $mdl_getters__ = '';

        $cntrl_creation_fields__ = '';
        $cntrl_update_fields__ = '';
        $cntrl_filter_fields__ = '';
        $view_update_fields__ = '';

        $view_list_header_fields__ = '';
        $view_list_filter_fields__ = '';
        $view_list_looper_fields__ = '';

        foreach ($this->fields as $field) {
            $field = (object) $field;


            // Translate field
            $translate__ .= "    '".$field->name."'  => '".$field->title."',\n";


            // Migration field
            $mgr_flds__ .= '            $table->'.$field->type.'(\''.$field->name.'\')'.( isset($field->nullable) ? '->nullable()' : '' )."; \n";


            // Module field
            $mdl_flds__ .= '\''. $field->name .'\',';
            $mdl_getters__ .= "\n    public function get".$field->name.'(){ return $this->'.$field->name.'; }';


            // Controller field
            $cntrl_filter_fields__ .= "            '". $field->name ."'=>[ 'type'=>'text' ],\n";
            $cntrl_creation_fields__ .= "            '". $field->name ."'=>request('". $field->name ."'),\n";
            $cntrl_update_fields__ .= '        $'.$this->name.'->'. $field->name ."=request('". $field->name ."');\n";

            // List view fields
            $view_list_header_fields__ .= '                <th>{{ __("'.$this->name.'.'.$field->name.'") }}</th>'."\n";
            $view_list_filter_fields__ .= '                <th><input type="text" class="form-control p-1 rounded-0" name="filter['.$field->name.'][value]"></th>'."\n";
            $view_list_looper_fields__ .= '                <td>{{ $object->'. $field->name .' }}</td>'."\n";


            // Update view fields
            $view_update_fields__ .= "        <div class='mb-10 col-md-6'> \n";
            $view_update_fields__ .= "          <div class='fs-6 fw-bolder form-label mb-3'> \n";
            $view_update_fields__ .= "            <span class='".( isset($field->nullable) ? '' : 'required' )."'>{{ __('".$this->name.".".$field->name."') }}</span> \n";
            $view_update_fields__ .= "          </div> \n";
            $view_update_fields__ .= '          <input class="form-control form-control-solid rounded-0" id="'.$field->name.'" name="'.$field->name.'" value="@if($object->id){{ $object->'.$field->name.' }}@else{{ old("'.$field->name.'") }}@endif" type="text" '. ( isset($field->nullable) ? '' : 'required=""' ) ." > \n";
            $view_update_fields__ .= "        </div> \n";
        }

        // Create Translation File
        $translate__ .= "];";
        $this->translation = base_path().'/resources/lang/en/'.$this->name.'.php';
        File::put( $this->translation, $translate__ );


        // Create Migration File
        $migrationFile= str_replace('__ModuleName__', ucfirst($this->name), $migrationFile);
        $migrationFile= str_replace('__tableName__', $this->name.'s', $migrationFile);
        $migrationFile= str_replace('__tableColumns__', $mgr_flds__, $migrationFile);
        $this->migration = base_path().'/database/migrations/'.date('Y_m_d_His').'_create_'.$this->name.'s_table.php';
        File::put( $this->migration, $migrationFile );

        // Create Module File
        $moduleFile= str_replace('__ModuleName__', ucfirst($this->name), $moduleFile);
        $moduleFile= str_replace('__ModuleLower__', $this->name, $moduleFile);
        $moduleFile= str_replace('__FillableFields__', $mdl_flds__, $moduleFile);
        $moduleFile= str_replace('__Getters__', $mdl_getters__, $moduleFile);
        $this->module = base_path().'/app/'.ucfirst($this->name).'.php';
        File::put( $this->module, $moduleFile );

        // Create Controller File
        $controllerFile= str_replace('__Module__', ucfirst($this->name), $controllerFile);
        $controllerFile= str_replace('__ModuleLower__', $this->name, $controllerFile);
        $controllerFile= str_replace('__ModuleFilterField__', $cntrl_filter_fields__, $controllerFile);
        $controllerFile= str_replace('__ModuleCreationFields__', $cntrl_creation_fields__, $controllerFile);
        $controllerFile= str_replace('__ModuleUpdateFields__', $cntrl_update_fields__, $controllerFile);        
        $this->controller = base_path().'/app/Http/Controllers/'.ucfirst($this->name).'Controller.php';
        File::put( $this->controller, $controllerFile );

        // Create Route File
        $routeFile= str_replace('__ModuleController__', ucfirst($this->name), $routeFile);
        $routeFile= str_replace('__ModuleLower__', $this->name, $routeFile);
        $this->route = base_path().'/routes/'.$this->name.'.php';
        $webroute = File::get(  base_path().'/routes/web.php' );
        File::put( $this->route, $routeFile );
        File::put( base_path().'/routes/web.php', $webroute."\ninclude '".$this->name.".php';" );

        // Create Views Files

        $this->views = base_path().'/resources/views/'.$this->name.'/';     
        
        if( ! File::exists( $this->views ) )
            File::makeDirectory( $this->views );

        $updateview= str_replace('__ModuleLower__', $this->name, $updateview);
        $updateview= str_replace('__ModuleFields__', $view_update_fields__, $updateview);
        File::put( $this->views.'/update.blade.php', $updateview);

        $listview= str_replace('__ModuleLower__', $this->name, $listview);
        $listview= str_replace('__ModuleHeaderFields__', $view_list_header_fields__, $listview);
        $listview= str_replace('__ModuleFilterFields__', $view_list_filter_fields__, $listview);
        $listview= str_replace('__ModuleLooperFields__', $view_list_looper_fields__, $listview);
        File::put( $this->views.'/list.blade.php', $listview);

        return True;
    }

}
