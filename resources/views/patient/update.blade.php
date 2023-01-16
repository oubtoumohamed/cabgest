@extends('layouts.app')

@section('content')

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">{{ __('patient.module_name') }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="">{{ __('patient.module_name') }}</a></li>
                        <li class="breadcrumb-item active">@if($object->id){{ __('patient.edit') }}@else{{ __('patient.create') }}@endif</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-md-10 m-auto">
            
            {!! showalerts() !!}

            <form class="card" method="POST" enctype="multipart/form-data" action="@if($object->id){{ route('patient_update',$object->id) }}@else{{ route('patient_store') }}@endif">
                {{ csrf_field() }}
                <div class="card-header">
                    <h4 class="card-title mb-0"> @if($object->id) {{ __('patient.edit') }} @else {{ __('patient.create') }} @endif</h4>
                </div><!-- end card header -->

                <div class="card-body">
                    <div>
                        <p class="text-muted">{{ __('global.infosperso') }}</p>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-muted fw-medium">{{ __('patient.numero') }}</label>
                            <input class="form-control form-control-solid" disabled value="@if($object->id){{ $object->getnumero() }}@else{{ __('patient.nouveaupatient') }}@endif" type="text">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-muted fw-medium">{{ __('patient.nom') }}</label>
                            <input class="form-control form-control-solid @error('nom') is-invalid @enderror" id="nom" name="nom" value="@if($object->id){{ $object->getnom() }}@else{{ old('nom') }}@endif" type="text" oninput="this.value = this.value.toUpperCase()" required="">
                            @error('nom')<span class="invalid-feedback" role="alert">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-muted fw-medium">{{ __('patient.prenom') }}</label>
                            <input class="form-control form-control-solid @error('prenom') is-invalid @enderror" id="prenom" name="prenom" value="@if($object->id){{ $object->getprenom() }}@else{{ old('prenom') }}@endif" type="text" required="" >
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
                            <input class="form-control form-control-solid" id="epoux" name="epoux" value="@if($object->id){{ $object->getepoux() }}@else{{ old('epoux') }}@endif" type="text">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-muted fw-medium">{{ __('patient.date_naissance') }}</label>
                            <input class="form-control form-control-solid date" id="date_naissance" name="date_naissance" value="{{ $object->date_naissance ? dateFormat($object->date_naissance, 'd-m-Y') : old('date_naissance') }}" type="text" required="">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-muted fw-medium">{{ __('patient.cin') }}</label>
                            <input class="form-control form-control-solid" id="cin" name="cin" value="@if($object->id){{ $object->getcin() }}@else{{ old('cin') }}@endif" type="text">
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
                            <input class="form-control form-control-solid" id="adresse" name="adresse" value="@if($object->id){{ $object->getadresse() }}@else{{ old('adresse') }}@endif" type="text">
                        </div>
                    </div>
                    <div>
                        <p class="text-muted">{{ __('global.infoscontact') }}</p>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-muted fw-medium">{{ __('patient.tele') }}</label>
                            <input class="form-control form-control-solid" id="tele" name="tele" value="@if($object->id){{ $object->gettele() }}@else{{ old('tele') }}@endif" type="number">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-muted fw-medium">{{ __('patient.email') }}</label>
                            <input class="form-control form-control-solid" id="email" name="email" value="@if($object->id){{ $object->getemail() }}@else{{ old('email') }}@endif" type="email">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-muted fw-medium">{{ __('patient.fax') }}</label>
                            <input class="form-control form-control-solid" id="fax" name="fax" value="@if($object->id){{ $object->getfax() }}@else{{ old('fax') }}@endif" type="number">
                        </div>
                    </div>
                    <div>
                        <p class="text-muted">{{ __('global.infosgeneral') }}</p>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label text-muted fw-medium">{{ __('patient.commentaire') }}</label>
                            <input class="form-control form-control-solid" id="commentaire" name="commentaire" value="@if($object->id){{ $object->getcommentaire() }}@else{{ old('commentaire') }}@endif" type="text">
                        </div>
                    </div>
                </div>
                <!-- end card-body -->
                <div class="card-footer text-right">
                  {!! update_actions($object) !!}
                </div>
            </form><!-- end card -->
        </div>
    </div>

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
    $("select#civilite,select#ville").selectize();
    $("select#civilite").change(function(){
        if( $(this).val() == "mme" ){
            $('#patient_epoux').show();
        }else{
            $('#patient_epoux').hide();
        }
    }).trigger('change');
    // 
    applyDate('#date_naissance');
  });
</script>
@endsection