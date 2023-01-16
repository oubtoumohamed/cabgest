@extends('layouts.app')

@section('content')
  {!! 
    main_list([
      'title'=>true,
      'data'=>$results,
      'module'=>'groupe',
      'fields'=>[
        'name'=>[
          'type'=>'text',
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