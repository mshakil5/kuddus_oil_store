<?php

namespace App\Http\Controllers;

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
        $data = new Transaction();
        $data->date = $request->date;
        $data->description = $request->description;
        $data->type = $request->type;
        $data->source = $request->source;
        $data->transfer_from = $request->transfer_from;
        $data->amount = $request->amount;
        $data->status = "1";
        $data->created_by = Auth::user()->id;
        if ($data->save()) {
            $bid = 1;
            if ($request->type == 1) {
                $balance = Balance::find($bid);
                if ($request->source == 1) {
                    $balance->cash = $balance->cash + $request->amount;
                } 
                if ($request->source == 2) {
                    $balance->national_bank = $balance->national_bank + $request->amount;
                } 
                if ($request->source == 3) {
                    $balance->pubali_bank = $balance->pubali_bank + $request->amount;
                } 
                if ($request->source == 4) {
                    $balance->other_bank = $balance->other_bank + $request->amount;
                }
                $balance->save();
            } elseif ($request->type == 4) {

                $balance = Balance::find($bid);
                // reduce from account 
                if ($request->transfer_from == 1) {
                    $balance->cash = $balance->cash - $request->amount;
                } 
                if ($request->transfer_from == 2) {
                    $balance->national_bank = $balance->national_bank - $request->amount;
                } 
                if ($request->transfer_from == 3) {
                    $balance->pubali_bank = $balance->pubali_bank - $request->amount;
                } 
                if ($request->transfer_from == 4) {
                    $balance->other_bank = $balance->other_bank - $request->amount;
                }
                // add to account
                if ($request->source == 1) {
                    $balance->cash = $balance->cash + $request->amount;
                } 
                if ($request->source == 2) {
                    $balance->national_bank = $balance->national_bank + $request->amount;
                } 
                if ($request->source == 3) {
                    $balance->pubali_bank = $balance->pubali_bank + $request->amount;
                } 
                if ($request->source == 4) {
                    $balance->other_bank = $balance->other_bank + $request->amount;
                }
                $balance->save();

            }else {
                $balance = Balance::find($bid);
                if ($request->source == 1) {
                    $balance->cash = $balance->cash - $request->amount;
                } 
                if ($request->source == 2) {
                    $balance->national_bank = $balance->national_bank - $request->amount;
                } 
                if ($request->source == 3) {
                    $balance->pubali_bank = $balance->pubali_bank - $request->amount;
                } 
                if ($request->source == 4) {
                    $balance->other_bank = $balance->other_bank - $request->amount;
                }
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
        $data = Transaction::find($id);
        $data->date = $request->date;
        $data->description = $request->description;
        $data->type = $request->type;
        $data->source = $request->source;
        $data->amount = $request->amount;
        $data->status = "1";
        $data->updated_by = Auth::user()->id;
        if ($data->save()) {
            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data Updated Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
        }else{
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        }
    }

    
}
