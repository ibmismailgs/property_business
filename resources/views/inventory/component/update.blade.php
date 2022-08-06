@extends('layouts.main')
@section('title', 'Edit Component')
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
                        <h5>{{ __('label.UPDATE_COMPONENT')}}</h5>
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
                            <a href="#">{{ __('label.UPDATE_COMPONENT')}}</a>
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
                    <h3>{{ __('label.UPDATE_COMPONENT')}}</h3>
                </div>
                <div class="card-body">
                    <form class="forms-sample" method="POST" action="{{ url('/components/'.$data->id) }}" >
                        @csrf
                        @method('PUT')
                        <div class="row" id="component">
                            <div class="col">
                                <div class="form-group">
                                    <label for="component_code">{{ __('label.COMPONENT_CODE')}}<span class="text-red">*</span></label>
                                    <input id="component_code" type="text" value="{{$data->component_code}}" class="form-control @error('component_code') is-invalid @enderror" name="component_code"  placeholder="Enter component code">
                                    <div class="help-block with-errors"></div>
                                    @error("component_code")
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-group">
                                    <label for="component_name">{{ __('label.COMPONENT_NAME')}}<span class="text-red">*</span></label>
                                    <input id="component_name" type="text" class="form-control @error('component_name') is-invalid @enderror" name="component_name" value="{{$data->component_name}}" placeholder="Enter component name" required>
                                    <div class="help-block with-errors"></div>
                                    @error("component_name")
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
