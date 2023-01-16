@extends('layouts.app')

@section('content')

  {!! 
    main_list([
      'title'=>true,
      'data'=>$results,
      'module'=>'patient',
      'fields'=>[
        'numero'=>[
          'type'=>'text',
        ],
        'nom'=>[
          'type'=>'text',
        ],
        'prenom'=>[
          'type'=>'text',
        ],
        'date_naissance'=>[
          'type'=>'datepicker',
        ],
        'cin'=>[
          'type'=>'text',
        ],
        'tele'=>[
          'type'=>'number',
        ],
        'ville'=>[
          'type' => 'select',
          'data' => villes(),
        ],
        /*'groupes' => [
          'type' => 'select',
          'operation'=>null,
          'data' => [],
          'table' => 'groupes',
          'fields' => ['id as key_','name as value_'],
          'where' => [],
        ],*/
      ],
    ]);

  !!}
@endsection

@section('css')
    <link href="{{ asset('assets/css/datetimepicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/selectize.css') }}?v=1" rel="stylesheet" type="text/css" />
@endsection

@section('js')
<script src="{{ asset('assets/js/datetimepicker.js') }}"></script>
<script src="{{ asset('assets/js/selectize.js') }}"></script>
<script>
  $(document).ready(async function(){
    applyDate("#patientList .date");

    $("#patientList select#ville").selectize();
  });
</script>
@endsection