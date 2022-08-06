@extends('layouts.main')
@section('title', 'Create Package')
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
						<h5>{{ __('label.CREATE_PACKAGE')}}</h5>
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
							<a href="#">{{ __('label.CREATE_PACKAGE')}}</a>
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
					<h3>{{ __('label.CREATE_PACKAGE')}}</h3>
				</div>
				<div class="card-body">
				<form class="forms-sample" method="POST" action="{{ url('project-packages') }}" >
						@csrf
						<div class="row">
							<div class="col-sm-4">
								<div class="form-group">
									<label for="project_type_id">{{ __('label.SELECT_PROJECT')}}<span class="text-red">*</span></label>
									<select id="project_id" name="project_id" class="form-control @error('project_id') is-invalid @enderror" required="">
										<option value="">Please select </option>
										@foreach($data as $value)
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
							<div class="col-sm-4">
								<div class="form-group">
									<label for="package_name">{{ __('label.PACKAGE_NAME')}}<span class="text-red">*</span></label>
									<input id="package_name" type="text" class="form-control @error('package_name') is-invalid @enderror" name="package_name" value="" placeholder="Enter package name" required>
									<div class="help-block with-errors"></div>

									@error('package_name')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>
							</div>

							<div class="col-sm-4">
								<div class="form-group">
									<label for="package_number">{{ __('label.PACKAGE_NUMBERS')}}<span class="text-red">*</span></label>
									<input id="package_number" name="package_number" type="text" class="form-control @error('package_number') is-invalid @enderror" value="" placeholder="Enter package number" required>
									<div class="help-block with-errors"></div>

									@error('package_number')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>
							</div>

							<div class="col-sm-4">
								<div class="form-group">
									<label for="package_duration">{{ __('label.PACKAGE_DURATION')}}<span class="text-red">*</span></label>
									<input id="package_duration" type="text" class="form-control @error('package_duration') is-invalid @enderror" name="package_duration" value="" placeholder="Enter package duration" required>
									<div class="help-block with-errors"></div>

									@error('package_duration')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>
							</div>

							<div class="col-sm-4">
								<div class="form-group">
									<label for="package_start_date">{{ __('label.STARTING_TIME')}}<span class="text-red">*</span></label>
									<input id="package_start_date" type="date" class="form-control @error('package_start_date') is-invalid @enderror" name="package_start_date"  placeholder="Enter package start date" required>

									<div class="help-block with-errors"></div>

									@error('package_start_date')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>
							</div>

							<div class="col-sm-4">
								<div class="form-group">
									<label for="package_end_date">{{ __('label.ENDING_TIME')}}<span class="text-red">*</span></label>
									<input id="package_end_date" type="date" class="form-control @error('package_end_date') is-invalid @enderror" name="package_end_date"  placeholder="Enter package end date" required>
									<div class="help-block with-errors"></div>

									@error('package_end_date')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>
							</div>

							<div class="col-sm-4">
								<div class="form-group">
									<label for="contactor_id">{{ __('label.CONTACTORS_NAME')}}<span class="text-red">*</span></label>
									<select id="contactor_id" name="contactor_id" class="form-control @error('contactor_id') is-invalid @enderror" required="">
										<option>Please Select </option>
										@foreach($contactor as $value)
										<option value="{{$value->id}}">{{$value->contactor_name}}</option>
										@endforeach
									</select>
									<div class="help-block with-errors"></div>
									@error('contactor_id')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>
							</div>

							<div class="col-sm-4">
								<div class="form-group">
									<label for="contactor_type">{{ __('label.CONTACTORS_TYPE')}}<span class="text-red">*</span></label>
									<div class="form-check">
                                    <input class="form-check-input" type="radio" name="contactor_type" id="contactor_type1" @error('contactor_id') is-invalid @enderror" value="1" aria-checked="false" required="" autocomplete="off">
                                    <label class="form-check-label" for="contactor_type">
                                        Main Contactor
                                    </label> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                                    <input class="form-check-input" type="radio" name="contactor_type" id="contactor_type2" value="2" aria-checked="false" required="" autocomplete="off">
                                    <label class="form-check-label" for="contactor_type" @error('contactor_id') is-invalid @enderror">
                                        Sub-Contactor
                                    </label>
                                    </div>
									<div class="help-block with-errors"></div>
									@error('contactor_type')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form-group">
									<label for="type_id">{{ __('label.PACKAGE_TYPE')}}<span class="text-red">*</span></label>
									<select id="type_id" name="type_id" class="form-control @error('type_id') is-invalid @enderror" required="">
										<option>Please Select </option>
										@foreach($package as $value)
										<option value="{{$value->id}}">{{$value->name}}</option>
										@endforeach
									</select>
									<div class="help-block with-errors"></div>
									@error('type_id')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>
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
<!-- push external js -->
@push('script')
<script type="text/javascript">
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$(document).ready(function () {
		$('#contactor_id').on('change',function(e) {
		 var cat_id = e.target.value;
		 $.ajax({
			   url:"{{ url('selectsubcontactor') }}",
			   type:"POST",
			   data: {
				   cat_id: cat_id
				},
			   success:function (data) {
				$('#subcontactor_id').empty();

				$.each(data.subcontactor, function(key){
					$('#subcontactor_id').append("<option value='"+data.subcontactor[key].id+"'>"+data.subcontactor[key].subcontactor_name+"</option>");
                    })
			   }
		   })
		});
	});
</script>
<script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
<!--get role wise permissiom ajax script-->
{{-- <script src="{{ asset('js/get-role.js') }}"></script> --}}
@endpush

@endsection
