@extends('layouts.app')

@section('content')
  {!! 
    main_list([
      'title'=>true,
      'data'=>$results,
      'module'=>'motif',
      'fields'=>[
        'reference'=>[
          'type'=>'text',
        ],
        'nom'=>[
          'type'=>'text',
        ]
      ],
    ]);

  !!}
@endsection