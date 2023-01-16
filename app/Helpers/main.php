<?php


function title()
{
    return '';

    $controller = Request::route()->controller;
    $model = $controller->model;
    if ($model) {
        $currentAction = Request::route()->action['as'];
        return ucfirst(__($controller->model . '.' . $currentAction));
    }

    return '';
}

function user()
{
    return auth()->user();
}


function isGranted($role)
{
    return auth()->user()->isGranted($role);
}

/*function list_actions($object)
{

    $class = get_class($object);
    $path = explode('\\', $class);
    $object_class = array_pop($path);

    $_class_upper = strtoupper($object_class);
    $_class_lower = strtolower($object_class);

    $html = '';

    if (method_exists($object, 'list_actions')) {
        $html .= $object->list_actions();
    }

    // if( isGranted('ROLE_'.$_class_upper.'_SHOW') )
    //  $html .= '<a href="'.route($_class_lower.'_show',$object->id).'" class="icon pl-3"><i class="fa fa-eye"></i></a>';

    if (isGranted($_class_lower))
        $html .= '<a href="' . route($_class_lower . '_edit', $object->id) . '" class="btn btn-sm btn-outline-success"><i class="fa fa-edit"></i></a>';

    if (isGranted($_class_lower))
        $html .= '<a href="' . route($_class_lower . '_delete', $object->id) . '"  type="button" data-toggle="modal" data-target="#confirmdelete" class="delete_btn btn btn-sm btn-outline-danger ms-2"><i class="fa fa-trash"></i></a>';

    return $html;
}*/


function update_actions($object = null)
{


    $html = '<button type="submit" id="save_btn" class="btn me-2 btn-success"> <i class="bx bx-send"></i>&nbsp; ' . __('global.submit') . '</button>';

    $_class_lower = null;

    if ($object) {

        $class = get_class($object);
        $path = explode('\\', $class);
        $object_class = array_pop($path);

        $_class_upper = strtoupper($object_class);
        $_class_lower = strtolower($object_class);
        if ($object->id and isGranted($_class_lower))
            $html .= '<a id="create_btn" class="btn me-2 btn-primary" href="' . route(strtolower($object_class) . '_create') . '"> <i class="bx bxs-plus-square"></i>&nbsp; ' . __('global.add') . '</a>';

        if ($object->id and isGranted($_class_lower))
            $html .= '<a href="' . route(strtolower($object_class) . '_delete', $object->id) . '" type="button" data-toggle="modal" data-target="#confirmdelete" class="btn me-2 btn-danger delete_btn delete_from_show"> <i class="bx bxs-trash"></i>&nbsp; ' . __('global.delete') . '</a>';
    }

    if ($_class_lower and isGranted($_class_lower))
        $html .= '<a id="list_btn" class="btn btn-outline-secondary me-2" href="' . route(strtolower($object_class)) . '"> <i class=" bx bxs-share "></i>&nbsp; ' . __('global.cancel') . '</a>';

    return $html;
}

