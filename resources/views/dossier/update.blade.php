@extends('layouts.app')

@section('content')

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">{{ __('dossier.module_name') }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="">{{ __('dossier.module_name') }}</a></li>
                        <li class="breadcrumb-item active">@if($object->id){{ __('dossier.edit') }}@else{{ __('dossier.create') }}@endif</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-md-8 m-auto">
            {!! showalerts() !!}
        </div>
    </div>

    <form method="POST" id="formdossier" enctype="multipart/form-data" action="@if($object->id){{ route('dossier_update',$object->id) }}@else{{ route('dossier_store') }}@endif">
        {{ csrf_field() }}
        <div class="row">
            
            <!-- Start card Patient -->
            <div class="col-md-8 m-auto">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">{{ __('dossier.infopatient') }}</h4>
                    </div><!-- end card header -->

                    <div class="card-body">

                        <div>
                            <p class="text-muted">{{ __('dossier.search_options') }}</p>
                        </div>
                        <div class="mb-3">
                            <select id="patient_id" name="patient_id" class="form-control form-control-solid @error('patient_id') is-invalid @enderror" >
                                <option></option>
                            </select>
                            @error('patient_id')<span class="invalid-feedback" role="alert">{{ $message }}</span>@enderror

                            <div class="clearfix"></div>
                        </div>
                        <div>
                            <p class="text-muted">{{ __('dossier.newpatientdata') }}</p>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-muted fw-medium">{{ __('patient.numero') }}</label>
                                <input class="form-control form-control-solid" disabled value="" placeholder="{{ __('patient.nouveaupatient') }}" type="text">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-muted fw-medium">{{ __('patient.nom') }}</label>
                                <input class="form-control form-control-solid @error('nom') is-invalid @enderror" id="nom" name="nom" value="@if($object->id){{ $object->patient->getnom() }}@else{{ old('nom') }}@endif" type="text" oninput="this.value = this.value.toUpperCase()" required="">
                                @error('nom')<span class="invalid-feedback" role="alert">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-muted fw-medium">{{ __('patient.prenom') }}</label>
                                <input class="form-control form-control-solid @error('prenom') is-invalid @enderror" id="prenom" name="prenom" value="@if($object->id){{ $object->patient->getprenom() }}@else{{ old('prenom') }}@endif" type="text" required="" >
                                @error('prenom')<span class="invalid-feedback" role="alert">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-muted fw-medium d-block">{{ __('patient.civilite') }}</label>
                                <select id="civilite" name="civilite" class="form-control form-control-solid @error('prenom') is-invalid @enderror" >
                                    <option></option>
                                    @foreach( $object->codes_civilite() as $cck=>$ccv )
                                    <optgroup label="{{ $cck }}">
                                        @foreach( $ccv as $k=>$v )
                                        <option value="{{ $k }}" @if($object->id && $object->civilite == $k ) selected @endif>{{ $v }}</option>
                                        @endforeach
                                    </optgroup>
                                    @endforeach
                                </select>
                                @error('civilite')<span class="invalid-feedback" role="alert">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-md-4 mb-3" style="display: none;" id="patient_epoux">
                                <label class="form-label text-muted fw-medium">{{ __('patient.epoux') }}</label>
                                <input class="form-control form-control-solid" id="epoux" name="epoux" value="@if($object->id){{ $object->patient->getepoux() }}@else{{ old('epoux') }}@endif" type="text">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-muted fw-medium">{{ __('patient.date_naissance') }}</label>
                                <input class="form-control form-control-solid date" id="date_naissance" name="date_naissance" value="{{ $object->date_naissance ? dateFormat($object->date_naissance, 'd-m-Y') : old('date_naissance') }}" type="text" required="">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-muted fw-medium">{{ __('patient.cin') }}</label>
                                <input class="form-control form-control-solid" id="cin" name="cin" value="@if($object->id){{ $object->patient->getcin() }}@else{{ old('cin') }}@endif" type="text">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-muted fw-medium d-block">{{ __('patient.ville') }}</label>
                                <select id="ville" name="ville" class="form-control form-control-solid ">
                                    <option></option>
                                    @foreach( villes() as $v )
                                    <option value="{{ $v }}" @if($object->id && $object->ville == $v ) selected @endif>{{ $v }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-8 mb-3">
                                <label class="form-label text-muted fw-medium">{{ __('patient.adresse') }}</label>
                                <input class="form-control form-control-solid" id="adresse" name="adresse" value="@if($object->id){{ $object->patient->getadresse() }}@else{{ old('adresse') }}@endif" type="text">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-muted fw-medium">{{ __('patient.tele') }}</label>
                                <input class="form-control form-control-solid" id="tele" name="tele" value="@if($object->id){{ $object->patient->gettele() }}@else{{ old('tele') }}@endif" type="number">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-muted fw-medium">{{ __('patient.email') }}</label>
                                <input class="form-control form-control-solid" id="email" name="email" value="@if($object->id){{ $object->patient->getemail() }}@else{{ old('email') }}@endif" type="email">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-muted fw-medium">{{ __('patient.fax') }}</label>
                                <input class="form-control form-control-solid" id="fax" name="fax" value="@if($object->id){{ $object->patient->getfax() }}@else{{ old('fax') }}@endif" type="number">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label text-muted fw-medium">{{ __('patient.commentaire') }}</label>
                                <input class="form-control form-control-solid" id="commentaire" name="commentaire" value="@if($object->id){{ $object->patient->getcommentaire() }}@else{{ old('commentaire') }}@endif" type="text">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- End card Patient -->

            <!-- Start card Patient -->
            <div class="col-md-8 m-auto">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">{{ __('dossier.infogeneral') }}</h4>
                    </div><!-- end card header -->

                    <div class="card-body row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label text-muted fw-medium d-block">{{ __('dossier.motif_id') }}</label>
                            <select id="motif_id" name="motif_id" class="form-control form-control-solid @error('motif_id') is-invalid @enderror" >
                                <option></option>
                            </select>
                            @error('motif_id')<span class="invalid-feedback" role="alert">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label text-muted fw-medium">{{ __('dossier.poids') }}</label>
                            <input class="form-control form-control-solid @error('poids') is-invalid @enderror" id="poids" name="poids" value="@if($object->id){{ $object->getpoids() }}@else{{ old('poids') }}@endif" type="number" step="0.01">
                            @error('poids')<span class="invalid-feedback" role="alert">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label text-muted fw-medium">{{ __('dossier.taille') }}</label>
                            <input class="form-control form-control-solid @error('taille') is-invalid @enderror" id="taille" name="taille" value="@if($object->id){{ $object->gettaille() }}@else{{ old('taille') }}@endif" type="number" step="0.01">
                            @error('taille')<span class="invalid-feedback" role="alert">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label text-muted fw-medium">{{ __('dossier.tension') }}</label>
                            <input class="form-control form-control-solid @error('tension') is-invalid @enderror" id="tension" name="tension" value="@if($object->id){{ $object->gettension() }}@else{{ old('tension') }}@endif" type="number" step="0.01">
                            @error('tension')<span class="invalid-feedback" role="alert">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label text-muted fw-medium">{{ __('dossier.comment') }}</label>
                            <textarea class="form-control form-control-solid" id="comment" name="comment">@if($object->id){{ $object->getcomment() }}@else{{ old('comment') }}@endif</textarea>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                      {!! update_actions($object) !!}
                    </div>
                </div>
            </div>
            <!-- End card Patient -->



            <!-- end card-body -->
        </div>
    </form><!-- end card -->

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
    $("#formdossier #civilite,#formdossier #ville").selectize();
    $("#formdossier #civilite").change(function(){
        if( $(this).val() == "mme" ){
            $('#patient_epoux').show();
        }else{
            $('#patient_epoux').hide();
        }
    }).trigger('change');
    // 
    await loadSelect({
        load: false,
        link: "{{ route('patient_ajaxlist') }}",
        selector: "#formdossier #patient_id",
        fieldVal: "id",
        fieldText: "numero,nom,prenom,cin",
        fieldLabel: "textsearch",
        selected: '{{ $object->patient_id }}',
    });
    $('#formdossier #patient_id').change(function(){
        var p_id = $(this).val();

        if( !p_id )
            return ;

        await $.ajax({
            url: "{{ route('patient_ajaxshow') }}",
            type: 'POST',
            data: {
                id: p_id,
                _token: "{{ csrf_token() }}"
            },
            success: function(patient) {
            }
        });
    });
    // 
    await loadSelect({
        load: false,
        link: "{{ route('motif_ajaxlist') }}",
        selector: "#formdossier #motif_id",
        fieldVal: "id",
        fieldText: "reference,nom",
        fieldLabel: "text",
        selected: '{{ $object->motif_id }}',
    });
    // 
    await loadSelect({
        load: false,
        link: "{{ route('analyse_ajaxlist') }}",
        selector: "#formdossier #analyses",
        fieldVal: "id",
        fieldText: "code,nom",
        fieldLabel: "text",
    });
    $("#formdossier #analyses").change(function(){
        var ana_id = $(this).val();

        if( !ana_id )
            return ;

        var ana_txt = $("#formdossier #analyses option:selected").text();

        $('#dossier_analyses ul').append(`<li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center pe-0 pt-0 pb-0"><span>${ ana_txt }</span> <input type="hidden" name="analyses[]" value="${ ana_id }" /><button type="button" class="btn btn-soft-danger position-relative pe-2 ps-2" onclick="event.preventDefault(); $(this).parent().remove();"> <i class="bx bxs-trash-alt"></i></button></li>`);


        $(this).data('selectize').setValue(0);
        //$(this).data('selectize').clearOptions();
        //$(this).data('selectize').focus();
    });
    // 
    await loadSelect({
        load: false,
        link: "{{ route('medicament_ajaxlist') }}",
        selector: "#formdossier #medicaments",
        fieldVal: "id",
        fieldText: "code,nom",
        fieldLabel: "text",
        selected: '{{ $object->user_id }}',
    });
    $("#formdossier #medicaments").change(function(){
        var ana_id = $(this).val();

        if( !ana_id )
            return ;

        var ana_txt = $("#formdossier #medicaments option:selected").text();

        $('#dossier_medicaments ul').append(`<li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center pe-0 pt-0 pb-0"><span>${ ana_txt }</span> <input type="hidden" name="medicaments[]" value="${ ana_id }" /><button type="button" class="btn btn-soft-danger position-relative pe-2 ps-2" onclick="event.preventDefault(); $(this).parent().remove();"> <i class="bx bxs-trash-alt"></i></button></li>`);


        $(this).data('selectize').setValue(0);
        //$(this).data('selectize').clearOptions();
        //$(this).data('selectize').focus();
    });

    applyDate('#date_naissance');
  });
</script>
@endsection