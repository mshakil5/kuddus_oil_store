<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Transaction;
use App\Models\Balance;
Use Image;
use Illuminate\support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function index()
    {
        $data = Customer::orderby('id','DESC')->get();
        return view('admin.customer.index',compact('data'));
    }
    
    public function store(Request $request)
    {

        if(empty($request->name)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Name \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        $chkemail = Customer::where('name',$request->name)->first();
        if($chkemail){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>This \"Name \" already added. Please Change Name.</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        if(empty($request->phone)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Phone \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        $data = new Customer();
        $data->name = $request->name;
        $data->phone = $request->phone;
        $data->address = $request->address;
        // intervention
        if ($request->image != 'null') {
            $originalImage = $request->file('image');
            $thumbnailImage = Image::make($originalImage);
            $thumbnailPath = public_path().'/images/thumbnail/';
            $originalPath = public_path().'/images/';
            $time = time();
            $thumbnailImage->save($originalPath.$time.$originalImage->getClientOriginalName());
            $thumbnailImage->resize(150,150);
            $thumbnailImage->save($thumbnailPath.$time.$originalImage->getClientOriginalName());
            $data->image = $time.$originalImage->getClientOriginalName();
        }
        // end
        $data->balance = $request->balance;
        $data->status = "1";
        $data->created_by = Auth::user()->id;
        if ($data->save()) {
            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data Created Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
        } else {
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        }
    }

    public function edit($id)
    {
        $where = [ 'id'=>$id ];
        $info = Customer::where($where)->get()->first();
        return response()->json($info);
    }

    public function update(Request $request, $id)
    {

        if(empty($request->name)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Name \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        $chkemail = Customer::where('name',$request->name)->where('id','!=', $id)->first();
        if($chkemail){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>This \"Name \" already added. Please Change Name.</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        if(empty($request->phone)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Phone \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }


        $data = Customer::find($id);
        if($request->image != 'null'){
            $originalImage= $request->file('image');
            $thumbnailImage = Image::make($originalImage);
            $thumbnailPath = public_path().'/images/thumbnail/';
            $originalPath = public_path().'/images/';
            $time = time();
            $thumbnailImage->save($originalPath.$time.$originalImage->getClientOriginalName());
            $thumbnailImage->resize(150,150);
            $thumbnailImage->save($thumbnailPath.$time.$originalImage->getClientOriginalName());
            $data->image= $time.$originalImage->getClientOriginalName();
        }
            $data->name = $request->name;
            $data->phone = $request->phone;
            $data->address = $request->address;
            $data->balance = $request->balance;
            $data->status = "1";
            $data->updated_by = Auth::user()->id;
        if ($data->save()) {
            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data Updated Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
        }else{
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        }
    }

    public function delete($id)
    {
        $data = Customer::where('id','=', $id)->first();
        if(Customer::destroy($id)){
            return response()->json(['success'=>true,'message'=>'Listing Deleted']);
        }else{
            return response()->json(['success'=>false,'message'=>'Server Error!!']);
        }
    }

    public function getcustomer(Request $request)
    {
        $customerDtl = Customer::where('id', '=', $request->customer_id)->first();
        if(empty($customerDtl)){
            return response()->json(['status'=> 303,'message'=>"No data found"]);
        }else{
            return response()->json(['status'=> 300,'name'=>$customerDtl->name,'balance'=>$customerDtl->balance]);
        }
    }

    public function customerDeposit(Request $request)
    {
        if(empty($request->type)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Transaction Type \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        if(empty($request->source)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Account Name \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        if(empty($request->amount)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Amount \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        $customer = Customer::find($request->uid);
        $customer->balance = $customer->balance + $request->amount;
        if ($customer->save()) {
            $data = new Transaction();
            $data->customer_id = $request->uid;
            $data->date = $request->date;
            $data->description = $request->description;
            $data->type = $request->type;
            $data->source = $request->source;
            $data->amount = $request->amount;
            $data->status = "1";
            $data->created_by = Auth::user()->id;
            $data->save();

            $balance = Balance::find(1);
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

            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data Created Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
        } else {
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        }
    }

    public function getCustomerTransaction($id)
    {
        $data = Transaction::orderby('id','DESC')->where('customer_id',$id)->get();
        return view('admin.customer.tran',compact('data'));
    }

    public function customerTranUpdate(Request $request)
    {
        if(empty($request->type)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Transaction Type \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        if(empty($request->source)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Account Name \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        if(empty($request->amount)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Amount \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        $oldtran = Transaction::where('id',$request->codeid)->first();
        $balance = Balance::find(1);
            if ($request->source == 1) {
                $balance->cash = $balance->cash - $oldtran->amount;
            } 
            if ($request->source == 2) {
                $balance->national_bank = $balance->national_bank - $oldtran->amount;
            } 
            if ($request->source == 3) {
                $balance->pubali_bank = $balance->pubali_bank - $oldtran->amount;
            } 
            if ($request->source == 4) {
                $balance->other_bank = $balance->other_bank - $oldtran->amount;
            }
        $balance->save();

        $customer = Customer::find($request->customer_id);
        $customer->balance = $customer->balance - $oldtran->amount + $request->amount;
        if ($customer->save()) {
            $data = Transaction::find($request->codeid);
            $data->date = $request->date;
            $data->description = $request->description;
            $data->type = $request->type;
            $data->source = $request->source;
            $data->amount = $request->amount;
            $data->status = "1";
            $data->created_by = Auth::user()->id;
            $data->save();

            $balance = Balance::find(1);
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

            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data Created Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
        } else {
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        }
    }

}
