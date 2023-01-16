@extends('layouts.app')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">{{ __('groupe.module_name') }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="">{{ __('groupe.module_name') }}</a></li>
                        <li class="breadcrumb-item active">@if($object->id){{ __('groupe.edit') }}@else{{ __('groupe.create') }}@endif</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-md-10 m-auto">
            <form class="card" method="POST" enctype="multipart/form-data" action="@if($object->id){{ route('groupe_update',$object->id) }}@else{{ route('groupe_store') }}@endif">
                {{ csrf_field() }}
                <div class="card-header">
                    <h4 class="card-title mb-0"> @if($object->id) {{ __('groupe.edit') }} @else {{ __('groupe.create') }} @endif</h4>
                </div><!-- end card header -->

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label text-muted fw-medium">{{ __('groupe.name') }}</label>
                            <input class="form-control form-control-solid" id="name" name="name" value="@if($object->id){{ $object->name }}@else{{ old('name') }}@endif" type="text" required="">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-muted fw-medium">{{ __('groupe.roles') }}</label>
                            <input class="form-control form-control-solid" id="search" type="text" placeholder="{{ __('global.search') }}">
                        </div>
                    </div>
                        
                    <div class="row" id="groupe_roles">
                        @foreach($object->get__roles() as $k=>$role)
                        <!--begin::Accordion-->
                        <div class="accordion col-md-2 mb-5">
                            <div class="accordion-item shadow">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion{{ $k }}" aria-expanded="true" aria-controls="kt_accordion{{ $k }}">
                                    {{ $role['name'] }}
                                    </button>
                                </h2>
                                <div id="kt_accordion{{ $k }}" class="accordion-collapse collapse show">
                                    <div class="accordion-body">
                                        @foreach( $role['actions'] as $av=>$anm )
                                        <div class="item form-check form-check-warning form-check-solid mb-3" data-name="{{ $anm.' '.$role['name'] }}">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="checkbox" value="{{ $k.'_'.$av }}" name="roles[]" class="switch role_ module_{{ $k }} " data-module="{{ $k }}" @if( strpos( $object->roles.',' , $k.'_'.$av.',' ) > -1 ) checked="checked" @endif/>{{ $anm }}
                                        </label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Accordion-->
                        @endforeach
                    </div>
                </div>
                <!-- end card-body -->
                <div class="card-footer text-right">
                  {!! update_actions($object) !!}
                </div>
            </form><!-- end card -->
        </div>

@endsection

@section('js')
<script>
$(document).ready(function(){
    $('#search').on('keyup', function(){
      if($(this).val()==""){
        $('#groupe_roles .all_check').show();
        $('#groupe_roles .accordion').show()
        $('#groupe_roles .item').show()
        return
      }else{
        $('#groupe_roles .all_check').hide();
      }

      var value = $('#search').val().toLowerCase();

      $('#groupe_roles .item').show().filter(function(){
        return $(this).data('name').toLowerCase().indexOf(value) === -1;
      })
      .hide()
      .closest('.accordion')
      .show()
      .end()
      .each(function(){
          let card = $(this).closest('.accordion');
          if(card.find('.item:visible').length === 0)
            card.hide();
      });
    });
});
</script>
@endsection