function base_list($results)
{

    $controller = Request::route()->controller;
    $f = $controller->filter();

    $fields = $f->fields;
    $filter = $f->filter;
    $model = $f->model;

    $html = '
    <div id="kt_content_container" class="container-fluid">
        <!--begin::Card-->
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">
                <!--begin::Card title-->
                <div class="card-title">
                    ' . __(strtolower($model) . '.list_') . '
                    <!--begin::Search-->
                    <!--div class="d-flex align-items-center position-relative my-1">
                        <input type="text" data-kt-user-table-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Search user">
                    </div-->
                    <!--end::Search-->
                </div>
                <!--begin::Card title-->
                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    
                    <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                        <a class="btn btn-primary" href="' . route(strtolower($model) . "_create") . '"><i class="fa fa-plus"></i>&nbsp;' . __('global.add') . '</a>
                    </div>
                    
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->

            <div class="card-body pt-0">
                <!--begin::Table-->
                <div id="kt_table_users_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer" id="kt_table_users" role="grid">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0" role="row">
                                    <th class="w-10px pe-2 sorting_disabled" rowspan="1" colspan="1" style="width: 29.25px;" aria-label="">
                                        <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                            <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_table_users .form-check-input" value="1">
                                        </div>
                                    </th>';
    foreach ($fields as $key => $value) {
        $html .= '<th class="text-center">' . __($model . '.' . $key) . '</th>';
    }
    $html .= '
                                    <th>' . __('global.actions') . '</th>
                                </tr>';
    //$html .= $filter;

    $html .= '</thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="text-gray-600 fw-bold">';

    foreach ($results as $object) {
        $html .= '<tr>';
        $html .= '<td>';
        $html .= '<label class="form-check form-check-sm form-check-custom form-check-solid" for="idx' . $object->id . '">';
        $html .= '<input type="checkbox" class="form-check-input" name="idx[]" value="' . $object->id . '" id="idx' . $object->id . '">';
        $html .= '</label>';
        $html .= '</td>';
        foreach ($fields as $key => $value) {
            $geter = 'get' . $key;
            $html .= '<td class="td-' . $key . '">' . $object->$geter() . '</td>';
        }

        $html .= '<td class="text-center table-action">';
        $html .= list_actions($object);
        $html .= '</td>';
        $html .= '</tr>';
    }

    $html .= '</tbody>
                            <!--end::Table body-->
                        </table>
                    </div>
                    <div class="row">' . $results->links() . '</div>
                </div>
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
    ';


    /*$html .= '<div class="card-header card-footer">';
            $html .= '<div class="row"><div class="col-md-6">';
                $html .= '<select class="per-page w-9 custom-select" id="perpage">';

                    $pages__ = [16,32,64,128,192];
                    $currnt_page__ = $controller->perpage();
                    $url__ = $controller->url_params(true,['perpage'=>'mypagenull']);

                    foreach ($pages__ as $perpage) {
                        $selected = ( $perpage == $currnt_page__ ) ? 'selected="selected"' : '';

                        $html .= '<option '.$selected.' value="'.str_replace('mypagenull', $perpage, $url__).'">'.$perpage.'</option> ';
                    }
                $html .= '</select>';

                if($results) 
                    $html .=  __('global.pages_list',[
                      'current'=> $results->currentPage(),
                      'length'=> $results->lastPage(),
                      'total'=> $results->total(),
                      'module'=>__($model.'.'.$model)
                    ]);
            $html .= '</div>';
            $html .= '<div class="col-md-6">';
                $html .= $results->links();
            $html .= '</div></div>';
        $html .= '</div>';
    $html .= '</div>';*/

    echo $html;
}


/*================================================================================================================*/


