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

            $('#dataTable').DataTable({
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                processing: true,
                serverSide: true,
                responsive: true,
                order: [[ 1, "DESC" ]],
                language: {
                    processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i><span class="sr-only">Loading...</span>'
                },
                ajax: {
                    url: "{{route('get.accounts.transactions.reports')}}",
                    dataType: "json",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        account_id: "{{$account->id}}"
                    }
                },
                columns: [
                    { data: "id" },
                    { data: "date" },
                    { data: "purpose" },
                    { data: "cash_in" },
                    { data: "cash_out" },
                    { data: "balance" }
                ],
                columnDefs: [{
                    targets: [5],
                    orderable: false
                }]
            });

        </script>

    @endpush
@endsection
