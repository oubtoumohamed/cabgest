@extends('layouts.app')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">{{ __('user.module_name') }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="">{{ __('user.module_name') }}</a></li>
                        <li class="breadcrumb-item active">@if($object->id){{ __('user.edit') }}@else{{ __('user.create') }}@endif</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-md-10 m-auto">
            <form class="card" method="POST" enctype="multipart/form-data" action="@if($object->id){{ route('user_update',$object->id) }}@else{{ route('user_store') }}@endif">
                {{ csrf_field() }}
                <div class="card-header">
                    <h4 class="card-title mb-0"> @if($object->id) {{ __('user.edit') }} @else {{ __('user.create') }} @endif</h4>
                </div><!-- end card header -->

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-muted fw-medium">{{ __('user.firstname') }}</label>
                            <input class="form-control form-control-solid" id="firstname" name="firstname" value="@if($object->id){{ $object->firstname }}@else{{ old('firstname') }}@endif" type="text" required="">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label text-muted fw-medium">{{ __('user.lastename') }}</label>
                            <input class="form-control form-control-solid" id="lastename" name="lastename" value="@if($object->id){{ $object->lastename }}@else{{ old('lastename') }}@endif" type="text" required="">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label text-muted fw-medium">{{ __('user.username') }}</label>
                            <input class="form-control form-control-solid" id="username" name="username" value="@if($object->id){{ $object->username }}@else{{ old('username') }}@endif" type="text">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label text-muted fw-medium">{{ __('user.email') }}</label>
                            <input class="form-control form-control-solid" id="email" name="email" value="@if($object->id){{ $object->email }}@else{{ old('email') }}@endif" type="email" required="">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-muted fw-medium">{{ __('user.password') }}</label>
                            <input class="form-control form-control-solid" id="password" name="password" type="password" value="">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-muted fw-medium">{{ __('user.phone') }}</label>
                            <input class="form-control form-control-solid" id="phone" value="@if($object->id){{ $object->phone }}@else{{ old('phone') }}@endif" name="phone" type="text">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-muted fw-medium">{{ __('user.cin') }}</label>
                            <input class="form-control form-control-solid" id="cin" value="@if($object->id){{ $object->cin }}@else{{ old('cin') }}@endif" name="cin" type="text">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-muted fw-medium">{{ __('user.adresse') }}</label>
                            <input class="form-control form-control-solid" id="adresse" value="@if($object->id){{ $object->adresse }}@else{{ old('adresse') }}@endif" name="adresse" type="text">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-muted fw-medium">{{ __('user.avatar') }}</label>
                            <div class="d-flex">
                              @if($object->id){!! $object->getavatar() !!}@endif
                              <input class="form-control form-control-solid" id="avatar" name="avatar" type="file">
                            </div>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-muted fw-medium">{{ __('user.role') }}</label>
                            @if($object->id)
                              <input class="form-control form-control-solid" value="{{ $object->role }}" type="text" readonly="" disabled="">
                            @else
                            <select id="role" name="role" class="form-control form-control-solid select_with_filter">
                              <option value="EMPLOYE" @if($object->id && $object->getrole() == "EMPLOYE" ) selected="selected" @endif >EMPLOYE</option>
                              <option value="ADMIN" @if($object->id && $object->getrole() == "ADMIN" ) selected="selected" @endif >ADMIN</option>
                            </select>
                            @endif
                        </div>
                        <div class="col-md-8 mb-3">
                            <label class="form-label text-muted fw-medium">{{ __('user.groupes') }}</label>
                            <select id="groupe" name="groupe[]" multiple="multiple" class="form-control form-control-solid">
                                @php
                                    $groupe_ids = ""; 
                                @endphp
                                @foreach ($object->groupes as $grp)
                                    @php
                                        $groupe_ids .= ','.$grp->id; 
                                    @endphp
                                    <option selected="selected" value="{{$grp->id}}">{{$grp->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <!-- end card-body -->
                <div class="card-footer text-right">
                  {!! update_actions($object) !!}
                </div>
            </form><!-- end card -->
        </div>

@endsection
@section('css')
    <link href="{{ asset('assets/css/selectize.css') }}?v=1" rel="stylesheet" type="text/css" />
@endsection

@section('js')
<script src="{{ asset('assets/js/selectize.js') }}"></script>
<script>
  $(document).ready(async function(){
    //$("select#groupe").selectize();
    await loadSelect({
        load: @if($object->id) false @else true @endif,
        link: "{{ route('groupe') }}",
        selector: "select#groupe",
        fieldVal: "id",
        fieldText: "name",
        fieldLabel: "name",
        selected: [{{ $groupe_ids }}],
    });
  });
</script>
@endsection