function filter_form($options)
{

    $default_filter_options = [
        'text' => [
            'name' => '',
            'td-class' => 'w-auto',
            'operation' => 'like',
            'type' => '',
            'value' => '',
            'attributes' => 'class="input_filter_val"',
        ],
        'hidden' => [
            'name' => '',
            'td-class' => 'w-auto',
            'operation' => 'like',
            'type' => '',
            'value' => '',
            'attributes' => 'class="input_filter_val"',
        ],
        'datepicker' => [
            'name' => '',
            'td-class' => 'w-auto',
            'operation' => 'date-like',
            'type' => '',
            'value' => '',
            'attributes' => ' class="datepicker"',
        ],
        'datetimepicker' => [
            'name' => '',
            'td-class' => 'w-auto',
            'operation' => 'date-time-like',
            'type' => '',
            'value' => '',
            'attributes' => ' class="datetimepicker"',
        ],
        'timepicker' => [
            'name' => '',
            'td-class' => 'w-auto',
            'operation' => 'time-like',
            'type' => '',
            'value' => '',
            'attributes' => ' class="timepicker"',
        ],
        'number' => [
            'name' => '',
            'td-class' => 'w-auto',
            'operation' => '=',
            'type' => '',
            'value' => '',
            'attributes' => 'class="input_filter_val"',
        ],
        'email' => [
            'name' => '',
            'td-class' => 'w-auto',
            'operation' => 'like',
            'type' => '',
            'value' => '',
            'attributes' => 'class="input_filter_val"',
        ],
        'select' => [
            'name' => '',
            'td-class' => 'w-auto',
            'operation' => '=',
            'type' => '',
            'value' => '',
            'attributes' => '',
            'classes' => 'form-control p-1',
            'data' => [],
            'optgroup'=>false,
            'groupby' => 'id',
            'distinct' => '',
            'one_empty' => 1,
            'table' => 'groupes',
            'join' => [],
            'fields' => ['id as key_','name as value_'],
            'where' => [],
            'whereIn' => [],
        ],
    ];
    $filter = request('filter');

    $fields = [];
    $html = '';

    $html .= '<form action="#" method="GET" role="form" id="filterForm">';
    $html .= '<tr class="custom_filter">';
      $html .= '<th id="icon-filter" style="vertical-align: middle;"><i class="fa fa-filter" aria-hidden="true"></i></th>';

    foreach ($options as $name=>$args) {
        if($args == null){
            $html .= '<th id="filter-'.$name.'" class="w-0"></th>';
        }else{

            $type = $args['type'];

            if(!isset($args['value']) ){
                if( $filter != null && array_key_exists($name,$filter) )
                    $args['value'] = $filter[$name]["value"];
                else
                    $args['value'] = null;
            }

            $field = array_merge($default_filter_options[$type], $args);
            
            $html .= '<th id="filter-'.$name.'" class="'.$field['td-class'].'">';
          
                $html .= '<input class="form-control p-1" type="hidden" name="filter['.$name.'][operation]" value="'.$field['operation'].'" >';

                switch ($type) {
                    case 'select':
                        $html .= '<select class="'.$field['classes'].'" id="'.$name.'" name="filter['.$name.'][value]" '.$field['attributes'].' >';

                        if( $field['one_empty'] )
                            $html .= '<option value=""></option>';

                        if( count($field['data']) ){

                            foreach ( $field['data'] as $key => $value) {
                                $selected = '';
                                if( isset($field['value']) and $field['value'] == $key)
                                    $selected = 'selected="selected"';

                                $html .= '<option '.$selected.' value="'.$key.'">'.$value.'</option>';
                            }
                        }
                        elseif($field['table']){

                            /*$data = DB::table($field['table'])
                                    ->select($field['fields']);
                            if ($field['join']) {
                                $data = $data->join($field['join'][0],$field['join'][1],'=',$field['join'][2]);
                            }
                            if ($field['distinct']) {
                                $data = $data->distinct($field['distinct']);
                            }
                            if( $field['whereIn'] ){
                                $data = $data->whereIn( 
                                    $field['whereIn'][0],
                                    $field['whereIn'][1] 
                                );
                            }
                            $data = $data->where( $field['where'] )->get();

                            // $data = \DB::table($field['table'])
                            //      ->select(\DB::raw("CONCAT(firstname,lastname) as value_"))
                            //      //->where( $field['where'] )
                            //      ->Where(\DB::raw("CONCAT(firstname,lastname) as value_"), 'LIKE', "%"."stag"."%")
                            //      ->get();

                            foreach ( $data as $d) {
                                $selected = '';
                                if( isset($field['value']) and $field['value'] == $d->key_)
                                    $selected = 'selected="selected"';

                                $html .= '<option '.$selected.' value="'.$d->key_.'">'.$d->value_.'</option>';
                            }*/
                        }

                        $html .= '</select>';
                        break;

                    case 'datepicker':
                        $html .= '<input class="form-control p-1 w-auto input_filter_val date" type="text" name="filter['.$name.'][value]" '.$field['attributes'].' value="'.$field['value'].'" style="text-align:center;">';
                        break;
                    case 'datetimepicker':
                        $html .= '<input class="form-control p-1 w-auto input_filter_val datetime" type="text" name="filter['.$name.'][value]" '.$field['attributes'].' value="'.$field['value'].'" style="text-align:center;">';
                        break;
                    case 'timepicker':
                        $html .= '<input class="form-control p-1 w-auto input_filter_val time" type="text" name="filter['.$name.'][value]" '.$field['attributes'].' value="'.$field['value'].'" style="text-align:center;">';
                        break;
                    case 'number':
                        $html .= '<input class="form-control p-1" type="'.$type.'" step="0.01"  name="filter['.$name.'][value]" '.$field['attributes'].' value="'.$field['value'].'" >';
                        break;
                        

                    default:
                        $html .= '<input class="form-control p-1" type="'.$type.'"  name="filter['.$name.'][value]" '.$field['attributes'].' value="'.$field['value'].'" >';
                        break;
                }

            $html .= '</th>';
        }
    }


    $html .= '<th class="button_actions text-center mt-0 p-0" style="width: 100px;vertical-align: middle;">';
        $html .= '<input class="form-control p-1" type="hidden" name="page" id="page" value="'.request('page').'">';
        $html .= '<input class="form-control p-1" type="hidden" name="perpage" id="perpage" value="'.request('perpage').'">';
        $html .= '<button type="submit" class="btn btn-success btn-sm submit_filter">';
          $html .= '<i class="bx bx-search-alt" aria-hidden="true"></i>';
        $html .= '</button>&nbsp;&nbsp;';
        $html .= '<a class="btn btn-danger btn-soft-danger btn-sm remove_filter" href="?filters=reset">';
          $html .= '<i class="bx bxs-x-circle" aria-hidden="true"></i>';
        $html .= '</a>';
    $html .= '</th>';
    $html .= '</tr>';
    $html .= '</form>';

    return $html;
}

