@extends('layouts.app')

@section('content')

  {!! 
    main_list([
      'title'=>true,
      'data'=>$results,
      'module'=>'dossier',
      'fields'=>[
        'numero'=>[
          'type'=>'text',
        ],
        'patient_id'=>[
          'type'=>'select',
          'table'=>'patients',
          'fields'=>['id as key_','nom as value_']
        ],
        'datetime'=>[
          'type'=>'datepicker',
        ],
        'motif_id'=>[
          'type'=>'select',
          'table'=>'motifs',
          'fields'=>['id as key_','nom as value_']
        ],
        'caisse_id'=>[
          'type'=>'select',
          'table'=>'caisses',
          'fields'=>['id as key_','nom as value_']
        ]
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
    applyDate("#dossierList .date");

    await loadSelect({
      load: false,
      link: "{{ route('patient_ajaxlist') }}",
      selector: "#dossierList select#patient_id",
      fieldVal: "id",
      fieldText: "nom,prenom",
      fieldLabel: "text",
    });

    await loadSelect({
      load: false,
      link: "{{ route('caisse_ajaxlist') }}",
      selector: "#dossierList select#caisse_id",
      fieldVal: "id",
      fieldText: "nom",
      fieldLabel: "text",
    });

    await loadSelect({
      load: false,
      link: "{{ route('motif_ajaxlist') }}",
      selector: "#dossierList select#motif_id",
      fieldVal: "id",
      fieldText: "nom",
      fieldLabel: "text",
    });

    //$("#dossierList select#caisse_id,#dossierList select#patient_id").selectize();
  });
</script>
@endsection