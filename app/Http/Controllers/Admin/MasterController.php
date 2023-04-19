<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Softcode;
use App\Models\Master;
use Illuminate\Http\Request;
use Illuminate\support\Facades\Auth;

class MasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $softcode= Softcode::all('name');
        $masters = Master::all();
        return view('admin.codemaster.master',compact('masters','softcode'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $softcode= Softcode::all('name');
        return view('admin.master.create',compact('softcode'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->softcode == 'logo'){
            $query = Master::where('softcode', '=', 'logo')->get()->first();
            if(!empty($query->id)){
                $image_path = public_path('images/master').'/'.$query->image;
                unlink($image_path);
                Master::destroy($query->id);
            }
        }

            try{
                $data = new Master();
                $data->softcode= $request->softcode;
                $data->hardcode= $request->hardcode;
                $request->validate([
                    'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);
                $rand = mt_rand(100000, 999999);
                $imageName = time(). $rand .'.'.$request->image->extension();
                $request->image->move(public_path('images/master'), $imageName);
                $data->image= $imageName;
                $data->details= $request->details;
                $data->sort_details= $request->sort_details;
                $data->created_by= Auth::user()->id;
                $data->save();

                $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data Created Successfully.</b></div>";
                return response()->json(['status'=> 300,'message'=>$message]);

            }catch (\Exception $e){
                return response()->json(['status'=> 303,'message'=>'Server Error!!']);

            }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Master  $master
     * @return \Illuminate\Http\Response
     */
    public function show(Master $master)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Master  $master
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $where = [
            'id'=>$id
        ];
        $info = Master::where($where)->get()->first();
        return response()->json($info);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Master  $master
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = Master::find($id);
        if($request->image != 'null'){
            $image_path = public_path('images/master').'/'.$data->image;
            // unlink($image_path);
            $data->softcode= $request->softcode;
            $data->hardcode= $request->hardcode;
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $rand = mt_rand(100000, 999999);
            $imageName = time(). $rand .'.'.$request->image->extension();
            $data->image->move(public_path('images/master'), $imageName);
            $data->image= $imageName;
            $data->details= $request->details;
            $data->sort_details= $request->sort_details;
        }else{
            $data->softcode= $request->softcode;
            $data->hardcode= $request->hardcode;
            $data->details= $request->details;
            $data->sort_details= $request->sort_details;
        }

        if ($data->save()) {
            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data Updated Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
        }else{
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Master  $master
     * @return \Illuminate\Http\Response
     */
    public function destroy(Master $master)
    {
        if(Master::destroy($master->id)){
            return response()->json(['success'=>true,'message'=>'Listing Deleted']);
        }
        else{
            return response()->json(['success'=>false,'message'=>'Update Failed']);
        }
    }
}