function list_actions($module, $object)
{

    $_class_upper = strtoupper($module);
    $_class_lower = strtolower($module);

    $html = '';

    if (method_exists($object, 'list_actions')) {
        $html .= $object->list_actions();
    }

    if ( isGranted($_class_upper.'_SHOW') )
        $html .= '<li class="list-inline-item"><a href="' . route($_class_lower . '_show', $object->id) . '" class="text-primary d-inline-block""><i class="bx bxs-show fs-18"></i></a></li>';

    if ( isGranted($_class_upper.'_EDIT') )
        $html .= '<li class="list-inline-item"><a href="' . route($_class_lower . '_edit', $object->id) . '" class="text-success d-inline-block edit-item-btn"><i class="bx bxs-spreadsheet fs-18"></i></a></li>';

    if ( isGranted($_class_upper.'_DELETE') ) //&& Route::has('') )
        $html .= '<li class="list-inline-item"><a href="' . route($_class_lower . '_delete', $object->id) . '"  type="button" data-toggle="modal" data-target="#confirmdelete" class="delete_btn text-danger d-inline-block remove-item-btn delete_from_list"><i class="bx bxs-trash fs-18"></i></a></li>';

    return $html;
}

function main_list($cfg)
{
    $html = '';

    if( $cfg['title'] == true )
    $html .= '
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">' . __(strtolower($cfg['module']) . '.module_name') . '</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="">' . __(strtolower($cfg['module']) . '.module_name') . '</a></li>
                        <li class="breadcrumb-item active">' . __(strtolower($cfg['module']) . '.list') . '</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->';

    $html .= '
    <div class="row rowlist">
        <div class="col-lg-12">

            '. showalerts() .'

            <div class="card" id="'.$cfg['module'].'List">
                <div class="card-header  border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">' . __(strtolower($cfg['module']) . '.list') . '</h5>
                        <div class="flex-shrink-0">
                            <a class="btn btn-info" href="' . route(strtolower($cfg['module']) . "_create") . '"><i class="bx bxs-plus-square"></i>&nbsp;&nbsp;' . __('global.add') . '</a>
                        </div>
                    </div>
                </div>
                <div class="card-body mt-3 pt-0 border border-dashed border-end-0 border-start-0">
                    <div class="table-responsive table-card mb-1">
                        <table class="table table-nowrap align-middle border" id="'.$cfg['module'].'Table">
                            <thead class="text-muted table-light">
                                <tr class="text-uppercase">
                                    <th scope="col" style="width: 25px;">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="checkAll" value="option">
                                        </div>
                                    </th>';

                                    foreach ($cfg['fields'] as $key => $value) {
                                        $html .= '<th class="text-center">' . __( $cfg['module'] . '.' . $key) . '</th>';
                                    }

                                    $html .= '<th>' . __('global.actions') . '</th>
                                </tr>
                                '. filter_form($cfg['fields']) .'
                            </thead>
                            <tbody class="list form-check-all">';

                            foreach ($cfg['data'] as $object) {
                                $html .= '<tr>';
                                $html .= '<th scope="row">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="checkAll" value="' . $object->id . '">
                                        </div>
                                    </th>';
                                foreach ($cfg['fields'] as $key => $value) {
                                    $geter = 'get' . $key;
                                    $html .= '<td class="td-' . $key . '">' . $object->$geter() . '</td>';
                                }

                                $html .= '<td class="text-center table-action">';
                                $html .= '<ul class="list-inline mb-0">'.list_actions($cfg['module'] , $object).'</ul>';
                                $html .= '</td>';
                                $html .= '</tr>';
                            }

                            $html .= '
                            </tbody>
                        </table>';
                        if( !$cfg['data']->count() ){

                             $html .='<div class="noresult m-5">
                                <div class="text-center">
                                    <i class="ri-search-eye-line fs-48 text-muted"></i>
                                    <h4 class="mt-2">'.__('global.empty_list').'</h4>
                                    <p class="text-muted">'.__('global.empty_list_text').'</p>
                                </div>
                            </div>';
                        }
                    $html .='</div>
                </div>';
            $html .= '<div class="card-footer">';
                    $html .= '<div class="row"><div class="col-md-6">';

                        if($cfg['data']) 
                            $html .=  __('global.pages_list',[
                              'current'=> $cfg['data']->currentPage(),
                              'length'=> $cfg['data']->lastPage(),
                              'total'=> $cfg['data']->total(),
                              'module'=>__($cfg['module'].'.'.$cfg['module'])
                            ]);
                    $html .= '</div>';
                    $html .= '<div class="col-md-6 d-flex justify-content-end">';
                        $html .= $cfg['data']->links("pagination::bootstrap-4");
                    $html .= '</div></div>';
                $html .= '</div>';
            $html .= '</div>
            </div>
        </div>
    </div>
    ';

    return $html;

}


