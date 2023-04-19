<?php

namespace App\Http\Controllers;

use App\Models\Balance;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\Transaction;
Use Image;
use Illuminate\support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SalesController extends Controller
{
    public function index()
    {
        $data = Sale::orderby('id','DESC')->get();
        return view('admin.sale.index',compact('data'));
    }
    
    public function store(Request $request)
    {

        if(empty($request->bank)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Bank Name \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        if($request->bank == "cash"){
            if ($request->due > 0) {
                $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Cash sales never allowed due amount. Please make full payment..!</b></div>";
                return response()->json(['status'=> 303,'message'=>$message]);
                exit();
            }
        }

        if(empty($request->customer_id)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Customer \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        if(empty($request->product_id)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Product \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        if(empty($request->company)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Company \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        if(empty($request->quantity)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Quantity \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        if(empty($request->price_per_unit)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Price per unit \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }


        $data = new Sale();
        $data->date = $request->date;
        $data->customer_id = $request->customer_id;
        $data->product_id = $request->product_id;
        $data->company = $request->company;
        $data->invoiceno = date('his');
        $data->car_number = $request->car_number;
        $data->product_take = $request->product_take;
        $data->bank = $request->bank;
        $data->quantity = $request->quantity;
        $data->amount = $request->amount;
        $data->cash_rcv = $request->cash_rcv;
        $data->price_per_unit = $request->price_per_unit;
        $data->due = $request->due;
        $data->description = $request->description;
        $data->status = "1";
        $data->created_by = Auth::user()->id;
        if ($data->save()) {

            $customer = Customer::find($request->customer_id);
            $customer->balance = $customer->balance + $request->cash_rcv - $request->amount;
            $customer->save();

            $balance = Balance::find(1);
                if ($request->bank == 'cash') {
                    $balance->cash = $balance->cash + $request->cash_rcv;
                }
                if ($request->bank == 'pubali_bank') {
                    $balance->pubali_bank = $balance->pubali_bank + $request->cash_rcv;
                }

                if ($request->bank == 'national_bank') {
                    $balance->national_bank = $balance->national_bank + $request->cash_rcv;
                }

                if ($request->bank == 'other_bank') {
                    $balance->other_bank = $balance->other_bank + $request->cash_rcv;
                }
            $balance->save();

            $tran = new Transaction();
            $tran->sale_id = $data->id;
            $tran->date = $request->date;
            $tran->description = $request->description;
            $tran->type = "Sales";
            if ($request->bank == 'cash') {
                $tran->source = "1";
            }
            if ($request->bank == 'pubali_bank') {
                $tran->source = "3";
            }

            if ($request->bank == 'national_bank') {
                $tran->source = "2";
            }

            if ($request->bank == 'other_bank') {
                $tran->source = "4";
            }
            $tran->amount = $request->amount;
            $tran->status = "1";
            $tran->created_by = Auth::user()->id;
            $tran->save();

            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data Created Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
        } else {
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        }
    }

    public function edit($id)
    {
        $where = [ 'id'=>$id ];
        $info = Sale::where($where)->get()->first();
        $customer = Customer::where('id', $info->customer_id)->first();
        return response()->json(['info'=> $info,'customer'=>$customer]);
        // return response()->json($info);
    }

    public function update(Request $request, $id)
    {

        if(empty($request->bank)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Bank Name \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        if($request->bank == "cash"){
            if ($request->due > 0) {
                $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Cash sales never allowed due amount. Please make full payment..!</b></div>";
                return response()->json(['status'=> 303,'message'=>$message]);
                exit();
            }
        }

        if(empty($request->customer_id)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Customer \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        if(empty($request->product_id)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Product \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        if(empty($request->company)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Company \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        if(empty($request->quantity)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Quantity \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        if(empty($request->price_per_unit)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Price per unit \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        $sales = Sale::where('id', $id)->first();
        $customer = Customer::find($request->customer_id);
        $customer->balance = $customer->balance - $sales->cash_rcv + $sales->amount;
        $customer->save();

        $balance = Balance::find(1);
            if ($sales->bank == 'cash') {
                $balance->cash = $balance->cash - $sales->cash_rcv;
            }
            if ($sales->bank == 'pubali_bank') {
                $balance->pubali_bank = $balance->pubali_bank - $sales->cash_rcv;
            }
            if ($sales->bank == 'national_bank') {
                $balance->national_bank = $balance->national_bank - $sales->cash_rcv;
            }
            if ($sales->bank == 'other_bank') {
                $balance->other_bank = $balance->other_bank - $sales->cash_rcv;
            }
        $balance->save();

        $data = Sale::find($id);
        $data->date = $request->date;
        $data->customer_id = $request->customer_id;
        $data->product_id = $request->product_id;
        $data->company = $request->company;
        $data->car_number = $request->car_number;
        $data->product_take = $request->product_take;
        $data->bank = $request->bank;
        $data->quantity = $request->quantity;
        $data->cash_rcv = $request->cash_rcv;
        $data->amount = $request->amount;
        $data->price_per_unit = $request->price_per_unit;
        $data->due = $request->due;
        $data->description = $request->description;
        $data->status = "1";
        $data->updated_by = Auth::user()->id;
        if ($data->save()) {

            $customerupdate = Customer::find($request->customer_id);
            $customerupdate->balance = $customerupdate->balance + $request->cash_rcv - $request->amount;
            $customerupdate->save();

            $balanceupdate = Balance::find(1);
                if ($request->bank == 'cash') {
                    $balanceupdate->cash = $balanceupdate->cash + $request->cash_rcv;
                }
                if ($request->bank == 'pubali_bank') {
                    $balanceupdate->pubali_bank = $balanceupdate->pubali_bank + $request->cash_rcv;
                }

                if ($request->bank == 'national_bank') {
                    $balanceupdate->national_bank = $balanceupdate->national_bank + $request->cash_rcv;
                }

                if ($request->bank == 'other_bank') {
                    $balanceupdate->other_bank = $balanceupdate->other_bank + $request->cash_rcv;
                }
            $balanceupdate->save();
            $tranid = Transaction::where('sale_id',$id)->first();
            $tran = Transaction::find($tranid->id);
            $tran->sale_id = $data->id;
            $tran->date = $request->date;
            $tran->description = $request->description;
            $tran->type = "Sales";
            if ($request->bank == 'cash') {
                $tran->source = "1";
            }
            if ($request->bank == 'pubali_bank') {
                $tran->source = "3";
            }

            if ($request->bank == 'national_bank') {
                $tran->source = "2";
            }

            if ($request->bank == 'other_bank') {
                $tran->source = "4";
            }
            $tran->amount = $request->amount;
            $tran->status = "1";
            $tran->updated_by = Auth::user()->id;
            $tran->save();

            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data Updated Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
        }else{
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        }
    }
}
