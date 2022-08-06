@extends('layouts.main')
@section('title', 'Project Type ')
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
            <h5>{{ __('label.PROJECT_TYPE')}}</h5>
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
              <a href="#">{{ __('label.PROJECT_TYPE')}}</a>
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
          <h3>{{ __('label.TYPE_LIST')}}</h3>
          <div class="card-header-right">
              <a href="{{url('/project-type/create')}}" class="btn btn-primary">  @lang('label.CREATE')</a>
          </div>
      </div>
        <div class="card-body">
          <table  class="table">
            <thead>
              <tr>
                <th>{{ __('label.SERIAL')}}</th>
                <th>{{ __('label.NAME')}}</th>
                <th>{{ __('label.STATUS')}}</th>
                <th>{{ __('label.ACTION')}}</th>
              </tr>
            </thead>
            <?php $i=1;?>
            <tbody>
              @foreach($data as $value)
              <tr>
                <td>{{$i++}}</td>
                <td>{{ $value->type_name }}</td>
                <td> @if ($value->project_status == 1) Active
                  @else
                  Inactive
                  @endif
                </td>
                <td col="20" >
                  <div class="table-actions">
                      <a href="{{route('project-type.show', $value->id)}}" title="View">
                        <button class="mr-2 btn-icon btn-icon-only btn btn-primary">
                            <i class="fa fa-eye btn-icon-wrapper"></i>
                        </button>
                    </a>
                    <a href="{{route('project-type.edit', $value->id)}}" title="Edit">
                        <button class="mr-2 btn-icon btn-icon-only btn btn-success">
                            <i class="fa fa-edit btn-icon-wrapper"></i>
                        </button>
                    </a>
                    <a>
                        <form action="{{url('project-type/'.$value->id)}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="mr-2 btn-icon btn-icon-only btn btn-danger btn-delete"  type="submit" >  <i class="fa fa-trash btn-icon-wrapper"></i></button>
                        </form>
                    </a>
                  </div>
                </td>
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
