@extends('layouts.main')
@section('title', 'Edit Items')
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
                        <h5>{{ __('label.UPDATE_ITEM')}}</h5>
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
                            <a href="#">{{ __('label.UPDATE_ITEM')}}</a>
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
                    <h3>{{ __('label.UPDATE_ITEM')}}</h3>
                </div>
                <div class="card-body">
                    <form class="forms-sample" method="POST" action="{{ url('/package-items/'.$item->id) }}" >
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="package_id">{{ __('label.SELECT_PACKAGE')}}<span class="text-red">*</span></label>

                                    <select id="package_id" name="package_id" class="form-control @error('package_id') is-invalid @enderror" required="">
                                        <option value="">Please select </option>
                                        @foreach($package as $value)
                                        <option value="{{$value->id}}" {{ $value->id==$item->package_id ? 'selected' : ' '}}>{{$value->package_name}}</option>
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
                                    <input id="item_name" type="text" class="form-control @error('item_name') is-invalid @enderror" name="item_name" value="{{$item->item_name}}" placeholder="Enter item name" required>
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
                                    <input id="item_code" name="item_code" type="text" class="form-control @error('item_code') is-invalid @enderror" value="{{$item->item_code}}" placeholder="Enter item code" required>
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
                                    <input onkeypress="return add_number(event)" id="item_rate" type="number" class="form-control @error('item_rate') is-invalid @enderror" name="item_rate" value="{{$item->item_rate}}" placeholder="Enter item rate" required>
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
                                    <input onkeypress="return add_number(event)" id="item_quantity" type="number" class="form-control @error('item_quantity') is-invalid @enderror" name="item_quantity"  placeholder="Enter item quantity" value="{{$item->item_quantity}}" required>
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
                                    <input id="total_cost" type="text" value="100" class="form-control @error('total_cost') is-invalid @enderror" name="total_cost" value="{{$item->total_cost}}" readonly>
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
                                    <label for="unit_id">{{ __('label.UNIT')}}<span class="text-red">*</span></label>
                                    <select id="unit_id" name="unit_id" class="form-control @error('unit_id') is-invalid @enderror">
                                        <option value="">Please Select </option>
                                        @foreach($unit as $value)
                                        <option value="{{$value->id}}" {{ $value->id==$item->unit_id ? 'selected' : ' '}}>{{$value->unit_name}}</option>
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
                                <button type="submit" class="btn btn-primary">{{ __('Update')}}</button>
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
<script>
	function add_number(e) {
	  if (isNumberKey(e)) {
		setTimeout(() => {
		  var item_rate = document.getElementById("item_rate").value !== "" ? parseInt(document.getElementById("item_rate").value) : 0;
		  var item_quantity = document.getElementById("item_quantity").value !== "" ? parseInt(document.getElementById("item_quantity").value) : 0;
		  var result = item_rate * item_quantity;
		  document.getElementById("total_cost").value = result;
		}, 50)
		return true;
	  } else {
		return false;
	  }
	}

	function isNumberKey(evt) {
	  var charCode = (evt.which) ? evt.which : event.keyCode
	  if (charCode > 31 && (charCode < 48 || charCode > 57)) {
		return false;
	  }
	  return true;
	}
	</script>
<script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
<!--get role wise permissiom ajax script-->
{{-- <script src="{{ asset('js/get-role.js') }}"></script> --}}
@endpush

@endsection
