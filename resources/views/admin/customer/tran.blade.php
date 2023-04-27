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
                            <div class="ermsg">
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="container">
                                    {!! Form::open(['url' => 'admin/master/create','id'=>'createThisForm']) !!}
                                    {!! Form::hidden('codeid','', ['id' => 'codeid']) !!}
                                    @csrf
                                    <div>
                                        <label for="date">Date</label>
                                        <input type="date" id="date" name="date" value="{{date('Y-m-d')}}" class="form-control">
                                        <input type="hidden" id="customer_id" name="customer_id" class="form-control">
                                    </div>
                                    <div id="tTypeDiv">
                                        <label for="type">Transaction Type</label>
                                        <select class="form-control" id="type" name="type">
                                            <option value="">Select</option>
                                            <option value="1">Deposit</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="account_id">Accounts Name</label>
                                        <select id="account_id" name="account_id" class="form-control">
                                            <option value="">Select</option>
                                            @foreach (\App\Models\Account::all() as $account)
                                            <option value="{{ $account->id }}">{{ $account->name }}</option>
                                            @endforeach
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
        <a href="{{route('admin.customer')}}" id="backBtn" class="btn btn-info">Back</a>
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
                                                    Deposit
                                            </td>
                                            <td style="text-align: center">
                                                {{$data->account->name}}
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
            var upurl = "{{URL::to('/admin/customer-tran-update')}}";
            // console.log(url);
            $("#addBtn").click(function(){
            //   alert("#addBtn");
                
                //Update
                if($(this).val() == 'Update'){
                    var form_data = new FormData();
                    form_data.append("date", $("#date").val());
                    form_data.append("description", $("#description").val());
                    form_data.append("type", $("#type").val());
                    form_data.append("account_id", $("#account_id").val());
                    form_data.append("amount", $("#amount").val());
                    form_data.append("customer_id", $("#customer_id").val());
                    form_data.append("codeid", $("#codeid").val());
                    $.ajax({
                        url:upurl,
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
             
            function populateForm(data){
                $("#date").val(data.date);
                $("#description").val(data.description);
                $("#type").val(data.type);
                $("#account_id").val(data.account_id);
                $("#amount").val(data.amount);
                $("#customer_id").val(data.customer_id);
                $("#codeid").val(data.id);
                $("#addBtn").val('Update');
                $("#addThisFormContainer").show(300);
                $("#newBtn").hide(100);
                $("#backBtn").hide(100);
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
            $("#customer").addClass('active');
        });
    </script>
@endsection
