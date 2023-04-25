@extends('admin.layouts.admin')

@section('content')
<main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> Dashboard</h1>
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
      </ul>
    </div>
    <div class="row">

      <div class="col-md-6 col-lg-3">
        <div class="widget-small info coloured-icon"><i class="icon fa fa-money fa-3x"></i>
          <div class="info">
            <h4>Total Balance</h4>
            <p><b>{{\App\Models\Account::sum('amount')}}</b></p>
          </div>
        </div>
      </div>

      @foreach (\App\Models\Account::all() as $key => $acc)
      <div class="col-md-6 col-lg-3">
        <div class="widget-small primary coloured-icon"><i class="icon fa fa-money fa-3x"></i>
          <div class="info">
            <h4>{{$acc->name}} Amount</h4>
            <p><b>{{$acc->amount}}</b></p>
          </div>
        </div>
      </div>
      @endforeach

      {{-- <div class="col-md-6 col-lg-3">
        <div class="widget-small primary coloured-icon"><i class="icon fa fa-users fa-3x"></i>
          <div class="info">
            <h4>Cash Amount</h4>
            <p><b>{{\App\Models\Balance::where('id',1)->first()->cash}}</b></p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="widget-small info coloured-icon"><i class="icon fa fa-thumbs-o-up fa-3x"></i>
          <div class="info">
            <h4>National Bank</h4>
            <p><b>{{\App\Models\Balance::where('id',1)->first()->national_bank}}</b></p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="widget-small warning coloured-icon"><i class="icon fa fa-files-o fa-3x"></i>
          <div class="info">
            <h4>Pubali Bank</h4>
            <p><b>{{\App\Models\Balance::where('id',1)->first()->pubali_bank}}</b></p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="widget-small danger coloured-icon"><i class="icon fa fa-star fa-3x"></i>
          <div class="info">
            <h4>Others Bank</h4>
            <p><b>{{\App\Models\Balance::where('id',1)->first()->other_bank}}</b></p>
          </div>
        </div>
      </div> --}}
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="tile">
          <h3 class="tile-title">Daily Sales</h3>
          
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
                        @foreach (\App\Models\Sale::where('date', date('Y-m-d'))->get() as $key => $data)
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
            </table>
        </div>
        
        </div>
      </div>
      <div class="col-md-6">
        <div class="tile">
          <h3 class="tile-title">Monthly Sales</h3>

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
                        @foreach (\App\Models\Sale::whereMonth('date', Carbon::now()->month)->get() as $key => $data)
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
            </table>
        </div>
          
        </div>
      </div>

      <div class="col-md-6">
        <div class="tile">
          <h3 class="tile-title">Daily Transaction</h3>
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
                        @foreach (\App\Models\Transaction::where('date', date('Y-m-d'))->get() as $key => $data)
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
                        <td style="text-align: center">{{$data->amount}}</td>
                    </tr>
                    @endforeach
                    </tbody>
            </table>
        </div>
          
        
        </div>
      </div>

      <div class="col-md-6">
        <div class="tile">
          <h3 class="tile-title">Monthly Transaction</h3>
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
                        @foreach (\App\Models\Transaction::whereMonth('date', Carbon::now()->month)->get() as $key => $data)
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
                        <td style="text-align: center">{{$data->amount}}</td>
                    </tr>
                    @endforeach
                    </tbody>
            </table>
        </div>
          
        
        </div>
      </div>


    </div>
  </main>
@endsection

@section('script')

<script type="text/javascript">
  $(document).ready(function() {
      $("#dashboard").addClass('active');
  });
</script>
    
@endsection
