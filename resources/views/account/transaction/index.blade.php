@extends('layouts.main')
@section('title', 'Transaction')
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
                        <i class="ik ik-Transaction bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Transaction')}}</h5>
                            <span>{{ __('List of Transaction')}}</span>
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
                        <table id="dataTable" class="table table-hover table-bordered table-responsive">
                            <thead>
                            <tr>
                                <th width="2%">Sl#</th>
                                <th>Date</th>
                                <th>Account</th>
                                <th>Purpose</th>
                                <th>Amount</th>
                                <th width="15%">Actions</th>
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
                    url: "{{route('getTransactionList')}}",
                    dataType: "json",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}"
                    }
                },
                columns: [
                    { data: "id" },
                    { data: "date" },
                    { data: "account_id" },
                    { data: "purpose" },
                    { data: "amount" },
                    { data: "actions" }
                ],
                columnDefs: [{
                    targets: [5],
                    orderable: false
                }]
            });



            $('#dataTable').on('click', '.btn-delete[data-remote]', function (e) {
                e.preventDefault();
                let url = $(this).data('remote');
                if (confirm('are you sure you want to delete this?')) {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        dataType: 'json',
                        data: {submit: true, _method: 'delete', _token: "{{ csrf_token() }}"}
                    }).always(function (data) {
                        $('#dataTable').DataTable().draw(false);
                    });
                }
            });

        </script>

    @endpush
@endsection
