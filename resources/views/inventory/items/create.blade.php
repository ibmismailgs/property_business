@extends('layouts.main')
@section('title', 'Add Items')
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
						<h5>{{ __('label.ADD_ITEM')}}</h5>
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
							<a href="#">{{ __('label.ADD_ITEM')}}</a>
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
					<h3>{{ __('label.ADD_ITEM')}}</h3>
				</div>
				<div class="card-body">
				<form class="forms-sample" method="POST" action="{{ url('inventory-items') }}" >
						@csrf
						<div class="row">
							<div class="col-sm-4">
								<div class="form-group">
									<label for="item_name">{{ __('label.ITEM_NAME')}}<span class="text-red">*</span></label>
									<input id="item_name" type="text" class="form-control @error('item_name') is-invalid @enderror" name="item_name" value="" placeholder="Enter item name" required>
									<div class="help-block with-errors"></div>

									@error('item_name')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>
							</div>

							<div class="col-sm-4">
								<div class="form-group">
									<label for="item_price">{{ __('label.ITEM_PRICE')}}<span class="text-red">*</span></label>
									<input id="item_price" min="0" type="number" class="form-control @error('item_price') is-invalid @enderror" name="item_price" value="" placeholder="Enter item price" required>
									<div class="help-block with-errors"></div>
									@error('item_price')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>
							</div>

							<div class="col-sm-4">
								<div class="form-group">
									<label for="item_origin">{{ __('label.ORIGIN')}}<span class="text-red">*</span></label>
									<input id="item_origin" type="text" value="" class="form-control @error('item_origin') is-invalid @enderror" name="item_origin"  placeholder="Enter Origin">
									<div class="help-block with-errors"></div>

									@error('item_origin')
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

<script type='text/javascript'>
<script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
<!--get role wise permissiom ajax script-->
{{-- <script src="{{ asset('js/get-role.js') }}"></script> --}}
@endpush

@endsection
