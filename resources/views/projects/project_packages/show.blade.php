@extends('layouts.main')
@section('title', 'Package Details')
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
            <h5>{{ __('label.PACKAGE_DETAILS')}}</h5>
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
              <a href="#">{{ __('label.PACKAGE_DETAILS')}}</a>
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
          <h3>{{ __('label.PACKAGE_DETAILS')}}</h3>
        </div>
        <div class="card-body">
          <table  class="table">
            <thead>
              <tr>
                <th>{{ __('label.PROJECT_NAME')}}</th>
                <th>{{ __('label.PACKAGE_NAME')}}</th>
                <th>{{ __('label.PACKAGE_NUMBERS')}}</th>
                <th>{{ __('label.PACKAGE_DURATION')}}</th>
                <th>{{ __('label.PACKAGE_TYPE')}}</th>
                <th>{{ __('label.CONTACTORS_NAME')}}</th>
                <th>{{ __('label.CONTACTORS_TYPE')}}</th>
                <th>{{ __('label.STARTING_TIME')}}</th>
                <th>{{ __('label.ENDING_TIME')}}</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>{{ $value->projects->project_name }}</td>
                <td>{{ $value->package_name }}</td>
                <td>{{ $value->package_number }}</td>
                <td>{{ $value->package_duration}}</td>
                <td>{{ $value->packages->name}}</td>
                <td>{{ $value->contactors->contactor_name}}</td>
                <td>@if ($value->contactor_type == 1 ) Main Contactor
                  @else
                  Sub-Contactor
                  @endif</td>
                <td>{{ $value->package_start_date}}</td>
                <td>{{ $value->package_end_date}}</td>
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
