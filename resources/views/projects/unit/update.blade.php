    @extends('layouts.main')
    @section('title', 'Edit Package Unit')
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
                            <h5>{{ __('label.UPDATE_UNIT')}}</h5>
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
                                <a href="#">{{ __('label.UPDATE_UNIT')}}</a>
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
                        <h3>{{ __('label.UPDATE_UNIT')}}</h3>
                    </div>
                    <div class="card-body">
                     <form class="forms-sample" method="POST" action="{{ url('/package-unit/'.$data->id) }}" >
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="name">{{ __('label.UNIT_NAME')}}<span class="text-red">*</span></label>
                                    <input id="name" type="text" class="form-control @error('unit_name') is-invalid @enderror" name="unit_name" value="{{ $data->unit_name }}" required>
                                        <div class="help-block with-errors"></div>

                                        @error('unit_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="name">{{ __('label.STATUS')}}<span class="text-red">*</span></label>
                                        <select id="status" name="status" class="form-control @error('status') is-invalid @enderror" >
                                            <option value="{{ $data->status }}" selected=""> @if ($data->status == 1) Active @else Inactive
                                            @endif</option>
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                        <div class="help-block with-errors"></div>

                                        @error('status')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
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
    </div>
    <!-- push external js -->
    @push('script')
    <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
    <!--get role wise permissiom ajax script-->
    {{-- <script src="{{ asset('js/get-role.js') }}"></script> --}}
    @endpush

    @endsection
