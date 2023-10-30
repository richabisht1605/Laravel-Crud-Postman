<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ajax;

class AjaxController extends Controller
{
    public function index(Request $request){
        if ($request->ajax()) {
            $records = Ajax::all();
            return response()->json(['data' => $records]);
        }
        return view('index');
    }
    

    public function form_submit(Request $request){
        $model=new Ajax;
        $model->name=$request->post('name');
        $model->email=$request->post('email');
        $model->save();
        return ["msg"=>"Data Inserted"];
    }

    public function deleteRecord(Request $request) {
        $id = $request->get('id');
        Ajax::where('id', $id)->delete();
        return response()->json(['msg' => 'Record deleted successfully']);
    }
    
    public function getRecord(Request $request)
    {
        $record = Ajax::find($request->id);
        return response()->json(['data' => $record]);
    }

    public function updateRecord(Request $request)
    {
        $record = Ajax::find($request->record_id);
        $record->name = $request->name;
        $record->email = $request->email;
        $record->save();
        
        return response()->json(['msg' => 'Record updated successfully']);
    }
}
