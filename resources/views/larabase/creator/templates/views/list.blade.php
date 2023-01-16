@extends('main')

@section('content')

  <div id="kt_content_container" class="container-fluid">
    <div class="card">
      <!--begin::Header-->
      <div class="card-header border-0 pt-5">
        <h3 class="card-title align-items-start flex-column">
          <span class="card-label fw-bolder fs-3 mb-1">{{ __('__ModuleLower__.list_') }}</span>
          <span class="text-muted mt-1 fw-bold fs-7">{{ __('__ModuleLower__.description_') }}</span>
        </h3>
        <div class="card-toolbar">
          <a href="{{ route('__ModuleLower___create') }}" class="btn btn-sm btn-primary">{{ __('global.add') }}</a>
        </div>
      </div>
      <!--end::Header-->
      
      <!--begin::Body-->
      <div class="card-body py-3">
        <!--begin::Table container-->
        <div class="table-responsive">
          <table class="table table-row-dashed table-bordered table-hover table-row-bordered table-row-gray-200 align-middle gs-0 gy-4">
            <!--begin::Table head-->
            <thead>
              <tr class="landing-dak-bg fw-bolder text-muted">
                <th class="w-25px ps-4 rounded-start">
                  <div class="form-check form-check-sm form-check-custom form-check-solid">
                    <input class="form-check-input" type="checkbox" value="1" data-kt-check="true" data-kt-check-target=".widget-9-check">
                  </div>
                </th>
__ModuleHeaderFields__
                <th class="w-100px text-center rounded-end" aria-label="Actions">{{ __('global.actions') }}</th>
              </tr>
              <tr class="fw-bolder text-muted bg-light">
                <form action="" method="GET" role="form" id="filterForm">
                  <th class="w-25px ps-2 rounded-start">
                    <a class="btn btn-icon btn-sm">
                      <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                          <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <rect x="0" y="0" width="24" height="24"></rect> <path d="M5,4 L19,4 C19.2761424,4 19.5,4.22385763 19.5,4.5 C19.5,4.60818511 19.4649111,4.71345191 19.4,4.8 L14,12 L14,20.190983 C14,20.4671254 13.7761424,20.690983 13.5,20.690983 C13.4223775,20.690983 13.3458209,20.6729105 13.2763932,20.6381966 L10,19 L10,12 L4.6,4.8 C4.43431458,4.5790861 4.4790861,4.26568542 4.7,4.1 C4.78654809,4.03508894 4.89181489,4 5,4 Z" fill="#000000"></path> </g>
                        </svg>
                      </span>
                    </a>
                  </th>
__ModuleFilterFields__
                  <th class="w-100px text-center rounded-end">
                    <button type="submit" class="btn btn-icon btn-sm btn-active-success">
                      <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <rect x="0" y="0" width="24" height="24"></rect> <path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path> <path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero"></path> </g>
                        </svg>
                      </span>
                    </button>
                    <a href="?filters=reset" class="btn btn-icon btn-sm btn-active-warning">
                      <span class="svg-icon svg-icon-2">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                          <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000"> <rect fill="#000000" x="0" y="7" width="16" height="2" rx="1"></rect> <rect fill="#000000" opacity="0.5" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)" x="0" y="7" width="16" height="2" rx="1"></rect> </g>
                        </svg>
                      </span>
                    </a>
                  </th>
                </form>
              </tr>
            </thead>
            <!--end::Table head-->
            <!--begin::Table body-->
            <tbody>

              @foreach( $results as $object )

              <tr>
                <td class="w-25px ps-4 rounded-start">
                  <div class="form-check form-check-sm form-check-custom form-check-solid">
                    <input class="form-check-input widget-9-check" type="checkbox" name="idx[]" value="{{ $object->id }}">
                  </div>
                </td>
__ModuleLooperFields__
                <td class="text-center px-4">
                  <div class="d-flex justify-content-end flex-shrink-0">
                    @if( isGranted('__ModuleLower___edit') )
                      <a href="{{ route('__ModuleLower___edit',$object->id) }}" class="btn btn-icon btn-light btn-active-success me-3 btn-sm">
                        <!--begin::Svg Icon | path: icons/duotone/Communication/Write.svg-->
                        <span class="svg-icon svg-icon-3">
                          <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <path d="M12.2674799,18.2323597 L12.0084872,5.45852451 C12.0004303,5.06114792 12.1504154,4.6768183 12.4255037,4.38993949 L15.0030167,1.70195304 L17.5910752,4.40093695 C17.8599071,4.6812911 18.0095067,5.05499603 18.0083938,5.44341307 L17.9718262,18.2062508 C17.9694575,19.0329966 17.2985816,19.701953 16.4718324,19.701953 L13.7671717,19.701953 C12.9505952,19.701953 12.2840328,19.0487684 12.2674799,18.2323597 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.701953, 10.701953) rotate(-135.000000) translate(-14.701953, -10.701953)"></path>
                            <path d="M12.9,2 C13.4522847,2 13.9,2.44771525 13.9,3 C13.9,3.55228475 13.4522847,4 12.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L12.9,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                          </svg>
                        </span>
                        <!--end::Svg Icon-->
                      </a>
                    @endif
                    @if( isGranted('__ModuleLower___delete') )
                      <a href="{{ route('__ModuleLower___delete',$object->id) }}" type="button" data-toggle="modal" data-target="#confirmdelete" class="btn btn-icon btn-light btn-active-danger btn-sm">
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
                      </a>
                    @endif
                  </div>
                </td>
              </tr>

              @endforeach
            </tbody>
            <!--end::Table body-->
          </table>
          <!--end::Table-->
        </div>
        <!--end::Table container-->

      </div>
      <!--end::Body-->
      <!--begin::Footer-->
      <div class="card-footer border-1 pt-5">

        <!--start::Pagination-->
        <div class="row">
          <div class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start">
            @if($results)
              {!! __('global.pages_list',[
                  'current'=> $results->currentPage(),
                  'length'=> $results->lastPage(),
                  'total'=> $results->total(),
                  'module'=>__('__ModuleLower__.__ModuleLower__')
                ])
              !!}
            @endif
          </div>
          <div class="col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end">
            <div class="dataTables_paginate paging_simple_numbers" id="kt_subscriptions_table_paginate">
              {!! $results->links() !!}
            </div>
          </div>
        </div>
        <!--end::Pagination-->
      </div>
      <!--end::Footer-->
    </div>
  </div>


@endsection