function showalerts(){

    $html = '<div id="alerts">';

    if ( $message = Session::get('success') ){
        $html .= '<div class="alert alert-success alert-dismissible alert-label-icon label-arrow shadow fade show" role="alert">
            <i class="ri-check-double-line label-icon"></i><strong>'. $message .'</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }

    if ( $message = Session::get('error') ){
        $html .= '<div class="alert alert-danger alert-dismissible alert-label-icon label-arrow shadow fade show" role="alert">
            <i class="ri-error-warning-line label-icon"></i><strong>'.$message.'</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }

    if($message = Session::get('warning')){
        $html .= '<div class="alert alert-warning alert-dismissible alert-label-icon label-arrow shadow fade show" role="alert">
            <i class="ri-alert-line label-icon"></i><strong>'.$message.'</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }

    if($message = Session::get('info')){
        $html .= '<div class="alert alert-info alert-dismissible alert-label-icon label-arrow shadow fade show" role="alert">
            <i class="ri-airplay-line label-icon"></i><strong>'.$message.'</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }

    if( Session::get('errors') ){
        foreach ( Session::get('errors')->all() as $error){
            $html .= '<div class="alert alert-danger alert-dismissible alert-label-icon label-arrow shadow fade show" role="alert">
                <i class="ri-error-warning-line label-icon"></i><strong>'. $error .'</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
    }

    return $html .'</div>';
}



/*
=============
*/


function dateFormat($date, $format = 'Y-m-d'){
    try{
        $dt = date_create($date);
        return date_format($dt, $format);
    }catch(\Exception $e){
        return $date;
    }
}

function dateTimeFormat($date, $format = 'Y-m-d H:i:s'){
    return dateFormat($date, $format);
}

function numberFormat($number, $decimale = 2 ){
    $number = number_format($number, $decimale, '.', '');
    return floatval($number);
}


/* Number To Words Function  */
function subNumberToWords($number) {
    $decimal = round($number - ($no = floor($number)), 2) * 100;
    $hundred = null;
    $digits_length = strlen($no);
    $i = 0;
    $str = array();
    $words = array(         
        0   => '',
        1   => 'Un',
        2   => 'Deux',
        3   => 'Trois',
        4   => 'Quatre',
        5   => 'Cinq',
        6   => 'Six',
        7   => 'Sept',
        8   => 'Huit',
        9   => 'Neuf',
        10  => 'Dix',
        11  => 'Onze',
        12  => 'Douze',
        13  => 'Treize',
        14  => 'Quatorze',
        15  => 'Quinze',
        16  => 'Seize',
        17  => 'Dix-sept',
        18  => 'Dix-huit',
        19  => 'Dix-neuf',
        20  => 'Vingt',
        30  => 'Trente',
        40  => 'Quarante',
        50  => 'Cinquante',
        60  => 'Soixante',
        70  => 'Soixante-dix',
        80  => 'Quatre-vingt',
        90  => 'Quatre-vingt-dix',
    );

    $digits = array('', 'Cent','Mille','Lakhs', 'Crores');

    while( $i < $digits_length ) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? '' : null;
            $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
        } else $str[] = null;
    }
    $Rupees = implode('', array_reverse($str));
    return $Rupees;
}

