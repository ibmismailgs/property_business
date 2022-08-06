@extends('layouts.main')
@section('title', 'Add Account')
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
                        <i class="ik ik-Account-plus bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Add Account')}}</h5>
                            <span>{{ __('Create new Account')}}</span>
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
                                <a href="#">{{ __('Add Account')}}</a>
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
                        <h3>{{ __('Add Account')}}</h3>
                    </div>
                    <div class="card-body">
                        <form class="forms-sample" method="POST" action="{{ route('accounts.store') }}">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">

                                    <div class="form-group">
                                        <label for="account_no">Account no<span class="text-red">*</span></label>
                                        <input id="account_no" type="text"
                                               class="form-control @error('account_no') is-invalid @enderror"
                                               name="account_no" value="{{old('account_no')}}" placeholder="Enter Account No">
                                        <div class="help-block with-errors"></div>

                                        @error('account_no')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">

                                    <div class="form-group">
                                        <label for="bank_id">Bank name<span class="text-red">*</span></label>
                                        <select name="bank_id" id="bank_id" class="form-control @error('bank_id') is-invalid @enderror">
                                            <option value="">Select</option>
                                            @if(count($banks) > 0)
                                                @foreach($banks as $bank)
                                                    <option value="{{$bank->id}}"
                                                            @if( old('bank_id') == $bank->id )
                                                            selected
                                                        @endif
                                                    >
                                                        {{$bank->name}}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <div class="help-block with-errors"></div>

                                        @error('bank_id')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">

                                    <div class="form-group">
                                        <label for="branch_name">Branch name<span class="text-red">*</span></label>
                                        <input id="branch_name" type="text"
                                               class="form-control @error('branch_name') is-invalid @enderror"
                                               name="branch_name" value="{{ old('branch_name') }}" placeholder="Enter Branch Name">
                                        <div class="help-block with-errors"></div>

                                        @error('branch_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                </div>

                                <div class="col-sm-6">

                                    <div class="form-group">
                                        <label for="initial_balance">Initial balance<span
                                                class="text-red">*</span></label>
                                        <input id="initial_balance" type="number"
                                               class="form-control @error('initial_balance') is-invalid @enderror"
                                               name="initial_balance" value="{{ old('initial_balance') ?? 0 }}" placeholder="Enter Initial Balance">
                                        <div class="help-block with-errors"></div>

                                        @error('initial_balance')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-12">

                                    <div class="form-group">
                                        <label for="initial_balance">Remarks</label>
                                        <textarea class="form-control" name="remarks" id="remarks" cols="30" rows="5">{{old('remarks')}}</textarea>
                                        <div class="help-block with-errors"></div>

                                        @error('remarks')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
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
    @push('script')
        <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
        <script>
            $('#bank_id').on('change',function () {
                console.log(5);
            })
        </script>
    @endpush
@endsection

