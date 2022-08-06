@extends('layouts.main')
@section('title', 'Create Contactors')
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
                        <h5>{{ __('label.CREATE_CONTACTOR')}}</h5>
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
                            <a href="#">{{ __('label.CREATE_CONTACTOR')}}</a>
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
                    <h3>{{ __('label.CREATE_CONTACTOR')}}</h3>
                </div>
                <div class="card-body">
                    <form class="forms-sample" method="POST" action="{{ url('contactors') }}" >
                        @csrf
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="contactor_name">{{ __('label.CONTACTORS_NAME')}}<span class="text-red">*</span></label>
                                    <input id="contactor_name" type="text" class="form-control @error('contactor_name') is-invalid @enderror" name="contactor_name" value="" placeholder="Enter Contactor Name" required>
                                    <div class="help-block with-errors"></div>

                                    @error('contactor_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="contact_email">{{ __('label.CONTACTORS_EMAIL')}}<span class="text-red">*</span></label>
                                    <input id="contactor_email" type="email" class="form-control @error('contactor_email') is-invalid @enderror" name="contactor_email" value="" placeholder="Enter Contactor Email" required>
                                    <div class="help-block with-errors"></div>

                                    @error('contactor_email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="contactor_phone">{{ __('label.CONTACTORS_PHONE')}}<span class="text-red">*</span></label>
                                    <input id="contactor_phone" type="text" class="form-control @error('contactor_phone') is-invalid @enderror" name="contactor_phone" value="" placeholder="Enter Contactor Phone" required>
                                    <div class="help-block with-errors"></div>

                                    @error('contactor_phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="contactor_address">{{ __('label.CONTACTORS_ADDRESS')}}<span class="text-red">*</span></label>
                                    <textarea id="contactor_address" type="text" class="form-control @error('contactor_address') is-invalid @enderror" name="contactor_address" value="" placeholder="Enter Contactor Address" required></textarea>
                                    <div class="help-block with-errors"></div>

                                    @error('contactor_address')
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
</div>
<!-- push external js -->
@push('script')
<script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
<!--get role wise permissiom ajax script-->
{{-- <script src="{{ asset('js/get-role.js') }}"></script> --}}
@endpush

@endsection