/* Number To Words Function  */
function numberToWords($number) {

    $Rupees = '';

    if( $number < 0 ){
        $number *= -1;
        $Rupees .= "Moins ";
    }

    $decimal = round($number - ($no = floor($number)), 2) * 100;

    $Rupees .= subNumberToWords($number);
    $paise = '';

    if( $decimal > 0 ){
        $paise = ' et '. subNumberToWords($decimal). 'centimes';
    }

    $Rupees .= ' Dirhams' . $paise;

    $Rupees = str_replace('Un Mille', 'Mille', $Rupees);
    $Rupees = str_replace('Un Cent', 'Cent', $Rupees);
    $Rupees = preg_replace('/\s+/', ' ',$Rupees);

    return $Rupees;
}

function villes(){
    return [
        'Al Hajeb' =>  'Al Hajeb',
        'Agadir' =>  'Agadir',
        'Al Hoceima' =>  'Al Hoceima',
        'Al Aaroui' =>  'Al Aaroui',
        'Assa Zag' =>  'Assa Zag',
        'Azilal ' =>  'Azilal ',
        'Ain Taoujtate' =>  'Ain Taoujtate',
        'Arfoud' =>  'Arfoud',
        'Asilah' =>  'Asilah',
        'Beni Mellal' =>  'Beni Mellal',
        'Ben Slimane' =>  'Ben Slimane',
        'Boujdour' =>  'Boujdour',
        'Boulemane' =>  'Boulemane',
        'Berrechid' =>  'Berrechid',
        'Berkane' =>  'Berkane',
        'Bouarfa' =>  'Bouarfa',
        'Bou-craa' =>  'Bou-craa',
        'Bouknadel' =>  'Bouknadel',
        'Boulemane' =>  'Boulemane',
        'Bouskoura' =>  'Bouskoura',
        'Bouznika' =>  'Bouznika',
        'Casablanca' =>  'Casablanca',
        'Chefchaouen' =>  'Chefchaouen',
        'Chtouka Ait Baha' =>  'Chtouka Ait Baha',
        'Chichaoua' =>  'Chichaoua',
        'El Hajeb' =>  'El Hajeb',
        'El Jadida' =>  'El Jadida',
        'El Kelaa Des Sraghnas' =>  'El Kelaa Des Sraghnas',
        'Errachidia' =>  'Errachidia',
        'Essaouira' =>  'Essaouira',
        'Es Semara' =>  'Es Semara',
        'Fes' =>  'Fes',
        'Figuig' =>  'Figuig',
        'Fnideq' =>  'Fnideq',
        'Fquih Ben Salah' =>  'Fquih Ben Salah',
        'Er-rich' =>  'Er-rich',
        'Guelmim' =>  'Guelmim',
        'Guira' =>  'Guira',
        'Ifrane' =>  'Ifrane',
        'Imilchil' =>  'Imilchil',
        'Imouzzer' =>  'Imouzzer',
        'Inezgane' =>  'Inezgane',
        'Jerada' =>  'Jerada',
        'Jorf' =>  'Jorf',
        'Kenitra' =>  'Kenitra',
        'Khemisset' =>  'Khemisset',
        'Khenifra' =>  'Khenifra',
        'Khemis Zemamra' =>  'Khemis Zemamra',
        'Khouribga' =>  'Khouribga',
        'Ksar El-kébir' =>  'Ksar El-kébir',
        'Laayoune' =>  'Laayoune',
        'Larache' =>  'Larache',
        'Lagouira' =>  'Lagouira',
        'Lqliâa' =>  'Lqliâa',
        'Mohammedia' =>  'Mohammedia',
        'Marrakech' =>  'Marrakech',
        'Meknes' =>  'Meknes',
        'Martil' =>  'Martil',
        'M\'diq' =>  'M\'diq',
        'Mediouna' =>  'Mediouna',
        'Mehdia' =>  'Mehdia',
        'Midelt' =>  'Midelt',
        'M\'rirt' =>  'M\'rirt',
        'Moulay Bousselham' =>  'Moulay Bousselham',
        'Nador' =>  'Nador',
        'Ouarzazate' =>  'Ouarzazate',
        'Oujda' =>  'Oujda',
        'Oued Eddahab' =>  'Oued Eddahab',
        'Oualidia' =>  'Oualidia',
        'Ouezzane' =>  'Ouezzane',
        'Oukaimeden' =>  'Oukaimeden',
        'Rabat' =>  'Rabat',
        'Ras El Ma' =>  'Ras El Ma',
        'Ribate El Kheir' =>  'Ribate El Kheir',
        'Rissani' =>  'Rissani',
        'Sale' =>  'Sale',
        'Skhirat' =>  'Skhirat',
        'Sabaa Aiyoun' =>  'Sabaa Aiyoun',
        'Saidia' =>  'Saidia',
        'Sefrou' =>  'Sefrou',
        'Settat' =>  'Settat',
        'Sidi Kacem' =>  'Sidi Kacem',
        'Sidi Rahhal' =>  'Sidi Rahhal',
        'Sidi Slimane' =>  'Sidi Slimane',
        'Sidi Yahya El Gharb' =>  'Sidi Yahya El Gharb',
        'Smara' =>  'Smara',
        'Temara' =>  'Temara',
        'Sefrou' =>  'Sefrou',
        'Safi' =>  'Safi',
        'Settat' =>  'Settat',
        'Sidi Kacem' =>  'Sidi Kacem',
        'Tanger' =>  'Tanger',
        'Tan-tan' =>  'Tan-tan',
        'Taounat' =>  'Taounat',
        'Taroudannt' =>  'Taroudannt',
        'Tata' =>  'Tata',
        'Taza' =>  'Taza',
        'Tetouan' =>  'Tetouan',
        'Tiznit' =>  'Tiznit',
        'Tahannaout' =>  'Tahannaout',
        'Taourirte' =>  'Taourirte',
        'Tarfaya' =>  'Tarfaya',
        'Tifelt' =>  'Tifelt',
        'Tinghir' =>  'Tinghir',
        'Tiznit' =>  'Tiznit',
        'Youssoufia' =>  'Youssoufia',
        'Zagora' =>  'Zagora',
        'Zaio' => 'Zaio'
    ];
}