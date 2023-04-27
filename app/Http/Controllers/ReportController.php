<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Account;
use App\Models\Transaction;
use App\Models\Sale;
Use Image;
use Illuminate\support\Facades\Auth;

class ReportController extends Controller
{
    public function salesReport(Request $request)
    {
        $data = Sale::orderby('id','DESC')
                ->when($request->input('fromDate'), function ($query) use ($request) {
                    $query->whereBetween('date', [$request->input('fromDate'), $request->input('toDate')]);
                })
                ->when($request->input('customer_id'), function ($query) use ($request) {
                    $query->where("customer_id",$request->input('customer_id'));
                })
                ->when($request->input('product_id'), function ($query) use ($request) {
                    $query->where("product_id",$request->input('product_id'));
                })
                ->when($request->input('company'), function ($query) use ($request) {
                    $query->where("company",$request->input('company'));
                })
        ->get();
        // $data = Sale::orderby('id','DESC')->get();
        return view('admin.report.salesreport',compact('data'));
    }

    public function transactionReport(Request $request)
    {
        $data = Transaction::orderby('id','DESC')
                ->when($request->input('fromDate'), function ($query) use ($request) {
                    $query->whereBetween('date', [$request->input('fromDate'), $request->input('toDate')]);
                })
                ->when($request->input('customer_id'), function ($query) use ($request) {
                    $query->where("customer_id",$request->input('customer_id'));
                })
                ->when($request->input('type'), function ($query) use ($request) {
                    $query->where("type",$request->input('type'));
                })
                ->when($request->input('account_id'), function ($query) use ($request) {
                    $query->where("account_id",$request->input('account_id'));
                })
        ->get();
        // $data = Sale::orderby('id','DESC')->get();
        return view('admin.report.transactionreport',compact('data'));
    }
}
