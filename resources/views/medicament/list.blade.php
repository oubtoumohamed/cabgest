@extends('layouts.app')

@section('content')
  {!! 
    main_list([
      'title'=>true,
      'data'=>$results,
      'module'=>'medicament',
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