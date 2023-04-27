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
                <h1><i class="fa fa-dashboard"></i>Sales Report</h1>
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
                            <form  action="{{route('salesReport.search')}}" method ="POST">
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
                                                    <label for="product_id">Product</label>
                                                    <select  id="product_id" name="product_id" class="form-control">
                                                        <option value="">Select</option>
                                                        <option value="1">Octen</option>
                                                        <option value="2">Diesel</option>
                                                        <option value="3">Petrol</option>
                                                        <option value="4">Kerosene</option>
                                                        <option value="5">Mobil</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-2">
                                                    <label for="company">Company</label>
                                                    <select  id="company" name="company" class="form-control">
                                                        <option value="">Select</option>
                                                        <option value="1">Padma</option>
                                                        <option value="2">Meghna</option>
                                                        <option value="3">Jomuna</option>
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
                                        <th style="text-align: center">Sl</th>
                                        <th style="text-align: center">Date</th>
                                        <th style="text-align: center">Invoice No</th>
                                        <th style="text-align: center">Customer</th>
                                        <th style="text-align: center">Product</th>
                                        <th style="text-align: center">Company</th>
                                        <th style="text-align: center">Quantity</th>
                                        <th style="text-align: center">PPU</th>
                                        <th style="text-align: center">Amount</th>
                                        <th style="text-align: center">Due</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $key => $data)
                                        <tr>
                                            <td style="text-align: center">{{ $key + 1 }}</td>
                                            <td style="text-align: center">{{$data->date}}</td>
                                            <td style="text-align: center">{{$data->invoiceno}}</td>
                                            <td style="text-align: center">{{\App\Models\Customer::where('id',$data->customer_id)->first()->name}}  ({{\App\Models\Customer::where('id',$data->customer_id)->first()->balance}})</td>
                                            <td style="text-align: center">
                                                @if ($data->product_id == 1)
                                                 Octen 
                                                @elseif ($data->product_id == 2)
                                                 Diesel 
                                                @elseif ($data->product_id == 3) 
                                                Petrol 
                                                @elseif ($data->product_id == 4) 
                                                Kerosene
                                                @elseif ($data->product_id == 5) 
                                                Mobil
                                                @endif
                                            </td>
                                            <td style="text-align: center">
                                                @if ($data->company == 1) Padma @elseif ($data->company == 2) Meghna @elseif ($data->company == 3) Jomuna @endif
                                            </td>
                                            <td style="text-align: center">{{$data->quantity}}</td>
                                            <td style="text-align: center">{{$data->price_per_unit}}</td>
                                            <td style="text-align: center">{{$data->amount}}</td>
                                            <td style="text-align: center">{{$data->due}}</td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th style="text-align:right"></th>
                                                <th style="text-align:right">Total:</th>
                                                <th></th>
                                                <th></th>
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
                        .column(8)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
                    due = api
                        .column(9)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
        
                    // Total over this page
                    pageTotal = api
                        .column(8, { page: 'current' })
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
        
                    // Update footer
                    $(api.column(8).footer()).html(total);
                    $(api.column(9).footer()).html(due);
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
