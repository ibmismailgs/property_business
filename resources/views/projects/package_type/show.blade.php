@extends('layouts.main')
@section('title', 'Package Type Details')
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
            <h5>{{ __('label.PACKAGE_TYPE_DETAILS')}}</h5>
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
              <a href="#">{{ __('label.PACKAGE_TYPE_DETAILS')}}</a>
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
          <h3>{{ __('label.PACKAGE_TYPE_DETAILS')}}</h3>
      </div>
        <div class="card-body">
          <table  class="table">
            <thead>
              <tr>
                <th>{{ __('label.NAME')}}</th>
                <th>{{ __('label.STATUS')}}</th>
                <th>{{ __('label.CREATED_AT')}}</th>
                <th>{{ __('label.UPDATED_AT')}}</th>
              </tr>
            </thead>
            <?php $i=1; ?>
            <tbody>
              <tr>
                <td>{{ $data->name }}</td>
                <td> @if ($data->status == 1) Active
                  @else
                  Inactive
                  @endif
                </td>
                <td>{{ $data->created_at }}</td>
                <td>{{ $data->updated_at }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>
</div>
<!-- push external js -->
@push('script')
<script src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>
<script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
<!--server side users table script-->
<script src="{{ asset('js/custom.js') }}"></script>
@endpush
@endsection
