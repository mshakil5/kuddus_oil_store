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
                <h1><i class="fa fa-dashboard"></i> Transaction</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            </ul>
        </div>
        <div id="addThisFormContainer">
            <div class="row">
                <div class="col-md-3">
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3>New Transaction</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="ermsg">
                                </div>
                                <div class="container">
                                    {!! Form::open(['url' => 'admin/master/create','id'=>'createThisForm']) !!}
                                    {!! Form::hidden('codeid','', ['id' => 'codeid']) !!}
                                    @csrf
                                    <div>
                                        <label for="date">Date</label>
                                        <input type="date" id="date" name="date" value="{{date('Y-m-d')}}" class="form-control">
                                    </div>
                                    <div id="tTypeDiv">
                                        <label for="type">Transaction Type</label>
                                        <select class="form-control" id="type" name="type">
                                            <option value="">Select</option>
                                            <option value="1">Deposit</option>
                                            <option value="2">Pay Order</option>
                                            <option value="3">Expense</option>
                                            <option value="4">Transfer</option>
                                        </select>
                                    </div>
                                    <div id="transferDiv">
                                        <label for="source">Transfer From</label>
                                        <select  id="transfer_from" name="transfer_from" class="form-control">
                                            <option value="">Select</option>
                                            <option value="1">Cash</option>
                                            <option value="2">National Bank</option>
                                            <option value="3">Pubali Bank</option>
                                            <option value="4">Others Bank</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="source">Accounts Name</label>
                                        <select  id="source" name="source" class="form-control">
                                            <option value="">Select</option>
                                            <option value="1">Cash</option>
                                            <option value="2">National Bank</option>
                                            <option value="3">Pubali Bank</option>
                                            <option value="4">Others Bank</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="description">Description</label>
                                        <input type="text" id="description" name="description" class="form-control">
                                    </div>
                                    <div>
                                        <label for="amount">Amount</label>
                                        <input type="number" id="amount" name="amount" class="form-control">
                                    </div>
                                    <hr>
                                    <input type="button" id="addBtn" value="Create" class="btn btn-primary">
                                    <input type="button" id="FormCloseBtn" value="Close" class="btn btn-warning">
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
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
                            <h3> All Data</h3>
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
                                        <th style="text-align: center">Action</th>
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
                                                @if ($data->transfer_from == 1)
                                                Cash
                                                @elseif ($data->transfer_from == 2)
                                                National Bank
                                                @elseif ($data->transfer_from == 3)
                                                Pubali Bank
                                                @elseif ($data->transfer_from == 4)
                                                Others Bank
                                                @else
                                                @endif
                                            </td>
                                            <td style="text-align: center">
                                                @if ($data->source == 1)
                                                Cash
                                                @elseif ($data->source == 2)
                                                National Bank
                                                @elseif ($data->source == 3)
                                                Pubali Bank
                                                @else
                                                Others Bank
                                                @endif
                                            </td>
                                            <td style="text-align: center">{{$data->amount}}</td>
                                            
                                            <td style="text-align: center">
                                                @if (isset($data->sale_id))
                                                    
                                                @else
                                                <a id="EditBtn" rid="{{$data->id}}"><i class="fa fa-edit" style="color: #2196f3;font-size:16px;"></i></a>
                                                    
                                                @endif

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
        $(function() {
            $('#transferDiv').hide(); 
            $('#type').change(function(){
                if($('#type').val() == '4') {
                    $('#transferDiv').show(); 
                } else {
                    $('#transfer_from').val(""); 
                    $('#transferDiv').hide(); 
                } 
            });
        });

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
            var url = "{{URL::to('/admin/transaction')}}";
            // console.log(url);
            $("#addBtn").click(function(){
            //   alert("#addBtn");
                if($(this).val() == 'Create') {
                    var form_data = new FormData();
                    form_data.append("date", $("#date").val());
                    form_data.append("description", $("#description").val());
                    form_data.append("type", $("#type").val());
                    form_data.append("source", $("#source").val());
                    form_data.append("amount", $("#amount").val());
                    form_data.append("transfer_from", $("#transfer_from").val());
                    $.ajax({
                      url: url,
                      method: "POST",
                      contentType: false,
                      processData: false,
                      data:form_data,
                      success: function (d) {
                          if (d.status == 303) {
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
                    form_data.append("description", $("#description").val());
                    form_data.append("type", $("#type").val());
                    form_data.append("source", $("#source").val());
                    form_data.append("amount", $("#amount").val());
                    form_data.append("transfer_from", $("#transfer_from").val());
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
                $("#date").val(data.date);
                $("#description").val(data.description);
                $("#type").val(data.type);
                $("#source").val(data.source);
                $("#amount").val(data.amount);
                $("#transfer_from").val(data.transfer_from);
                $("#codeid").val(data.id);
                $("#addBtn").val('Update');
                $("#addThisFormContainer").show(300);
                $("#newBtn").hide(100);
            }
            function clearform(){
                $('#createThisForm')[0].reset();
                $("#addBtn").val('Create');
            }

        });

        $(document).ready(function () {
            $('#example').DataTable();
        });

        

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
            $("#transaction").addClass('active');
        });
    </script>
@endsection
