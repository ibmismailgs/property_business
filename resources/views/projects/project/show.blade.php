@extends('layouts.main')
@section('title', 'Project Details')
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
            <h5>{{ __('label.PROJECTS_DETAILS')}}</h5>
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
              <a href="#">{{ __('label.PROJECTS_DETAILS')}}</a>
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
          <h3>{{ __('label.PROJECTS_DETAILS')}}</h3>
        </div>
        <div class="card-body">
          <table class="table table-striped table-bordered table-hover">
            <tr>
              <th><strong>{{__('label.PROJECT_TYPE')}}</strong></th>
              <td>{{ $projects->packages->type_name }}</td>
            </tr>
            <tr>
              <th><strong>{{__('label.PROJECT_NAME')}}</strong></th>
              <td>{{ $projects->project_name }}</td>
            </tr>

            <tr>
              <th><strong>{{__('label.PROJECT_PACKAGES')}}</strong></th>
              <td>{{ $projects->project_packages }}</td>
            </tr>


            <tr>
              <th><strong>{{__('label.PROJECT_VALUE')}}</strong></th>
              <td>{{ $projects->project_value }}</td>
            </tr>
            <tr>
              <th><strong>{{__('label.PROJECT_DURATION')}}</strong></th>
              <td>{{ $projects->project_duration }}</td>
            </tr>
            <tr>
              <th><strong>{{__('label.IMPLEMENTING_AGENCY')}}</strong></th>
              <td>{{ $projects->implementing_agency }}</td>
            </tr>
            <tr>
              <th><strong>{{__('label.START_DATE')}}</strong></th>
              <td>{{ $projects->start_date }}</td>
            </tr>
            <tr>
              <th><strong>{{__('label.COMPLETED_DATE')}}</strong></th>
              <td>{{ $projects->completed_date }}</td>
            </tr>
            <tr>
              <th><strong>{{__('label.CREATED_AT')}}</strong></th>
              <td>{{ $projects->created_at }}</td>
            </tr>

            <tr>
              <th><strong>{{__('label.UPDATED_AT')}}</strong></th>
              <td>{{ $projects->updated_at }}</td>
            </tr>
          </table>
          <table  class="table">
            <thead>
              <tr>
                <th>{{ __('label.SERIAL')}}</th>
                <th>{{ __('label.COMPONENT_NAME')}}</th>
                <th>{{ __('label.COMPONENT_CODE')}}</th>
                <th>{{ __('label.GOB')}}</th>
                <th>{{ __('label.OTHERS_RPA')}}</th>
                <th>{{ __('label.DPA')}}</th>
                <th>{{ __('label.TOTAL')}}</th>
              </tr>
            </thead>
            <?php $i=1;?>
            <tbody>
                @foreach($projects->components as $project)
                <tr>
                <td>{{$i++}}</td>
                <td>{{ $project->component_name }}</td>
                <td>{{ $project->component_code }}</td>
                <td>{{ $project->pivot->gob}}</td>
                <td>{{ $project->pivot->others_rpa}}</td>
                <td>{{ $project->pivot->dpa}}</td>
                <td>{{ $project->pivot->total}}</td>

              </tr>
                @endforeach
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
