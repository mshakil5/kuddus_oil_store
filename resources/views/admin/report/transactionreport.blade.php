@extends('admin.layouts.admin')
@section('content')
<style>
    table {
        border-collapse: collapse;
        border-spacing: 0;
        width: 100%;
        border: 1px solid #ddd;
    }
    th, td {
        text-align: left;
        padding: 8px;
    }
    tr:nth-child(even){background-color: #f2f2f2}
</style>
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-dashboard"></i>Transaction Report</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            </ul>
        </div>
        
        <div id="contentContainer">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <form  action="{{route('transactionReport.search')}}" method ="POST">
                                @csrf
                                <br>
                                <div class="container">
                                    <div class="row">
                                        <div class="container-fluid">
                                            <div class="form-group row">
                                                
                                                <div class="col-md-2">
                                                    <label for="fromDate">From Date</label>
                                                    <input type="date" class="form-control" id="fromDate" name="fromDate" required/>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="toDate">To Date</label>
                                                    <input type="date" class="form-control" id="toDate" name="toDate" value="{{date('Y-m-d')}}" required/>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="customer_id">Customer</label>
                                                    <select name="customer_id" id="customer_id" class="form-control">
                                                        <option value="">Select</option>
                                                        @foreach (\App\Models\Customer::all() as $customer)
                                                            <option value="{{$customer->id}}">{{$customer->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="type">Transaction Type</label>
                                                    <select class="form-control" id="type" name="type">
                                                        <option value="">Select</option>
                                                        <option value="1">Deposit</option>
                                                        <option value="2">Pay Order</option>
                                                        <option value="3">Expense</option>
                                                        <option value="4">Transfer</option>
                                                        <option value="Sales">Sales</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-2">
                                                    <label for="account_id">Account Name</label>
                                                    <select id="account_id" name="account_id" class="form-control">
                                                        <option value="">Select</option>
                                                        @foreach (\App\Models\Account::all() as $account)
                                                        <option value="{{ $account->id }}">{{ $account->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="submit" class="btn mt-4" name="search" title="Search"><img src="https://img.icons8.com/android/24/000000/search.png"/></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                            </form>
                        </div>
                        <div class="card-body">
                            
                            <div class="container"  style="overflow-x:auto;">
                                <table class="table table-bordered table-hover" id="example">
                                    <thead>
                                    <tr>
                                        <th style="text-align: center">ID</th>
                                        <th style="text-align: center">Date</th>
                                        <th style="text-align: center">Description</th>
                                        <th style="text-align: center">Transaction Type</th>
                                        <th style="text-align: center">Transfer From</th>
                                        <th style="text-align: center">Account Name</th>
                                        <th style="text-align: center">Amount</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $key => $data)
                                        <tr>
                                            <td style="text-align: center">{{ $key + 1 }}</td>
                                            <td style="text-align: center">{{$data->date}}</td>
                                            <td style="text-align: center">{{$data->description}}</td>
                                            <td style="text-align: center">
                                                @if ($data->type == 1)
                                                    Deposit
                                                @elseif ($data->type == 2)
                                                    Pay Order
                                                @elseif ($data->type == 3)
                                                    Expense
                                                @elseif ($data->type == 4)
                                                    Transfer
                                                @else
                                                    {{$data->type}}-
                                                    @if (isset(\App\Models\Sale::where('id',$data->sale_id)->first()->invoiceno)){{\App\Models\Sale::where('id',$data->sale_id)->first()->invoiceno}}
                                                    @endif
                                                @endif
                                            </td>
                                            <td style="text-align: center">
                                                @if (isset($data->transfer_from)){{\App\Models\Account::where('id',$data->transfer_from)->first()->name}}
                                                @endif
                                            </td>
                                            <td style="text-align: center">
                                                {{$data->account->name}}
                                            </td>
                                            <td style="text-align:right">{{$data->amount}}</td>
                                            
                                        </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th style="text-align:right"></th>
                                                <th style="text-align:right">Total:</th>
                                                <th style="text-align:right"></th>
                                            </tr>
                                        </tfoot>
                                </table>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('script')
    <script>

        $(document).ready(function() {
            var table = $('#example').DataTable( {
                lengthChange: false,
                buttons: [ 'excel', 'pdf' ],
                footerCallback: function (row, data, start, end, display) {
                    var api = this.api();
        
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                        return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
                    };
        
                    // Total over all pages
                    total = api
                        .column(6)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
        
                    // Total over this page
                    pageTotal = api
                        .column(6, { page: 'current' })
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
        
                    // Update footer
                    $(api.column(6).footer()).html(total);
                    // $(api.column(7).footer()).html('$' + pageTotal + ' ( $' + total + ' total)');
                },
            });
        
            table.buttons().container()
                .appendTo( '#example_wrapper .col-md-6:eq(0)' );
        });

    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#allreport").addClass('active');
            $("#allreport").addClass('is-expanded');
            $("#salesreport").addClass('active');
        });
    </script>
@endsection
