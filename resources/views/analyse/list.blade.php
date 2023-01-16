@extends('layouts.app')

@section('content')
  {!! 
    main_list([
      'title'=>true,
      'data'=>$results,
      'module'=>'analyse',
      'fields'=>[
        'code'=>[
          'type'=>'text',
        ],
        'nom'=>[
          'type'=>'text',
        ]
      ],
    ]);

  !!}
@endsection