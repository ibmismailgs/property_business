@extends('layouts.main')
@section('title', 'Create Items')
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
						<h5>{{ __('label.CREATE_PACKAGE_ITEM')}}</h5>
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
							<a href="#">{{ __('label.CREATE_PACKAGE_ITEM')}}</a>
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
					<h3>{{ __('label.CREATE_PACKAGE_ITEM')}}</h3>
				</div>
				<div class="card-body">
				<form class="forms-sample" method="POST" action="{{ url('package-items') }}" >
						@csrf
						<div class="row">
							<div class="col-sm-4">
								<div class="form-group">
									<label for="package_id">{{ __('label.SELECT_PACKAGE')}}<span class="text-red">*</span></label>

							<select id="package_id" name="package_id" class="form-control @error('package_id') is-invalid @enderror" required="">
										<option value="">Please select </option>
										@foreach($package as $value)
										<option value="{{$value->id}}">{{$value->package_name}}</option>
										@endforeach
									</select>
									<div class="help-block with-errors"></div>
									@error('package_id')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>
							</div>

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
									<label for="item_code">{{ __('label.ITEM_CODE')}}<span class="text-red">*</span></label>
									<input id="item_code" name="item_code" type="text" class="form-control @error('item_code') is-invalid @enderror" value="" placeholder="Enter item code" required>
									<div class="help-block with-errors"></div>

									@error('item_code')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>
							</div>

							<div class="col-sm-4">
								<div class="form-group">
									<label for="item_rate">{{ __('label.ITEM_RATE')}}<span class="text-red">*</span></label>
									<input id="item_rate" min="0" type="number" class="form-control @error('item_rate') is-invalid @enderror" name="item_rate" value="" placeholder="Enter item rate" required>
									<div class="help-block with-errors"></div>
									@error('item_rate')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>
							</div>

							<div class="col-sm-4">
								<div class="form-group">
									<label for="item_quantity">{{ __('label.ITEM_QUANTITY')}}<span class="text-red">*</span></label>
									<input min="1" id="item_quantity" type="number" class="form-control @error('item_quantity') is-invalid @enderror" name="item_quantity"  placeholder="Enter item quantity" required>

									<div class="help-block with-errors"></div>

									@error('item_quantity')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>
							</div>

							<div class="col-sm-4">
								<div class="form-group">
									<label for="total_cost">{{ __('label.TOTAL_COST')}}<span class="text-red">*</span></label>
									<input id="total_cost" type="text" value="" class="form-control @error('total_cost') is-invalid @enderror" name="total_cost"  placeholder="" readonly>
									<div class="help-block with-errors"></div>

									@error('total_cost')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>
							</div>

							<div class="col-sm-4">
								<div class="form-group">
									<label for="package_id">{{ __('label.UNIT')}}<span class="text-red">*</span></label>
									<select id="unit_id" name="unit_id" class="form-control @error('unit_id') is-invalid @enderror" required="">
										<option value="">Please Select </option>
										@foreach($unit as $value)
										<option value="{{$value->id}}">{{$value->unit_name}}</option>
										@endforeach
									</select>
									<div class="help-block with-errors"></div>
									@error('unit_id')
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
<!-- push external js -->
@push('script')

<script type='text/javascript'>

    $(document).ready(function (){
        $('#item_rate, #item_quantity, #total_cost').on('input',function(e){
            var total_cost = 0;
            var item_rate = Number($('#item_rate').val());
            var item_quantity = Number($('#item_quantity').val());

            var total_cost = parseFloat(item_rate) * parseFloat(item_quantity);
            $('#total_cost').val(total_cost);
        })
    });

</script>

<script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
<!--get role wise permissiom ajax script-->
{{-- <script src="{{ asset('js/get-role.js') }}"></script> --}}
@endpush

@endsection
