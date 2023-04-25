<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Balance;
Use Image;
use Illuminate\support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TransactionController extends Controller
{
    public function index()
    {
        $data = Transaction::orderby('id','DESC')->get();
        return view('admin.transaction.index',compact('data'));
    }
    
    public function store(Request $request)
    {

        if(empty($request->type)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Transaction Type \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        if(empty($request->account_id)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Account Name \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        if(empty($request->amount)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Amount \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }


        $data = new Transaction();
        $data->date = $request->date;
        $data->description = $request->description;
        $data->type = $request->type;
        $data->account_id = $request->account_id;
        $data->transfer_from = $request->transfer_from;
        $data->amount = $request->amount;
        $data->status = "1";
        $data->created_by = Auth::user()->id;
        if ($data->save()) {
            if ($request->type == 1) {
                $balance = Account::find($request->account_id);
                $balance->amount = $balance->amount + $request->amount;
                $balance->save();
            } elseif ($request->type == 4) {
                // reduce from account 
                $reducebalance = Account::find($request->transfer_from);
                $reducebalance->amount = $reducebalance->amount - $request->amount;
                $reducebalance->save();
                // add to account
                $addbalance = Account::find($request->account_id);
                $addbalance->amount = $addbalance->amount + $request->amount;
                $addbalance->save();
            }else {
                $balance = Account::find($request->account_id);
                $balance->amount = $balance->amount - $request->amount;
                $balance->save();
            }
            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data Created Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
        } else {
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        }
    }

    public function edit($id)
    {
        $where = [ 'id'=>$id ];
        $info = Transaction::where($where)->get()->first();
        return response()->json($info);
    }

    public function update(Request $request, $id)
    {
        if(empty($request->type)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Transaction Type \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        if(empty($request->account_id)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Account Name \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        if(empty($request->amount)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Amount \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        $prevtran = Transaction::where('id', $id)->first();

        if ($prevtran->type == 1) {
            $prevbalance = Account::find($prevtran->account_id);
            $prevbalance->amount = $prevbalance->amount - $prevtran->amount;
            $prevbalance->save();
        } elseif ($prevtran->type == 4) {
            // reduce from account 
            $prevreducebalance = Account::find($prevtran->transfer_from);
            $prevreducebalance->amount = $prevreducebalance->amount + $prevtran->amount;
            $prevreducebalance->save();
            // add to account
            $prevaddbalance = Account::find($prevtran->account_id);
            $prevaddbalance->amount = $prevaddbalance->amount - $prevtran->amount;
            $prevaddbalance->save();
        }else {
            $prevbalance = Account::find($prevtran->account_id);
            $prevbalance->amount = $prevbalance->amount + $prevtran->amount;
            $prevbalance->save();
        }
        
        $data = Transaction::find($id);
        $data->date = $request->date;
        $data->description = $request->description;
        $data->type = $request->type;
        $data->account_id = $request->account_id;
        $data->transfer_from = $request->transfer_from;
        $data->amount = $request->amount;
        $data->status = "1";
        $data->updated_by = Auth::user()->id;
        if ($data->save()) {

            if ($request->type == 1) {
                $balance = Account::find($request->account_id);
                $balance->amount = $balance->amount + $request->amount;
                $balance->save();
            } elseif ($request->type == 4) {
                // reduce from account 
                $reducebalance = Account::find($request->transfer_from);
                $reducebalance->amount = $reducebalance->amount - $request->amount;
                $reducebalance->save();
                // add to account
                $addbalance = Account::find($request->account_id);
                $addbalance->amount = $addbalance->amount + $request->amount;
                $addbalance->save();
            }else {
                $balance = Account::find($request->account_id);
                $balance->amount = $balance->amount - $request->amount;
                $balance->save();
            }

            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data Updated Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
        }else{
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        }
    }

    
}
