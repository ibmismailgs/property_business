@extends('layouts.main')
@section('title', 'Add Components')
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
						<h5>{{ __('label.ADD_COMPONENT')}}</h5>
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
							<a href="#">{{ __('label.ADD_COMPONENT')}}</a>
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
					<h3>{{ __('label.ADD_COMPONENT')}}</h3>
				</div>
				<div class="card-body">
					<form class="forms-sample" method="POST" action="{{ url('components') }}" >
						@csrf
						<div id="component">
							<div class="row" >
								<div class="col-sm-5">
									<div class="form-group">
										<label for="component_code">{{ __('label.COMPONENT_CODE')}}<span class="text-red">*</span></label>
										<input id="component_code" type="text" class="form-control @error('component_code') is-invalid @enderror" name="component_code[]"  placeholder="Enter component code">
										<div class="help-block with-errors"></div>
										@error("component_code")
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
										@enderror
									</div>
								</div>

								<div class="col-sm-5">
									<div class="form-group">
										<label for="component_name">{{ __('label.COMPONENT_NAME')}}<span class="text-red">*</span></label>
										<input id="component_name" type="text" class="form-control @error('component_name') is-invalid @enderror" name="component_name[]" value="" placeholder="Enter component name" required>
										<div class="help-block with-errors"></div>
										@error("component_name")
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
										@enderror
									</div>
								</div>
								<div style="margin-top: 27px;" class="col-md-2">
									<div class="form-group">
										<button  type="button" class="btn btn-success" id="add">+</button>
									</div>
								</div>

							</div>
						</div>

						<div class="row">
							<div class="col-md-12 text-center">
								<div class="form-group">
									<button type="submit" class="btn btn-primary mt-4">
										{{ __('label.SUBMIT')}}
									</button>
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
<script type="text/javascript">
	$(document).ready(function () {
		var html= '<div class="row" id="delete"><div class="col-sm-5">\
		<div class="form-group">\
		<label for="component_code">{{ __('label.COMPONENT_CODE')}}<span class="text-red">*</span></label>\
		<input id="component_code" type="text" class="form-control @error('component_code') is-invalid @enderror" name="component_code[]"  placeholder="Enter component code">\
		<div class="help-block with-errors"></div>\
		@error("component_code")\
		<span class="invalid-feedback" role="alert">\
		<strong>{{ $message }}</strong>\
		</span>\
		@enderror\
		</div>\
		</div>\
		<div class="col-sm-5">\
		<div class="form-group">\
		<label for="component_name">{{ __('label.COMPONENT_NAME')}}<span class="text-red">*</span></label>\
		<input id="component_name" type="text" class="form-control @error('component_name') is-invalid @enderror" name="component_name[]" placeholder="Enter component name" required>\
		<div class="help-block with-errors"></div>\
		@error("component_name")\
		<span class="invalid-feedback" role="alert">\
		<strong>{{ $message }}</strong>\
		</span>\
		@enderror\
		</div>\
		</div>\
		<div style="margin-top: 27px;" class="col-md-2">\
		<div class="form-group">\
		<button type="button" class="btn btn-danger btn_remove" id="del">-</button>\
		</div>\
		</div>\
		</div>';

		var x = 1;
		var max = 20;
		$('#add').click(function(){
			if(x < max){
				$('#component').append(html);
				x++;
			}
		});

		$('#component').on('click','#del',function(){
			$(this).closest('#delete').remove();
			x--;
		});

	});
</script>
<script type='text/javascript'>
	<script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
	<!--get role wise permissiom ajax script-->
	{{-- <script src="{{ asset('js/get-role.js') }}"></script> --}}
	@endpush

	@endsection
