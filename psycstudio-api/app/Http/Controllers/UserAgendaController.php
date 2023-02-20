<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User_dates;

class UserAgendaController extends Controller
{
    public function __construct() {
        $this->middleware('api.auth', ['exept' => ['index', 'show']]);
    }  
    
    public function index() {
        $appointments = User_dates::all();
        
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'user_dates' => $appointments
        ]);
    }
    
    public function show($id) {
        $appointment = User_dates::find($id);
        
        if(is_object($appointment)){
            $data = [
                'code' => 200,
                'status' => 'success',
                'user_dates' => $appointment
            ];
        } else {
            $data = [
                'code' => 404,
                'status' => 'error',
                'message' => 'La cita no existe'
            ];
        }
        
        return response()->json($data, $data['code']);
    }
    
    public function store(Request $request) {
        //collect data by post
        $json = $request->input('json', null);
        $params_array = json_decode($json, true);
        
        
        if(!empty($params_array)){
            //validate data
            $validate = \Validator::make($params_array, [
                'user_id' => 'required|integer',
                'date_id' => 'required|integer|unique:user_dates',
                'therapist_id' => 'required|integer'
            ]);
            
            //store data in database
            if ($validate->fails()) {
                $data = [
                    'code' => 404,
                    'status' => 'error',
                    'message' => 'No se ha guardado la cita'
                ];
            } else {
                $date = new User_dates();
                $date->user_id = $params_array['user_id'];
                $date->date_id = $params_array['date_id'];
                $date->therapist_id = $params_array['therapist_id']; 
                //$date->status = '';  
                //$date->transaction_id = '';   
                //$date->user_plan = '';         
                //$date->user_plan_id = ''; 
                //$date->user_subscription = ''; 
                //$date->user_subscription_id = ''; 
                $date->payment_method = 'abc'; 
                $date->room_id = 'abc'; 
                $date->save();

                $data = [
                    'code' => 200,
                    'status' => 'success',
                    'date' => $date
                ];
            };
        } else {
            $data = [
                    'code' => 404,
                    'status' => 'error',
                    'message' => 'Los datos enviados no son correctos'
                ];
        }
        
        //return response
        return response()->json($data, $data['code']);
    }
    
    //Destroy method
    public function destroy($id, Request $request){
        //get data
        $appointment = User_dates::all();
        
        if(!empty($appointment)){
            //delete appintment
            $appointment->delete();

            //return response
            $data = [
                    'code' => 200,
                    'status' => 'success',
                    'therapist_dates' => $appointment
                ];
        } else {
            $data = [
                    'code' => 404,
                    'status' => 'error',
                    'message' => 'La cita no existe'
                ];
        }
        //return response
        return response()->json($data, $data['code']);     
    }
}
