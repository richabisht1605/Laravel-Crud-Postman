<?php

namespace App\Http\Controllers;
use App\Models\Ajax;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use DB;

class ApiController extends Controller
{
   public function form_submit(Request $request)
   {
        $add= new Ajax;
        if($request->isMethod('post'))
        {
            $add->name=$request->get('name');
            $add->email=$request->get('email');
            $add->save();
        }
        return [
            "message"=>"Student record Inserted"
        ];
   }
   public function display()
   {
    $students = Ajax::all()->toJson(JSON_PRETTY_PRINT);
    return $students;
   }
   public function delete_data($id)
   {
        if(Ajax::where('id',$id)->exists())
        {
            $stud = Ajax::find($id);
            $stud -> delete();
            return [
                "message" => "Record deleted"
            ];
        }
        else
        {
            return [
                "message" =>  "Record not found"
            ];
        }
   }
   public function fetchdata($id)
   {
        if(Ajax::where('id',$id)->exists())
        {
            $stud = Ajax::where('id',$id)-> get()-> toJson(JSON_PRETTY_PRINT);
            return ($stud);
        }
        else
        {
            return [
                "message" =>  "Record not found"
            ]; 
        }
       
   }
   public function edit_data(Request $request)
   {
       $stud=Ajax::find($request->id);
       
       if($stud)
       {
       $stud->name=$request->get('name');
       $stud->email=$request->get('email');
       $stud->save();
       return response()->json([
           "message"=>"Record Updated Successfully"
       ],200);
    }
    else{
        return response()->json([
            "message"=>"Record no updated Successfully"
        ],405);
    }
    }
       
}

