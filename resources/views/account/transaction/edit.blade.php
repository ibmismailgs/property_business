@extends('layouts.main')
@section('title', 'Edit Transaction')
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
                        <i class="ik ik-Transaction-plus bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Edit Transaction')}}</h5>
                            <span>{{ __('Create new Transaction')}}</span>
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
                                <a href="#">{{ __('Edit Transaction')}}</a>
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
                    <div class="card-body">
                        <form class="forms-sample" method="POST" action="{{ route('transactions.update',$transaction->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-sm-6">

                                    <div class="form-group">
                                        <label for="date">Date<span
                                                class="text-red">*</span></label>
                                        <input id="date" type="date"
                                               class="form-control @error('date') is-invalid @enderror"
                                               name="date" value="{{ old('date', optional($transaction)->date->format('Y-m-d')) }}" placeholder="Enter date">
                                        <div class="help-block with-errors"></div>

                                        @error('date')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">

                                    <div class="form-group">
                                        <label for="account_id">Account no <span class="text-red">*</span></label>

                                        <select name="account_id" id="account_id" class="form-control @error('account_id') is-invalid @enderror">
                                            <option value="">select</option>
                                            @forelse($accounts as $account)

                                                <option value="{{ $account->id }}"
                                                        @if( old('account_id', optional($transaction)->account_id) == $account->id )
                                                        selected
                                                    @endif
                                                >
                                                    {{$account->account_no}} - ( {{ isset($account->bank[0]->name) ? $account->bank[0]->name: ''}} )
                                                </option>

                                            @empty
                                                <option value="">No Account Found</option>
                                            @endforelse
                                        </select>

                                        <div class="help-block with-errors"></div>

                                        @error('account_id')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">

                                    <div class="form-group">
                                        <label for="amount">Amount<span class="text-red">*</span></label>
                                        <input id="amount" type="text"
                                               class="form-control @error('amount') is-invalid @enderror" name="amount"
                                               value="{{ old('amount', optional($transaction)->amount) }}" placeholder="Enter Amount">
                                        <div class="help-block with-errors"></div>

                                        @error('amount')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">

                                    <div class="form-group">
                                        <label for="purpose">Purpose<span class="text-red">*</span></label>
                                        <select name="purpose" id="purpose" class="form-control @error('purpose') is-invalid @enderror">
                                            <option value="">Select</option>
                                            <option value="1" @if( old('purpose', optional($transaction)->purpose) == 1 )
                                            selected
                                                @endif>Withdraw</option>
                                            <option value="2" @if( old('purpose', optional($transaction)->purpose) == 2 )
                                            selected
                                                @endif>Deposit</option>
                                            <option value="3" @if( old('purpose', optional($transaction)->purpose) == 3 )
                                            selected
                                                @endif>Received Payment</option>
                                            <option value="4" @if( old('purpose', optional($transaction)->purpose) == 4 )
                                            selected
                                                @endif>Given Payment</option>
                                        </select>
                                        <div class="help-block with-errors"></div>

                                        @error('purpose')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-12">

                                    <div id="type_section">
                                        <div class="form-group">
                                            <label for="type" class="">Type</label>
                                            <select name="type" id="type" class="form-control type">
                                                <option value="1" @if( old('type', optional($transaction)->type) == 1 )
                                                selected
                                                    @endif>Cheque</option>
                                                <option value="2" @if( old('type', optional($transaction)->type) == 2 )
                                                selected
                                                    @endif>Balance Transfer</option>
                                            </select>

                                            @error('type')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror

                                        </div>
                                    </div>

                                    <div id="balance_transfer_section">
                                        <div class="form-group">
                                            <label for="balance_transfer_info" class="">Balance Transfer Details</label>
                                            <textarea rows="1" class="form-control autosize-input"
                                                      style="height: 75px; margin-top: 0px; margin-bottom: 0px;"
                                                      name="balance_transfer_info" id="balance_transfer_info"
                                                      placeholder="Payment Details Like Cheque Number, Bank Name...">{{ old('balance_transfer_info', optional($transaction)->balance_transfer_info) }}</textarea>
                                            @error('balance_transfer_info')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div id="cheque_number_section">
                                        <div class="form-group">
                                            <label for="cheque_number" class="">Cheque Number</label>
                                            <input name="cheque_number" id="cheque_number"
                                                   placeholder="Cheque Number" type="text" class="form-control"
                                                   value="{{ old('cheque_number', optional($transaction)->cheque_number) }}">
                                            @error('cheque_number')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="initial_balance">Remarks</label>
                                        <textarea class="form-control" name="remarks" id="" cols="30" rows="5">
                                            {{ old('details', optional($transaction)->details) }}
                                        </textarea>
                                        <div class="help-block with-errors"></div>

                                        @error('remarks')
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
    @push('script')
        <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
        <script>
            $(document).ready(function(){
                var purpose = $('#purpose').val();
                if (purpose == 3 || purpose == 4 ) {
                    $('#type_section').show();
                    $('#balance_transfer_section').hide();
                    $('#cheque_number_section').hide();
                   
                    var type = $('#type').val();
                    if (type == 1) {
                        $('#cheque_number_section').show();
                        $('#balance_transfer_section').hide();
                    }
                    else if (type == 2) {
                        $('#balance_transfer_section').show();
                        $('#cheque_number_section').hide();
                    }
                    else {
                        $('#balance_transfer_section').hide();
                        $('#cheque_number_section').hide();
                    }
                }

                else if(purpose == 5){
                    
                    $('#type_section').hide();
                    $('#balance_transfer_section').hide();
                    $('#cheque_number_section').hide()
                }

                else {
                    $('#cheque_number_section').show();
                    $('#type_section').hide();
                    $('#balance_transfer_section').hide();
                    
                }

                var type = $('#type').val();
                if (type == 1) {
                    $('#cheque_number_section').show();
                    $('#balance_transfer_section').hide();
                }
                else if (type == 2) {
                    $('#balance_transfer_section').show();
                    $('#cheque_number_section').hide();
                }
                else {
                    $('#balance_transfer_section').hide();
                    $('#cheque_number_section').hide();
                }
            });

            $('#purpose').on('change', function(){
                var purpose = $('#purpose').val();
                if (purpose == 3 || purpose == 4) {
                    $('#type_section').show();
                    $('#balance_transfer_section').hide();
                    $('#cheque_number_section').hide();
                    
                    var type = $('#type').val();
                    if (type == 1) {
                        $('#cheque_number_section').show();
                        $('#balance_transfer_section').hide();
                    }
                    else if (type == 2) {
                        $('#balance_transfer_section').show();
                        $('#cheque_number_section').hide();
                    }
                    else {
                        $('#balance_transfer_section').hide();
                        $('#cheque_number_section').hide();
                    }
                }
                else {
                    $('#cheque_number_section').show();
                    $('#type_section').hide();
                    $('#balance_transfer_section').hide();
                }
            });

            $('#type').on('change', function(){
                var type = $('#type').val();
                if (type == 1) {
                    $('#cheque_number_section').show();
                    $('#balance_transfer_section').hide();
                }
                else if (type == 2) {
                    $('#balance_transfer_section').show();
                    $('#cheque_number_section').hide();
                }
                else {
                    $('#balance_transfer_section').hide();
                    $('#cheque_number_section').hide();
                }
            });

        </script>

    @endpush
@endsection

