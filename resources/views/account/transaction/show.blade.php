@extends('layouts.main')
@section('title', 'Transaction Details')
@section('content')
    <!-- push external head elements to head -->
    @push('head')

    @endpush


    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-users bg-blue"></i>
                        <div class="d-inline">
                            <h5>Transaction Details</h5>
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
                                <a href="#">{{ __('Transaction')}}</a>
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
                    <div class="card-body">
                        <table class="table table-hover">

                            <tbody>
                            <tr>
                                <th>Date</td>
                                <td>{{ $transaction->date->format('d M, Y') }}</td>
                            </tr>
                            <tr>
                                <td>Account</td>
                                <td>
                                    {{
                                        isset($transaction->accounts->first()->account_no)
                                        ? $transaction->accounts->first()->account_no
                                        : '-'
                                    }}
                                </td>
                            </tr>
                            <tr>
                                <td>Bank </td>
                                <td>
                                    {{
                                        isset($transaction->accounts->first()->bank->first()->name)
                                            ? $transaction->accounts->first()->bank->first()->name
                                            : '-'

                                    }}
                                </td>
                            </tr>
                            <tr>
                                <td>Branch </td>
                                <td>
                                    {{
                                        isset($transaction->accounts->first()->branch_name)
                                        ? $transaction->accounts->first()->branch_name
                                        : '-'

                                    }}
                                </td>
                            </tr>
                            <tr>
                                <td>Amount</td>
                                <td>{{ $transaction->amount }}</td>
                            </tr>
                            @if($transaction->purpose == 1)
                                <tr>
                                    <td>Purpose</td>
                                    <td>Withdraw</td>
                                </tr>
                                <tr>
                                    <td>Cheque</td>
                                    <td>{{ $transaction->cheque_number }}</td>
                                </tr>
                            @elseif($transaction->purpose == 2)
                                <tr>
                                    <td>Purpose</td>
                                    <td>Deposit</td>
                                </tr>
                                <tr>
                                    <td>Cheque</td>
                                    <td>{{ $transaction->cheque_number }}</td>
                                </tr>
                            @elseif($transaction->purpose == 3)
                                <tr>
                                    <td>Purpose</td>
                                    <td>Received Payment</td>
                                </tr>
                                @if($transaction->type == 1)
                                    <tr>
                                        <td>Cheque</td>
                                        <td>{{ $transaction->cheque_number }}</td>
                                    </tr>
                                @else
                                    <tr>
                                        <td>Balance Transfer Information</td>
                                        <td>{{ $transaction->balance_transfer_info }}</td>
                                    </tr>
                                @endif
                            @elseif($transaction->purpose == 4)
                                <tr>
                                    <td>Purpose</td>
                                    <td>Given Payment</td>
                                </tr>
                                @if($transaction->type == 1)
                                    <tr>
                                        <td>Cheque</td>
                                        <td>{{ $transaction->cheque_number }}</td>
                                    </tr>
                                @else
                                    <tr>
                                        <td>Balance Transfer Information</td>
                                        <td>{{ $transaction->balance_transfer_info }}</td>
                                    </tr>
                                @endif
                            @endif

                            <tr>
                                <td>Created By</td>
                                <td>{{ $transaction->createdBy->first()->name }}</td>
                            </tr>
                            @if(isset($transaction->updatedBy->first()->name))
                                <tr>
                                    <td>Updated By</td>
                                    <td>{{ $transaction->updatedBy->first()->name }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td>Remarks</td>
                                <td>{{ $transaction->remarks }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- push external js -->
    @push('script')


    @endpush
@endsection
