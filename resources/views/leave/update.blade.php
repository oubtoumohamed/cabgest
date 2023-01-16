@extends('layouts.app')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">{{ __('leave.module_name') }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="">{{ __('leave.module_name') }}</a></li>
                        <li class="breadcrumb-item active">@if($object->id){{ __('leave.edit') }}@else{{ __('leave.create') }}@endif</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-md-10 m-auto">
            <form class="card" method="POST" enctype="multipart/form-data" action="@if($object->id){{ route('leave_update',$object->id) }}@else{{ route('leave_store') }}@endif">
                {{ csrf_field() }}
                <div class="card-header">
                    <h4 class="card-title mb-0"> @if($object->id) {{ __('leave.edit') }} @else {{ __('leave.create') }} @endif</h4>
                </div><!-- end card header -->

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-muted fw-medium">{{ __('leave.from') }}</label>
                            <input class="form-control form-control-solid date" id="from" name="from" autocomplete="false" value="@if($object->id){{ $object->getfrom() }}@else{{ old('from') }}@endif" type="text" required="">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-muted fw-medium">{{ __('leave.to') }}</label>
                            <input class="form-control form-control-solid date" id="to" name="to" value="@if($object->id){{ $object->getto() }}@else{{ old('to') }}@endif" type="text" required="">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-muted fw-medium">{{ __('leave.notes') }}</label>
                            <input class="form-control form-control-solid" id="notes" name="notes" value="@if($object->id){{ $object->notes }}@else{{ old('notes') }}@endif" type="text" required="">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-muted fw-medium">{{ __('leave.user_id') }}</label>
                            <select id="user_id" name="user_id" class="form-control form-control-solid" required="">
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-muted fw-medium">{{ __('leave.state') }}</label>
                            <select id="state" name="state" class="form-control form-control-solid" required="">
                                <option @if($object->id && $object->state == 'pendding') selected @endif value="pendding">{{ __('leave.pendding') }}</option>
                                <option @if($object->id && $object->state == 'validate') selected @endif value="validate">{{ __('leave.validate') }}</option>
                                <option @if($object->id && $object->state == 'canceled') selected @endif value="canceled">{{ __('leave.canceled') }}</option>
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
    <link href="{{ asset('assets/css/datetimepicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/selectize.css') }}?v=1" rel="stylesheet" type="text/css" />
@endsection

@section('js')
<script src="{{ asset('assets/js/datetimepicker.js') }}"></script>
<script src="{{ asset('assets/js/selectize.js') }}"></script>
<script>
  $(document).ready(async function(){
    $("select#state").selectize();
    await loadSelect({
        load: true,
        link: "{{ route('user') }}",
        selector: "select#user_id",
        fieldVal: "id",
        fieldText: "firstname,lastename",
        fieldLabel: "text",
        selected: '{{ $object->user_id }}',
    });
    applyDate('#from,#to');
  });
</script>
@endsection