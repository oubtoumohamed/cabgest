@extends('layouts.app')

@section('content')

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">{{ __('analyse.module_name') }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="">{{ __('analyse.module_name') }}</a></li>
                        <li class="breadcrumb-item active">@if($object->id){{ __('analyse.edit') }}@else{{ __('analyse.create') }}@endif</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-md-10 m-auto">
            
            {!! showalerts() !!}

            <form class="card" method="POST" enctype="multipart/form-data" action="@if($object->id){{ route('analyse_update',$object->id) }}@else{{ route('analyse_store') }}@endif">
                {{ csrf_field() }}
                <div class="card-header">
                    <h4 class="card-title mb-0"> @if($object->id) {{ __('analyse.edit') }} @else {{ __('analyse.create') }} @endif</h4>
                </div><!-- end card header -->

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-muted fw-medium">{{ __('analyse.code') }}</label>
                            <input class="form-control form-control-solid @error('code') is-invalid @enderror" id="code" name="code" value="@if($object->id){{ $object->getcode() }}@else{{ old('code') }}@endif" type="text">
                            @error('code')<span class="invalid-feedback" role="alert">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-8 mb-9">
                            <label class="form-label text-muted fw-medium">{{ __('analyse.nom') }}</label>
                            <input class="form-control form-control-solid @error('nom') is-invalid @enderror" id="nom" name="nom" value="@if($object->id){{ $object->getnom() }}@else{{ old('nom') }}@endif" type="text" required="">
                            @error('nom')<span class="invalid-feedback" role="alert">{{ $message }}</span>@enderror
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