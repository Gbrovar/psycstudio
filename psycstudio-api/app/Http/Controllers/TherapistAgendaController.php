<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Therapist_dates;
use Carbon\Carbon;

class TherapistAgendaController extends Controller
{
    public function __construct() {
        $this->middleware('api.auth', ['exept' => ['index', 'show']]);
    }
    public function index() {
        $appointments = Therapist_dates::all();
        
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'therapist_dates' => $appointments
        ]);
    }
    
    public function show($id) {
        $appointment = Therapist_dates::find($id);
        
        if(is_object($appointment)){
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
            
           
            //EndDate = statDate + 1 hour
            $end_date = Carbon::parse($params_array['start_date'])->addHour(1);

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
                $date->end_date = $end_date;
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
    
    public function update($id, Request $request){
        //collect data by post
        $json = $request->input('json', null);
        $params_array = json_decode($json, true);
        
        if(!empty($params_array)){
            //validate data
            $validate = \Validator::make($params_array, [
                    'start_date' =>  'required|date_format:Y-m-d H:i:s'
                ]);
            
            //new modified date
            $newDate = [
                'start_date' => $params_array['start_date'],
                'end_date' => Carbon::parse($params_array['start_date'])->addHour(1)
            ];

            //remove what we don't want to update
            unset($params_array['id']);
            unset($params_array['created_at']);
            
            //update appointment details
            $date = Therapist_dates::where('id', $id)->update($newDate);
            
            $data = [
                    'code' => 200,
                    'status' => 'success',
                    'date' => $newDate
                ];
        } else {
            $data = [
                    'code' => 404,
                    'status' => 'error',
                    'message' => 'No se ha podido actualizar la cita.'
                ];
        }
        //return response
        return response()->json($data, $data['code']);
    }
    
    //Destroy method
    public function destroy($id, Request $request){
        //get data
        $appointment = Therapist_dates::all();
        
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
