<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\JobsData;
class JobsController extends Controller
{
    //

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function getAllStoreData(){
        $data = JobsData::all();

        return response()->json(['message' => 'Success Get All Data', 'data' => $data]);
    }

    public function storeData(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'company_name' => 'required',
            'position' => 'required',
            'salary' => 'required',
            'koordinat' => 'required',
            'lokasi' => 'required',
            'koordinat' => 'required',
            'gender'=>'required',
            'image_url' => 'required',
            'pelamar' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->messages());
        }

        $data = JobsData::create([
            'company_name' => request('company_name'),
            'position' => request('position'),
            'salary' => request('salary'),
            'koordinat' => request('koordinat'),
            'lokasi' => request('lokasi'),
            'pelamar' => request('pelamar'),
            'gender' => request('gender'),
            'image_url' => request('image_url'),
        ]);

        

        if($data){
            return response()->json(['message' => 'insert data successfully', 'data' => $data]);
        }else{
            return response()->json(['message' => 'Registration Failed']);
        }
    }

    public function getStoreData($id){
        $data = JobsData::find($id);

        if($data){
            return response()->json(['code' => 200,'message' => 'Success get data by id', 'data' => $data]);
        }else{
            return response()->json(['message' => 'Error'], 422);
        }
    }

    public function updateStoreData($id){
        $validator = Validator::make(request()->all(), [
            'pelamar' => 'required',
            'gender' => 'required',
            'image_url'=> 'required',
        ]);

        if($validator->fails()){
            return response()->json(['message' => 'Error', 'errors' => $validator->errors()], 422);
        }

        $data = JobsData::find($id);

        if($data){
            $data->pelamar = request('pelamar');
            $data->gender = request('gender');
            $data->image_url = request('image_url');
            $data->save();
            return response()->json(['code' => 200,'message' => 'Change data successfully', 'data' => $data]);
        }else{
            return response()->json(['message' => 'Error']);
        }
    }

    public function deleteStoreData($id){
        $data = JobsData::find($id);

        if($data){
            $data->delete();
            return response()->json(['code' => 200,'message'=>'Data has been deleted !']);
        }else{
            return response()->json(['code' => 400,'message' => 'Error']);
        }
    }

}
