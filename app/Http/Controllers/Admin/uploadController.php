<?php

namespace App\Http\Controllers\Admin;
use Validator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class uploadController extends Controller
{
    public function produtoUpload(Request $request){
        $validation = Validator::make($request->all(),[
            'select_file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        if($validation->passes()){
            $image = $request->file('select_file');
            $new_name = rand().'.'.$image->getClientOriginalExtension
                ();
            $image->move(public_path('images'), $new_name);
            return response()->json([
                'message'           => 'Upload Realizado com Sucesso',
                'uploaded_image'    => '<img src="/images/'.$new_name.'"class="img-thumbnail" width="300" />',
                'class_name'        =>'alert alert-success',
                'name'              =>$new_name,
            ]);
        }else{
            return response()->json([
                'message'           =>  'Nao foi possivel efetuar o upload.',
                'uploaded_image'    =>  '',
                'class_name'        =>  'alert alert-danger'
            ]);
        }
    }
}
