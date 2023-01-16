@extends('layouts.app')

@section('content')
  {!! 
    main_list([
      'title'=>true,
      'data'=>$results,
      'module'=>'user',
      'fields'=>[
        'avatar'=>null,
        'firstname'=>[
          'type'=>'text',
        ],
        'lastename'=>[
          'type'=>'text',
        ],
        'username'=>[
          'type'=>'text',
        ],
        'role'=>[
          'type'=>'select',
          'data'=>[
            'EMPLOYE'=>'EMPLOYE',
            'ADMIN'=>'ADMIN',
          ]
          /*'table' => 'users',
          'distinct' => 'role',
          'fields' => ['role as key_','role as value_'],*/
        ],
        'email'=>[
          'type'=>'text',
        ],
        'phone'=>[
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