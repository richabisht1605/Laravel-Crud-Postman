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
}
