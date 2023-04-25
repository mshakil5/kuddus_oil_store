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
                <h1><i class="fa fa-dashboard"></i> Sales</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            </ul>
        </div>
        <div id="addThisFormContainer">
            <div class="row">
                <div class="col-md-2">
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3>New Sales</h3>
                        </div>
                        <div class="card-body">
                            <div class="ermsg"></div>
                            <div class="row">
                                    <div class="col-md-6">
                                        {!! Form::open(['url' => 'admin/master/create','id'=>'createThisForm']) !!}
                                        {!! Form::hidden('codeid','', ['id' => 'codeid']) !!}
                                        @csrf
                                        <div>
                                            <label for="date">Date</label>
                                            <input type="date" id="date" name="date" value="{{date('Y-m-d')}}" class="form-control">
                                        </div>
                                        <div>
                                            <label for="customer_id">Customer</label>
                                            <select name="customer_id" id="customer_id" class="form-control">
                                                <option value="">Select</option>
                                                @foreach (\App\Models\Customer::all() as $customer)
                                                    <option value="{{$customer->id}}">{{$customer->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                        <div>
                                            <label for="cbalance">Balance</label>
                                            <input type="number" id="cbalance" name="cbalance" class="form-control" readonly>
                                        </div>
                                        <div>
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

                                        <div>
                                            <label for="company">Company</label>
                                            <select  id="company" name="company" class="form-control">
                                                <option value="">Select</option>
                                                <option value="1">Padma</option>
                                                <option value="2">Meghna</option>
                                                <option value="3">Jomuna</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="car_number">Car No</label>
                                            <input type="text" id="car_number" name="car_number" class="form-control">
                                        </div>

                                        <div>
                                            <label for="product_take">Name Entry</label>
                                            <input type="text" id="product_take" name="product_take" class="form-control">
                                        </div>
                                    </div>
    
                                        <div class="col-md-6">

                                            <div>
                                                <label for="account_id">Account Name</label>
                                                
                                                <select id="account_id" name="account_id" class="form-control">
                                                    <option value="">Select</option>
                                                    @foreach (\App\Models\Account::all() as $account)
                                                    <option value="{{ $account->id }}">{{ $account->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
        
                                            <div>
                                                <label for="quantity">Quantity</label>
                                                <input type="number" id="quantity" name="quantity" min="0" class="form-control">
                                            </div>
                                            <div>
                                                <label for="price_per_unit">Price Per Unit</label>
                                                <input type="number" id="price_per_unit" name="price_per_unit" min="0" class="form-control">
                                            </div>
                                            
                                            <div>
                                                <label for="amount">Total Amount</label>
                                                <input type="number" id="amount" name="amount" min="0" class="form-control" readonly>
                                            </div>
                                            <div>
                                                <label for="cash_rcv">Cash Received</label>
                                                <input type="number" id="cash_rcv" name="cash_rcv" min="0" class="form-control">
                                            </div>
                                            <div>
                                                <label for="due">Due</label>
                                                <input type="number" id="due" name="due" min="0" class="form-control" readonly>
                                            </div>

                                            
                                            <div>
                                                <label for="description">Description</label>
                                                <input type="text" id="description" name="description" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <hr>
                                        <input type="button" id="addBtn" value="Create" class="btn btn-primary">
                                        <input type="button" id="FormCloseBtn" value="Close" class="btn btn-warning">
                                        {!! Form::close() !!}
                                        </div>
                                        
    
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                </div>
            </div>
        </div>
        <button id="newBtn" type="button" class="btn btn-info">Add New</button>
        <hr>
        <div id="contentContainer">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3> All Sales</h3>
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
                                        <th style="text-align: center">Action</th>
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
                                            <td style="text-align: center">
                                            <a id="EditBtn" rid="{{$data->id}}"><i class="fa fa-edit" style="color: #2196f3;font-size:16px;"></i></a>
                                            {{-- <a id="deleteBtn" rid="{{$data->id}}"><i class="fa fa-trash-o" style="color: red;font-size:16px;"></i></a> --}}
                                            </td>
                                        </tr>
                                        @endforeach
                                        </tbody>
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
        $(document).ready(function () {
            $("#addThisFormContainer").hide();
            $("#newBtn").click(function(){
                clearform();
                $("#newBtn").hide(100);
                $("#addThisFormContainer").show(300);

            });
            $("#FormCloseBtn").click(function(){
                $("#addThisFormContainer").hide(200);
                $("#newBtn").show(100);
                clearform();
            });
            //header for csrf-token is must in laravel
            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
            //
            var url = "{{URL::to('/admin/sale')}}";
            // console.log(url);
            $("#addBtn").click(function(){
            //   alert("#addBtn");
                if($(this).val() == 'Create') {
                    var form_data = new FormData();
                    form_data.append("date", $("#date").val());
                    form_data.append("customer_id", $("#customer_id").val());
                    form_data.append("product_id", $("#product_id").val());
                    form_data.append("company", $("#company").val());
                    form_data.append("car_number", $("#car_number").val());
                    form_data.append("product_take", $("#product_take").val());
                    form_data.append("account_id", $("#account_id").val());
                    form_data.append("quantity", $("#quantity").val());
                    form_data.append("amount", $("#amount").val());
                    form_data.append("cash_rcv", $("#cash_rcv").val());
                    form_data.append("due", $("#due").val());
                    form_data.append("price_per_unit", $("#price_per_unit").val());
                    form_data.append("description", $("#description").val());
                    $.ajax({
                      url: url,
                      method: "POST",
                      contentType: false,
                      processData: false,
                      data:form_data,
                      success: function (d) {
                          if (d.status == 303) {
                            pagetop();
                              $(".ermsg").html(d.message);
                          }else if(d.status == 300){
                            success("Data Insert Successfully!!");
                            window.setTimeout(function(){location.reload()},2000)
                          }
                      },
                      error: function (d) {
                          console.log(d);
                      }
                  });
                }
                //create  end
                //Update
                if($(this).val() == 'Update'){
                    var form_data = new FormData();
                    form_data.append("date", $("#date").val());
                    form_data.append("customer_id", $("#customer_id").val());
                    form_data.append("product_id", $("#product_id").val());
                    form_data.append("company", $("#company").val());
                    form_data.append("car_number", $("#car_number").val());
                    form_data.append("product_take", $("#product_take").val());
                    form_data.append("account_id", $("#account_id").val());
                    form_data.append("quantity", $("#quantity").val());
                    form_data.append("amount", $("#amount").val());
                    form_data.append("cash_rcv", $("#cash_rcv").val());
                    form_data.append("due", $("#due").val());
                    form_data.append("price_per_unit", $("#price_per_unit").val());
                    form_data.append("description", $("#description").val());
                    form_data.append('_method', 'put');
                    $.ajax({
                        url:url+'/'+$("#codeid").val(),
                        type: "POST",
                        dataType: 'json',
                        contentType: false,
                        processData: false,
                        data:form_data,
                        success: function(d){
                            console.log(d);
                            if (d.status == 303) {
                                $(".ermsg").html(d.message);
                                pagetop();
                            }else if(d.status == 300){
                                pagetop();
                                success("Data Update Successfully!!");
                                window.setTimeout(function(){location.reload()},2000)
                            }
                        },
                        error:function(d){
                            console.log(d);
                        }
                    });
                }
                //Update
            });
            //Edit
            $("#contentContainer").on('click','#EditBtn', function(){
                //alert("btn work");
                codeid = $(this).attr('rid');
                //console.log($codeid);
                info_url = url + '/'+codeid+'/edit';
                //console.log($info_url);
                $.get(info_url,{},function(d){
                    populateForm(d);
                    pagetop();
                });
            });
            //Edit  end
            //Delete 
            $("#contentContainer").on('click','#deleteBtn', function(){
                var dataid = $(this).attr('rid');
                var info_url = url + '/'+dataid;
                swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this imaginary file!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel plx!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                }, function(isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                            url:info_url,
                            method: "GET",
                            type: "DELETE",
                            data:{
                            },
                            success: function(d){
                                if(d.success) {
                                    swal("Deleted!", "Your imaginary file has been deleted.", "success");     
                                    location.reload();
                                }
                            },
                            error:function(d){
                                console.log(d);
                            }
                        });
                    } else {
                        swal("Cancelled", "Your imaginary file is safe :)", "error");
                    }
                });
            });
            //Delete  
            function populateForm(data){
                $("#date").val(data.info.date);
                $("#customer_id").val(data.info.customer_id);
                $("#cbalance").val(data.customer.balance);
                $("#product_id").val(data.info.product_id);
                $("#company").val(data.info.company);
                $("#car_number").val(data.info.car_number);
                $("#product_take").val(data.info.product_take);
                $("#account_id").val(data.info.account_id);
                $("#quantity").val(data.info.quantity);
                $("#cash_rcv").val(data.info.cash_rcv);
                $("#amount").val(data.info.amount);
                $("#price_per_unit").val(data.info.price_per_unit);
                $("#due").val(data.info.due);
                $("#description").val(data.info.description);
                $("#codeid").val(data.info.id);
                $("#addBtn").val('Update');
                $("#addThisFormContainer").show(300);
                $("#newBtn").hide(100);
            }
            function clearform(){
                $('#createThisForm')[0].reset();
                $("#addBtn").val('Create');
            }

            // customer destails 
            var urlcustomer = "{{URL::to('/admin/getcustomer')}}";
            $("#customer_id").change(function(){
                    event.preventDefault();
                    var customer_id = $(this).val();
                    $.ajax({
                    url: urlcustomer,
                    method: "POST",
                    data: {customer_id:customer_id},

                    success: function (d) {
                        if (d.status == 303) {

                        }else if(d.status == 300){
                            $("#cbalance").val(d.balance);
                        }
                    },
                    error: function (d) {
                        console.log(d);
                    }
                });

            });

        });

        $(document).ready(function () {
            $('#example').DataTable();
        });

        //calculation end
        $("#quantity, #price_per_unit, #cash_rcv").keyup(function(){
            var price_per_unit = Number($("#price_per_unit").val());
            var quantity = Number($("#quantity").val());
            var cash_rcv = Number($("#cash_rcv").val());
            var total_amount = quantity * price_per_unit;
            var due_amount = total_amount - cash_rcv;
            $('#amount').val(total_amount.toFixed(2));
            if (total_amount > cash_rcv) {
                $('#due').val(due_amount.toFixed(2));
            } else {
                $('#due').val("0");
            }
        });
        //calculation end 

        

        

    </script>

    <script>
        function copyToClipboard(id) {
            document.getElementById(id).select();
            document.execCommand('copy');
            swal("Copied!");
        }
    </script>

    
    <script type="text/javascript">
        $(document).ready(function() {
            $("#sale").addClass('active');
        });
    </script>
@endsection
