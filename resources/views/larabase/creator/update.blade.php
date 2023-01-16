@extends('layouts.standard_layouts')

@section('content')
<div id="kt_content_container" class="container">
  <form class="card" method="POST" enctype="multipart/form-data" action="{{ route('creator_store') }}">
    {{ csrf_field() }}
    
    <div class="card-header">
      <h3 class="card-title">Module Creator</h3>
    </div>

    <div class="card-body">
      <div class="row">

        <div class="col-md-6">
          <div class="form-group">
            <label class="form-label">Module Name</label>
            <input class="form-control" id="name" name="name" value="" type="text" required="">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label class="form-label">Module Description</label>
            <input class="form-control" id="description" name="description" value="" type="text">
          </div>
        </div>

      </div>
      

      <div class="mt-4 table">
        <h3 class="text-center p-5">List of fields</h3>
        <table id="fields" class="table table-striped table-bordered table-hover table-row-bordered table-row-gray-100">
          <thead>
            <tr class="table-dark table-active">
              <th class="fw-bolder text-light w-150px ps-4 rounded-start">Name</th>
              <th class="fw-bolder text-light">Type</th>
              <th class="fw-bolder text-light">Trans. Title</th>
              <th class="fw-bolder text-light">Nullable</th>
              <th class="fw-bolder text-light w-100px text-center rounded-end">Actions</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>

      </div>

      <span class="btn btn-primary btn-sm mt-4" id="addfield">New field</span>

    </div>
    <div class="card-footer text-right">
      <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i>&nbsp; Submit</button>
    </div>
  </form>
</div>


@endsection

@section('js')
<script type="text/javascript">
  jQuery(document).ready(function(){
    var mc_index = 1;
    $('#addfield').click(function(){
      //
      $('#fields tbody').append(`
          <tr>
            <th class="ps-4"> <input class="form-control" name="fields[${mc_index}][name]" type="text" required="">  </th>
            <th>
              <select class="form-control" required="" name="fields[${mc_index}][type]"> 
                <option value=""></option>  
                <option value="integer">Integer</option> 
                <option value="boolean">Boolean</option> 
                <option value="string">String</option> 
                <option value="text">Text</option> 
                <option value="mediumText">Medium Text</option> 
                <option value="longText">Long Text</option> 
                <option value="date">Date</option> 
                <option value="time">Time</option> 
                <option value="dateTime">Date Time</option> 
                <option value="float">Float</option> 
                <option value="decimal">Decimal</option> 
                <option value="double">Double</option>
              </select>
            </th>
            <th><input class="form-control" name="fields[${mc_index}][title]" type="text"></th>
            <th>
              <div class="form-check form-switch">
                <input class="form-check-input" name="fields[${mc_index}][nullable]" type="checkbox" id="fs${mc_index}" checked="">
                <label class="form-check-label" for="fs${mc_index}">
                </label>
              </div>
            </th>
            <th>
              <button class="btn btn-icon btn-danger p-0 btn-sm">
                <!--begin::Svg Icon | path: icons/duotone/General/Trash.svg-->
                <span class="svg-icon svg-icon-3">
                  <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                      <rect x="0" y="0" width="24" height="24"></rect>
                      <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"></path>
                      <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"></path>
                    </g>
                  </svg>
                </span>
                <!--end::Svg Icon-->
              </button>
            </th>
          </tr>
      `);


      mc_index++;
    });
  });
</script>
@endsection