@extends('layouts.app')

@section('content')
  {!! 
    main_list([
      'title'=>true,
      'data'=>$results,
      'module'=>'caisse',
      'fields'=>[
        'numero'=>[
          'type'=>'text',
        ],
        'nom'=>[
          'type'=>'text',
        ]
      ],
    ]);

  !!}
@endsection