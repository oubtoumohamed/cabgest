@extends('layouts.app')

@section('content')
  {!! 
    main_list([
      'title'=>true,
      'data'=>$results,
      'module'=>'leave',
      'fields'=>[
        'user_id' => [
          'type' => 'select',
          'data' => [],
          'table' => 'users',
          'fields' => ['id as key_','firstname as value_'],
          'where' => [],
          'attributes' => 'id="users_select"',
        ],
        'from'=>[
          'type'=>'datepicker',
        ],
        'to'=>[
          'type'=>'datepicker',
        ],
        'days'=>[
          'type'=>'number',
        ],
        'state'=>[
          'type' => 'select',
          'data' => [
            'pendding' => __('leave.pendding'),
            'validate' => __('leave.validate'),
            'canceled' => __('leave.canceled'),
          ],
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
    <link href="{{ asset('assets/css/selectize.css') }}?v=1" rel="stylesheet" type="text/css" />
@endsection

@section('js')
<script src="{{ asset('assets/js/selectize.js') }}"></script>
<script>
  $(document).ready(async function(){
    //$("select#groupe").selectize();
    await loadSelect({
        load: false,
        link: "{{ route('user') }}",
        selector: "select#users_select",
        fieldVal: "id",
        fieldText: "firstname,lastename",
        fieldLabel: "text",
    });
  });
</script>
@endsection