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
                'start_date' =>  'required|date_format:Y-m-d H:i:s'
            ]);

            //store data in database
            if ($validate->fails()) {
                $data = [
                    'code' => 404,
                    'status' => 'error',
                    'message' => 'No se ha guardado la cita'
                ];
            } else {
                $date = new Therapist_dates();
                $date->therapist_id = $params_array['therapist_id'];
                $date->start_date = $params_array['start_date'];
                $date->end_date = $params_array['start_date']; // +1Hour
                $date->schedule_status = 'FREE';  //status of the created appointment: scheduled or free
                $date->status = 'not attended';   //schedule_status options: not attended(default), attended, user not show, therapist not show.
                $date->room_id = 'XXXXX';         //video call room id   
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
}
