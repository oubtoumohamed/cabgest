@extends('main')

@section('content')
<div id="kt_content_container" class="container">
  <form class="card" method="POST" action="{{ route('translator_store') }}">
    {{ csrf_field() }}
    
    <div class="card-header">
      <h3 class="card-title">Translator</h3>
    </div>

    <div class="card-body">
      <div class="row mb-8">

        <div class="col-md-5">
          <div class="form-group">
            <label class="form-label">Language</label>
            <select id="lang" name="lang" class="form-control">
              <option ></option>
              <option @if( $lang == 'ar' ) selected="selected" @endif value="ar">العربية </option>
              <option @if( $lang == 'fr' ) selected="selected" @endif value="fr">Français </option>
              <option @if( $lang == 'en' ) selected="selected" @endif value="en">English </option>
            </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label class="form-label">Module</label>
            <select id="module" name="module" class="form-control">
              <option ></option>
              @foreach( $modules as $mdl )
              <option @if( $mdl == $module ) selected="selected" @endif value="{{ $mdl }}">{{ $mdl }} </option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="col-md-1">
          <div class="form-group">
            <label class="form-label">Refrech</label>
            <button id="load_data" class="btn rounded-pill btn-primary ms-4"> &#x27F3;</button>
          </div>
        </div>

      </div>

      <div class="row mb-4">

        @foreach( $data as $key=>$value )
        <div class="col-md-6 mb-4">
          <div class="form-group input-group">
            <label class="input-group-text col-md-3">{{ $key }}</label>
            <input class="form-control" name="trans[{{$key}}]" value="{{ $value }}" type="text" required="">
          </div>
        </div>
        @endforeach

      </div>
      <div class="row" id="fields" style="border-top: dashed 1px #ccc;padding: 10px 0;"></div>
      <span class="btn btn-primary mt-4" id="addfield">New</span>

    </div>
    <div class="card-footer text-right">
      {!! update_actions() !!}
    </div>
  </form>
</div>
  <script type="text/javascript">
    $(document).ready(function(){
      $('#load_data').click(function(e){
        e.preventDefault();

        if( $('#lang').val() && $('#module').val() )
          window.location.href = '{{ route('translator_create') }}/' + $('#lang').val() + '/' + $('#module').val();
      });

      var mc_index = 1;
      $('#addfield').click(function(){
        //
        $('#fields').append('<div class="col-md-6 mb-4" id="el_added_'+mc_index+'"> <div class="form-group input-group"> <label class="col-md-3"><input class="input-group-text" style="width: 100%;" name="fields['+mc_index+'][key]" value="" type="text" required=""></label> <input class="form-control" name="fields['+mc_index+'][value]" value="" type="text" required=""> <button type="button" class="btn btn-danger" onclick="delete_row('+mc_index+')" style="float: right;">X</button> </div> </div>');

        mc_index++;
      });
    }).on('click','');

    function delete_row(el){
      if( confirm('Are you sure ?'))
        $('#el_added_'+el).remove();
    }
  </script>

@endsection