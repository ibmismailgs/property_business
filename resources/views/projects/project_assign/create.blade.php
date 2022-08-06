@extends('layouts.main')
@section('title', 'Project Assign')
@section('content')
<!-- push external head elements to head -->
@push('head')
<link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2.min.css') }}">
@endpush


<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-user-plus bg-blue"></i>
                    <div class="d-inline">
                        <h5>{{ __('label.PROJECT_ASSIGN')}}</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <nav class="breadcrumb-container" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{url('dashboard')}}"><i class="ik ik-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#">{{ __('label.PROJECT_ASSIGN')}}</a>
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
            <div class="card ">
                <div class="card-header">
                    <h3>{{ __('label.PROJECT_ASSIGN')}}</h3>
                </div>
                <div class="card-body">
                    <form class="forms-sample" method="POST" action="{{ url('project-assign') }}" >
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
								<div class="form-group">
									<label for="project_id">{{ __('label.SELECT_PROJECT')}}<span class="text-red">*</span></label>
									<select id="project_id" name="project_id" class="form-control @error('project_id') is-invalid @enderror" required="">
										<option value="">Please select </option>
										@foreach($project as $value)
										<option value="{{$value->id}}">{{$value->project_name}}</option>
										@endforeach
									</select>
									<div class="help-block with-errors"></div>
									@error('project_id')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>
							</div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name">{{ __('label.SELECT_EMPLOYEE')}}<span class="text-red">*</span></label>
                                    <select id="employee_id" name="employee_id" class="form-control @error('employee_id') is-invalid @enderror" required="">
										<option>Please select </option>
										@foreach($employee as $value)
										<option value="{{$value->id}}">{{$value->first_name}} {{$value->last_name}}</option>
										@endforeach
									</select>
                                    <div class="help-block with-errors"></div>
                                    @error('employee_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>



                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">{{ __('Submit')}}</button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- push external js -->
@push('script')
<script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
<!--get role wise permissiom ajax script-->
{{-- <script src="{{ asset('js/get-role.js') }}"></script> --}}
@endpush

@endsection
