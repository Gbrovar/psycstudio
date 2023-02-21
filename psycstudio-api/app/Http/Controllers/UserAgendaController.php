<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User_dates;
use App\Models\Therapist_dates;
use App\Helpers\JwtAuth;

class UserAgendaController extends Controller
{
    public function __construct() {
        $this->middleware('api.auth', ['exept' => ['index', 'show']]);
    }
    
    private function getIdentity($request){
        //get user logged in
        $jwtAuth = new JwtAuth();
        $token = $request->header('Authorization', null);
        $user = $jwtAuth->checkToken($token, true);
        
        return $user;
    }
    
    public function getTherapistDate($request) {
        
        $json = $request->input('json', null);
        $params = json_decode($json);
        $params_array = json_decode($json, true);
        
        $therapist_date = Therapist_dates::where('id', $params_array['date_id'])
                ->where('therapist_id', $params_array['therapist_id'])
                ->first();
        
        unset($therapist_date['created_at']);
        
        return $therapist_date;
    }
    
    private function updateTherapistDateStatus($request) {
   
        //modified date status
        $schedule_status = [
            'schedule_status' => $request['status']
        ];

        //update appointment details
        $date = Therapist_dates::where('id', $request['date_id'])
                ->where('therapist_id', $request['therapist_id'])
                ->update($schedule_status); 


        return $date;
    }
    
    public function index(Request $request) {
        //get user logged in
        $user = $this->getIdentity($request);
        
        $appointments = User_dates::where('user_id', $user->sub)
                ->get();
        
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'user_dates' => $appointments
        ]);
    }
    
    public function show($id, Request $request) {
        //get user logged in
        $user = $this->getIdentity($request);
        
        $appointment = User_dates::where('id', $id)
                ->where('user_id', $user->sub)
                ->first();
        
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
            
            //get user logged in
            $user = $this->getIdentity($request);
 
            //update therapist date schedule_status
            $updated_ther_date = [
                'date_id' => $params_array['date_id'],
                'therapist_id' => $params_array['therapist_id'],
                'status' => 'NOT FREE'
            ]; 

            //validate data
            $validate = \Validator::make($params_array, [
                //'user_id' => 'required|integer',
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
                
                //get therapist date
                $therapist_date = $this->getTherapistDate($request);
                
                $date = new User_dates();
                $date->user_id = $user->sub;
                $date->date_id = $therapist_date['id'];
                $date->therapist_id = $therapist_date['therapist_id']; 
                $date->status = $therapist_date['status'];  
                //$date->transaction_id = '';   
                //$date->user_plan = '';         
                //$date->user_plan_id = ''; 
                //$date->user_subscription = ''; 
                //$date->user_subscription_id = ''; 
                $date->payment_method = 'abc'; 
                $date->room_id = $therapist_date['room_id']; 
                $date->save();
                
                //update therapist date schedule_status
                $updated_ther_date = [
                    'date_id' => $params_array['date_id'],
                    'therapist_id' => $params_array['therapist_id'],
                    'status' => 'NOT FREE'
                ]; 

                //update schedule_status on therapist date
                $schedule_status = $this->updateTherapistDateStatus($updated_ther_date);
                
                //get therapist date updated
                $therapist_date = $this->getTherapistDate($request);
                
                $data = [
                    'code' => 200,
                    'status' => 'success',
                    'date' => $date,
                    'therapist_date' => $therapist_date
                ];     
            }
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
        //get user logged in
        $user = $this->getIdentity($request);
        
        //get data
        $appointment = User_dates::where('id', $id)
                ->where('user_id', $user->sub)
                ->first();

        if(!empty($appointment)){
            //delete appintment
            $appointment->delete();
            
            //update therapist date schedule_status
            $updated_ther_date = [
                'date_id' => $appointment['date_id'],
                'therapist_id' => $appointment['therapist_id'],
                'status' => 'FREE'
            ]; 

            //update schedule_status on therapist date
            $schedule_status = $this->updateTherapistDateStatus($updated_ther_date);

            //get therapist date updated
            //$therapist_date = $this->getTherapistDate($request);
            
            //return response
            $data = [
                    'code' => 200,
                    'status' => 'success',
                    'user_dates' => $appointment,
                    'message' => 'La cita hasido eliminada'
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
