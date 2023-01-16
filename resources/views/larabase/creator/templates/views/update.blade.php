@extends('main')

@section('content')
<div class="container">
  <form class="card" method="POST" enctype="multipart/form-data" action="@if($object->id){{ route('__ModuleLower___update',$object->id) }}@else{{ route('__ModuleLower___store') }}@endif">
    {{ csrf_field() }}
    <div class="card-header">
      <h3 class="card-title">
        @if($object->id)
          {{ __('__ModuleLower__.__ModuleLower___edit') }}
        @else
          {{ __('__ModuleLower__.__ModuleLower___create') }}
        @endif
      </h3>
    </div>
    <div class="card-body">
      <div class="row">

__ModuleFields__

      </div>
    </div>
    <div class="card-footer text-right">
      <button type="submit" id="save_btn" class="btn btn-success"> 
        <i class="fa fa-check"></i>&nbsp; {{ __('global.submit') }}
      </button>

      @if( $object->id and isGranted('__ModuleLower___create') )
        <a id="create_btn" class="btn ms-2 btn-primary" href="{{ route('__ModuleLower___create') }}">
          <i class="fa fa-plus"></i>&nbsp; {{ __('global.add') }}
        </a>
      @endif
      
      @if( $object->id and isGranted('__ModuleLower___delete') )
        <a href="{{ route('__ModuleLower___delete', $object->id) }}" type="button" data-toggle="modal" data-target="#confirmdelete" class="btn ms-2 btn-danger delete_btn">
          <i class="fa fa-times"></i>&nbsp; {{ __('global.delete') }}
        </a>
      @endif
    
      @if( isGranted('__ModuleLower__') )
        <a id="list_btn" class="btn btn-outline-secondary ms-2" href="{{ route('__ModuleLower__') }}">
          <i class="fa fa-ban"></i>&nbsp;{{ __('global.cancel') }}
        </a>
      @endif
    </div>
  </form>
</div>
@endsection