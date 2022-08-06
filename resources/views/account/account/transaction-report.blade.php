@extends('layouts.main')
@section('title', 'Account')
@section('content')
    <!-- push external head elements to head -->
    @push('head')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
    @endpush

    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-Account bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Account')}}</h5>
                            <span>{{ __('List of Account')}}</span>
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
                                <a href="#">{{ __('Account')}}</a>
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
                    <div class="card-header"><h3>{{ __('Account')}}</h3></div>
                    <div class="card-body">
                        <table id="dataTable" class="table table-hover table-bordered table-responsive">
                            <thead>
                            <tr>
                                <th width="2%">Sl#</th>
                                <th>Date</th>
                                <th>Purpose</th>
                                <th>Cash in</th>
                                <th>Cash Out</th>
                                <th>Post Balance</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($transactions as $key => $transaction)

                                {{--<tr>--}}
                                    {{--<td>{{$loop->iteration}}</td>--}}
                                    {{--<td>--}}
                                        {{--{{ $transaction->date->format('d M, Y') }}--}}
                                    {{--</td>--}}
                                    {{--@if($transaction->purpose == 0)--}}
                                        {{--<td>--}}
                                            {{--Initial Balance--}}
                                        {{--</td>--}}

                                        {{--<td>--}}
                                            {{--{{$transaction->post_balance}}--}}
                                        {{--</td>--}}
                                        {{--<td>0</td>--}}

                                        {{--<td>{{$transaction->post_balance}}</td>--}}


                                    {{--@elseif($transaction->purpose == 1)--}}
                                        {{--<td>--}}
                                            {{--Withdraw--}}
                                        {{--</td>--}}
                                        {{--<td>--}}
                                            {{--0--}}
                                        {{--</td>--}}
                                        {{--<td>{{$transaction->amount}}</td>--}}

                                        {{--<td>{{$transaction->post_balance}}</td>--}}

                                    {{--@elseif($transaction->purpose == 2)--}}
                                        {{--<td>--}}
                                            {{--Deposit--}}
                                        {{--</td>--}}
                                        {{--<td>--}}
                                            {{--{{$transaction->amount}}--}}
                                        {{--</td>--}}
                                        {{--<td>0</td>--}}

                                        {{--<td>{{$transaction->post_balance}}</td>--}}
                                    {{--@elseif($transaction->purpose == 3)--}}
                                        {{--<td>--}}
                                            {{--Received Payment--}}
                                        {{--</td>--}}
                                        {{--<td>--}}
                                            {{--{{$transaction->amount}}--}}
                                        {{--</td>--}}
                                        {{--<td>0</td>--}}

                                        {{--<td>{{$transaction->post_balance}}</td>--}}
                                    {{--@endif--}}

                                {{--</tr>--}}

                                <tr>
                                    <td>{{ $loop->iteration  }}</td>
                                    <td>{{ $transaction->date->format('d M, Y') }}</td>
                                    @if($transaction->purpose == 0)
                                        <td>Initial Balance</td>
                                        <td>{{ number_format($transaction->amount, 2) }}</td>
                                        <td>0</td>
                                        <td>{{ number_format(($transaction->amount), 2) }}</td>
                                    @elseif($transaction->purpose == 1)
                                        <td>Withdraw</td>
                                        <td>0</td>
                                        <td>{{ number_format($transaction->amount, 2) }}</td>
                                        <td>{{ number_format(($balance -= $transaction->amount), 2) }}</td>
                                    @elseif($transaction->purpose == 2)
                                        <td>Deposit</td>
                                        <td>{{ number_format($transaction->amount, 2) }}</td>
                                        <td>0</td>
                                        <td>{{ number_format(($balance += $transaction->amount), 2) }}</td>
                                    @elseif($transaction->purpose == 3)
                                        <td>Received Payment</td>
                                        <td>{{ number_format($transaction->amount, 2) }}</td>
                                        <td>0</td>
                                        <td>{{ number_format(($balance += $transaction->amount), 2) }}</td>
                                    @elseif($transaction->purpose == 4)
                                        <td>Given Payment</td>
                                        <td>0</td>
                                        <td>{{ number_format($transaction->amount, 2) }}</td>
                                        <td>{{ number_format(($balance -= $transaction->amount), 2) }}</td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- push external js -->
    @push('script')
        <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
        <script>
            $('#dataTable').DataTable({});
        </script>
    @endpush
@endsection
