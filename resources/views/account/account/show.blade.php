@extends('layouts.main')
@section('title', 'Account Details')
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
                            <h5>Account Details</h5>
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
                                <a href="#">{{ __('label.Account_DETAILS')}}</a>
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
                        <table class="table">
                            <thead>
                            <tr>

                            </tr>
                            </thead>

                            <tbody>
                            <tr>
                                <td>Account number</td>
                                <td>{{ $account->account_no}}</td>
                            </tr>

                            <tr>
                                <td>Bank</td>
                                <td>
                                    {{
                                        isset($account->bank->first()->name)
                                            ? $account->bank->first()->name
                                            : '-'

                                    }}
                                </td>
                            </tr>
                            <tr>
                                <td>Branch</td>
                                <td>
                                   {{$account->branch_name}}
                                </td>
                            </tr>
                            <tr>
                                <td>Initial balance</td>
                                <td>{{ $account->initial_balance }}</td>
                            </tr>
                            <tr>
                                <td>Total Balance</td>
                                <td>{{ $account->balance }}</td>
                            </tr>

                            <tr>
                                <td>Created By</td>
                                <td>{{ $account->createdBy->first()->name }}</td>
                            </tr>
                            @if(isset($account->updatedBy->first()->name))
                                <tr>
                                    <td>Updated By</td>
                                    <td>{{ $account->updatedBy->first()->name }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td>Remarks</td>
                                <td>{{ $account->remarks }}</td>
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
