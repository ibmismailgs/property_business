@extends('layouts.main')
@section('title', 'Users')
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
                            <h5>{{ __('label.OUTLET')}}</h5>
                            <span>{{ __('label.LIST OF OUTLET')}}</span>
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
                                <a href="#">{{ __('label.OUTLET')}}</a>
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
                        <h3>@lang('label.OUTLET')</h3>
                        <div class="card-header-right">
                           <a class="btn btn-info" data-toggle="modal" data-target="#demoModal">  @lang('label._CREATE')</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="datatable" class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('SL')}}</th>
                                    <th>{{ __('Outlet Name')}}</th>
                                    <th>{{ __('Outlet Code')}}</th>
                                    <th>{{ __('District')}}</th>
                                    <th>{{ __('Thana')}}</th>
                                    <th>{{ __('Outlet Address')}}</th>
                                    <th>{{ __('Outlet Owner Name')}}</th>
                                    <th>{{ __('Market')}}</th>
                                    <th>{{ __('Mobile Number')}}</th>
                                    <th>{{ __('Outlet Owner Address')}}</th>
                                    <th>{{ __('label.ACTION')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($i=1)
                                @foreach($outlets as $outlet)
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td>{{$outlet->name}}</td>
                                        <td>{{$outlet->code}}</td>
                                        <td>{{$outlet->district_name}}</td>
                                        <td>{{$outlet->thana_name}}</td>
                                        <td>{{$outlet->address}}</td>
                                        <td>{{$outlet->outlet_owner_name}}</td>
                                        <td>{{$outlet->market}}</td>
                                        <td>{{$outlet->mobile}}</td>
                                        <td>{{$outlet->outlet_owner_address}}</td>
                                        <td>
                                            <div class='text-center'>
                                                {{ Form::open(['route' => ['general.destroy.outlet', $outlet->id], 'method' => 'DELETE'] ) }}
                                                {{ Form::hidden('_method', 'DELETE') }}
                                                <a href="{{route('general.edit.outlet', ['id'=>$outlet->id])}}" class="show-outlet">
                                                    <i class='ik ik-eye f-16 mr-15 text-blue'></i>
                                                </a>
                                                <button type="submit" data-placement="top" data-rel="tooltip" data-original-title="Delete" style="border: none;background-color: #fff;">
                                                   <i class="ik ik-trash-2 f-16 text-red"></i>
                                                </button>
                                                {{ Form::close() }}
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

    <!--Add Warranty Type modal-->
    <div class="modal fade" id="demoModal" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="demoModalLabel">{{ __('label.OUTLET')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                {{ Form::open(array('route' => 'general.create.outlet', 'class' => 'forms-sample', 'id'=>'createRank','method'=>'POST')) }}
                    <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="name" class="col-form-label">Outlet Name</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Outlet Name">
                                        @error('name')
                                            <span class="text-red-error" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="code" class="col-form-label">Outlet Code</label>
                                        <input type="text" class="form-control" id="code" name="code" placeholder="code">
                                        @error('name')
                                            <span class="text-red-error" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="district" class="col-form-label">District</label>
                                        <select name="district_id" id="district" class="form-control">
                                            <option value="">Select a district</option>
                                            @foreach($districts as $district)
                                            <option value="{{$district->id}}">{{$district->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="thana" class="col-form-label">Thana</label>
                                        <select name="thana_id" id="thana" class="form-control">
                                            <option value="">Select a thana</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="code" class="col-form-label">Outlet Address</label>
                                        <textarea name="address" id="address" class="form-control" cols="12" rows="1"></textarea>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="outlet_owner_name" class="col-form-label">Outlet Owner Name</label>
                                        <input type="text" class="form-control" id="outlet_owner_name" name="outlet_owner_name" placeholder="outlet_owner_name">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="market" class="col-form-label">Market</label>
                                        <input type="text" class="form-control" id="market" name="market" placeholder="Market">
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="mobile" class="col-form-label">Mobile Number</label>
                                        <input type="number" class="form-control" id="mobile" name="mobile" placeholder="Mobile Number">
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="outlet_owner_address" class="col-form-label">Outlet Owner Address</label>
                                        <textarea name="outlet_owner_address" id="outlet_owner_address" class="form-control" cols="12" rows="1"></textarea>
                                    </div>
                                </div>

                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{ __('label.SUBMIT')}}</button>
                        <a href="{!! URL::to('inventory') !!}" class="btn btn-inverse js-dynamic-disable">{{ __('label.CENCEL')}}</a>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <!-- push external js -->
    @push('script')
    <script src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('plugins/sweetalert/dist/sweetalert.min.js') }}"></script>
    <!--server side users table script-->
    {{-- <script src="{{ asset('js/custom.js') }}"></script> --}}
    @endpush

    <script>
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
