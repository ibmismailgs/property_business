@extends('layouts.main')
@section('title', $bank->name)
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
                        <i class="ik ik-Bank-plus bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Edit Bank')}}</h5>
                            <span>{{ __('Edit new bank')}}</span>
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
                                <a href="#">{{ __('Edit Bank')}}</a>
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
                        <h3>{{ __('Edit Bank')}}</h3>
                    </div>
                    <div class="card-body">
                        <form class="forms-sample" method="POST" action="{{ route('banks.update',$bank->id) }}" >
                            @method('PUT')
                            @csrf
                            <div class="row">
                                <div class="col-sm-12">

                                    <div class="form-group">
                                        <label for="name">Bank name<span class="text-red">*</span></label>
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{$bank->name}}" placeholder="Enter Bank name">
                                        <div class="help-block with-errors"></div>

                                        @error('name')
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
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
