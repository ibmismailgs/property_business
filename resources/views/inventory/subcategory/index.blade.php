@extends('layouts.main')
@section('title', 'Inventory Sub-Category')
@section('content')
<!-- push external head elements to head -->
@push('head')
  <link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
@endpush

<div class="container-fluid">
  <div class="page-header">
    <div class="row align-items-end">
      <div class="col-lg-8">
        <div class="page-header-title">
          <i class="ik ik-users bg-blue"></i>
          <div class="d-inline">
            <h5>{{ __('label.SUB_CATEGORY')}}</h5>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <nav class="breadcrumb-container" aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="{{route('dashboard')}}"><i class="ik ik-home"></i></a>
            </li>
            <li class="breadcrumb-item">
              <a href="#">{{ __('label.SUB_CATEGORY')}}</a>
            </li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
  <div class="row">
    <!-- start message area-->
    @include('include.message')
    <!-- end message area-->
    <div class="col-md-12">
      <div class="card p-3">
        <div class="card-header">
          <h3>{{ __('label.SUB_CATEGORY_LIST')}}</h3>
          <div class="card-header-right">
            <a href="{{url('/inventory-subcategory/create')}}" class="btn btn-primary">  @lang('label.CREATE')</a>
          </div>
        </div>
        <div class="card-body">
          <table style="width: 100%;" id="dataTable" class="table table-hover  table-bordered">
            <thead>
              <tr>
                <th>{{ __('label.SERIAL')}}</th>
                <th>{{ __('label.CATEGORY_NAME')}}</th>
                <th>{{ __('label.SUB_CATEGORY_NAME')}}</th>
                <th>{{ __('label.ACTION')}}</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- push external js -->
@push('script')
<script src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>

<script>
    $('#dataTable').DataTable({
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        processing: true,
        serverSide: true,
        responsive: true,
        order: [[ 1, "DESC" ]],
        dom: 'Bfrtip',
        buttons: [
            'colvis'
        ],
        language: {
            processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i><span class="sr-only">Loading...</span>'
        },
        ajax: {
            url: "{{route('getInventorySubCategoryList')}}",
            dataType: "json",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}"
            }
        },
        columns: [
            { data: "id" },
            { data: "category_id" },
            { data: "name" },
            { data: "actions" }
        ],
        columnDefs: [{
            targets: [4],
            orderable: false
        }]
    });

    $('#dataTable').on('click', '.btn-delete[data-remote]', function (e) {
        e.preventDefault();
        let url = $(this).data('remote');
        if (confirm('are you sure you want to delete this?')) {
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: {submit: true, _method: 'delete', _token: "{{ csrf_token() }}"}
            }).always(function (data) {
                $('#dataTable').DataTable().draw(false);
            });
        }
    });

</script>

    @endpush
@endsection
