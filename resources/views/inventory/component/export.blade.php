@extends('layouts.main')
@section('title', 'Export Components')
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
						<h5>{{ __('label.EXPORT_COMPONENT')}}</h5>
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
							<a href="#">{{ __('label.EXPORT_COMPONENT')}}</a>
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
					<h3>{{ __('label.EXPORT_COMPONENT')}}</h3>
				</div>
				<div class="card-body">
					<form class="forms-sample" method="POST" action="{{ url('components-export-data') }}"enctype="multipart/form-data">
						@csrf
							<div class="row" >
								<div class="col-sm-5">
									<div class="form-group">
										<label for="">{{ __('label.CHOOSE_FILE')}}<span class="text-red">*</span></label>
										<input type="file" class="form-control @error('file') is-invalid @enderror" name="file"  placeholder="Enter file" accept=".xlsx">
										<div class="help-block with-errors"></div>
										@error("file")
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
										@enderror
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<button type="submit" class="btn btn-primary mt-4">
										{{ __('label.SUBMIT')}}
									</button>
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
<script type='text/javascript'>
	<script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
	<!--get role wise permissiom ajax script-->
	{{-- <script src="{{ asset('js/get-role.js') }}"></script> --}}
	@endpush

	@endsection
