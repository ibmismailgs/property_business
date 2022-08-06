@extends('layouts.main')
@section('title', 'Dashboard')
@section('content')
    <!-- push external head elements to head -->
    @push('head')

        <link rel="stylesheet" href="{{ asset('plugins/weather-icons/css/weather-icons.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/owl.carousel/dist/assets/owl.carousel.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/owl.carousel/dist/assets/owl.theme.default.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/chartist/dist/chartist.min.css') }}">
    @endpush

    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-headphones bg-danger"></i>
                        <div class="d-inline">
                            <h5>{{__('label.EDIT OUTLET')}}</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">{{__('label.EDIT OUTLET')}}</a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-body">
                        {{-- <form class="forms-sample">
                            {{ csrf_field() }} --}}
                            {{Form::open(['route'=>array('general.update.outlet', 'id'=>$outlet->id), 'method'=>'POST', "class"=>"form-horizontal"])}}
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="row mb-3">
                                        <label for="name" class="col-sm-4 col-form-label">1. Outlet Name</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="name" name="name" value="{{$outlet->name}}" placeholder="Outlet Name">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="code" class="col-sm-4 col-form-label">3. Outlet Code</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="code" name="code" value="{{$outlet->code}}" placeholder="code">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="row mb-3">
                                        <label for="district" class="col-sm-4 col-form-label">2. District</label>
                                        <div class="col-sm-8">
                                            <select name="district_id" id="district" class="form-control">
                                                <option value="">Select a district</option>
                                                @foreach($districts as $district)
                                                <option value="{{$district->id}}"{{ ($district->id == $outlet->district_id)?'selected':'' }}>{{$district->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="code" class="col-sm-4 col-form-label">4. Outlet Address</label>
                                        <div class="col-sm-8">
                                            <textarea name="address" id="address" class="form-control" cols="12" rows="1">{{$outlet->address}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="row mb-3">
                                        <label for="thana" class="col-sm-4 col-form-label">5. Thana</label>
                                        <div class="col-sm-8">
                                            <select name="thana_id" id="thana" class="form-control">
                                                <option value="">Select a thana</option>
                                                @foreach($thanas as $thana)
                                                <option value="{{$thana->id}}" {{ ($thana->id == $outlet->thana_id) ?'selected':'' }}>{{$thana->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="outlet_owner_name" class="col-sm-4 col-form-label">7. Outlet Owner Name</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="outlet_owner_name" name="outlet_owner_name" value="{{$outlet->outlet_owner_name}}" placeholder="outlet_owner_name">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="row mb-3">
                                        <label for="market" class="col-sm-4 col-form-label">6. Market</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="market" name="market" value="{{$outlet->market}}" placeholder="Market">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="mobile" class="col-sm-4 col-form-label">8. Mobile Number</label>
                                        <div class="col-sm-8">
                                            <input type="number" class="form-control" id="mobile" name="mobile" value="{{$outlet->mobile}}" placeholder="Mobile Number">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="row mb-3">
                                        <label for="outlet_owner_address" class="col-sm-4 col-form-label">7. Outlet Owner Address</label>
                                        <div class="col-sm-8">
                                            <textarea name="outlet_owner_address" id="outlet_owner_address" class="form-control" cols="12" rows="1">{{$outlet->outlet_owner_address}}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-30">
                                <div class="col-sm-12 text-center">
                                    <input type="submit" class="btn form-bg-danger mr-2">
                                    <button class="btn form-bg-inverse">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<!-- push external js -->


    <script type="text/javascript">
        $('#district').on('change', function(){
        var district_id=$(this).val();
        if(district_id){
            $.ajax({
                url: "{{url('general/get/thana/')}}/"+district_id,
                type: 'GET',
                dataType: "json",
                success: function(data){
                    $('#thana').empty();
                    $.each(data, function(key, value){
                        $('#thana').append("<option value="+value.id+">"+value.name+"</option>");
                    });
                }
            });
        }
    });
    </script>
@endsection
