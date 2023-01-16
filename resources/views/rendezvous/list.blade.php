@extends('layouts.app')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">{{ __('rendezvous.module_name') }}</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="">{{ __('rendezvous.module_name') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('rendezvous.list') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-xl-9">
                    <div class="card card-h-100">
                        <div class="card-body">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div><!-- end col -->
                <div class="col-xl-3">
                    <div class="card card-h-100">
                        <div class="card-header bg-soft-secondary">
                            <h4 class="card-title mb-0 text-dark"> @if($object->id) {{ __('rendezvous.edit') }} @else {{ __('rendezvous.create') }} @endif</h4>
                        </div><!-- end card header -->
                        <form method="POST" enctype="multipart/form-data" action="{{ route('rendezvous_store') }}">
                            <div class="card-body">
                                {!! showalerts() !!}
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label text-muted fw-medium">{{ __('rendezvous.motif_id') }}</label>
                                        <select id="motif_id" name="motif_id" class="form-control form-control-solid" required="">
                                        </select>
                                        @error('motif_id')<span class="invalid-feedback" role="alert">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-muted fw-medium">{{ __('rendezvous.from') }}</label>
                                        <input class="form-control form-control-solid datetime  @error('from') is-invalid @enderror" id="from" name="from" value="@if($object->id){{ $object->getfrom() }}@else{{ old('from') }}@endif" type="text">
                                        @error('from')<span class="invalid-feedback" role="alert">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-muted fw-medium">{{ __('rendezvous.duree') }}</label>
                                        <div class="input-group">
                                            <input class="form-control form-control-solid time  @error('duree') is-invalid @enderror" id="duree" name="duree" value="@if($object->id){{ $object->getduree() }}@else{{ old('duree') }}@endif" type="number" placeholder="10">
                                            <span class="input-group-text">Minutes</span>
                                        </div>
                                        @error('duree')<span class="invalid-feedback" role="alert">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label text-muted fw-medium">{{ __('rendezvous.patient_id') }}</label>
                                        <div class="input-group">
                                            <select id="patient_id" name="patient_id" class="form-control form-control-solid" required="">
                                            </select>
                                            <a class="btn btn-outline-info" href="{{ route('patient_create') }}" target="_blank"><i class="bx bxs-user-plus fs-18"></i></a>
                                        </div>

                                        @error('patient_id')<span class="invalid-feedback" role="alert">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label text-muted fw-medium">{{ __('rendezvous.priority') }}</label>
                                        <!-- Outlined Styles -->
                                        <div class="hstack gap-2 flex-wrap">
                                            <input type="radio" class="btn-check" name="etat" value="low" id="etat_low">
                                            <label class="btn-sm btn btn-soft-warning shadow-none" for="etat_low"><i class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>{{ __('rendezvous.low') }}</label>
                                            <input type="radio" class="btn-check" name="etat" value="normal" id="etat_normal">
                                            <label class="btn-sm btn btn-soft-secondary shadow-none" for="etat_normal"><i class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>{{ __('rendezvous.normal') }}</label>
                                            <input type="radio" class="btn-check" name="etat" value="hight" id="etat_hight">
                                            <label class="btn-sm btn btn-soft-primary shadow-none" for="etat_hight"><i class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>{{ __('rendezvous.hight') }}</label>
                                            <input type="radio" class="btn-check" name="etat" value="urgent" id="etat_urgent">
                                            <label class="btn-sm btn btn-soft-danger shadow-none" for="etat_urgent"><i class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>{{ __('rendezvous.urgent') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label text-muted fw-medium">{{ __('rendezvous.commentaire') }}</label>
                                        <textarea class="form-control form-control-solid @error('commentaire') is-invalid @enderror" id="commentaire" name="commentaire">@if($object->id){{ $object->getcommentaire() }}@else{{ old('commentaire') }}@endif</textarea>
                                        @error('commentaire')<span class="invalid-feedback" role="alert">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                            </div>
                            <!-- end card-body -->
                            <div class="card-footer text-right">
                              {!! update_actions($object) !!}
                            </div>
                        </form><!-- end card -->
                    </div>
                </div> <!-- end col-->
            </div>
            <!--end row-->

            <div style='clear:both'></div>
        </div>
    </div> <!-- end row-->
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

    $( "#calendar" ).jtCalendar({
        color: "#fff",
        mode: 'day',
        classes:{
            'low': 'warning',
            'normal': 'secondary',
            'hight': 'primary',
            'urgent': 'danger',
        },
        ajaxlink: 'http://localhost/cabgest/admin/rendezvous/list?forAction=loadSelect'
    });
    
    $("select#state").selectize();
    await loadSelect({
        load: true,
        link: "{{ route('motif_ajaxlist') }}",
        selector: "select#motif_id",
        fieldVal: "id",
        fieldText: "reference,nom",
        fieldLabel: "text",
        selected: '{{ $object->motif_id }}',
    });
    await loadSelect({
        load: false,
        link: "{{ route('patient') }}",
        selector: "select#patient_id",
        fieldVal: "id",
        fieldText: "nom,prenom,cin",
        fieldLabel: "text",
        selected: '{{ $object->patient_id }}',
    });
    applyDateTime('#from', false);
    applyTime('#start', false);
    applyTime('#end', false);

    ///$('#createnewpatient .modal-content').load('{{ route('patient_create') }} #patient_create_form');

  });
</script>
@endsection