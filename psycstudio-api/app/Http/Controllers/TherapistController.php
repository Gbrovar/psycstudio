<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Therapist;

class TherapistController extends Controller
{
    public function pruebas(Request $request) {
        return "Therapist Controller Test";
    }


    //metodo de registro de terapeuta
    public function register(Request $request) {
        
        //recoger datos de terapeuta por post Y Decodificar datos JSON
        $json = $request->input('json', null);
        $params = json_decode($json);
        $params_array = json_decode($json, true);
        
        
        if(!empty($params) && !empty($params_array)) {
            //limpiar los datos 
            $params_array = array_map('trim', $params_array);

            //validar datos
            $validate = \Validator::make($params_array, [
                        'name' => 'required|alpha',
                        'surname' => 'required|alpha',
                        'email' => 'required|email|unique:therapists', //comprobar si existe terapeuta
                        'password' => 'required',
                        //'phone_number'
                        //'country'
                        //'address'
                        //'gender'
                        //'birthday'
                        //'description'
                        //'therapist_id'
                        //'role'
                        //'remember_token'
                        //'image'

            ]);

            if ($validate->fails()) {
                //validacion fallida
                $data = array(
                    'status' => 'error',
                    'code' => 404,
                    'message' => 'El terapeuta no se ha creado correctamente',
                    'error' => $validate->errors()
                );
            } else {
                //validación pasada correctamente
          
                //cifrar la contraseña
                $pwd = password_hash($params->password, PASSWORD_BCRYPT, ['cost' => 10]);
                                
                //crear terapeuta
                $therapist = new Therapist();
                $therapist->name = $params_array['name'];
                $therapist->surname = $params_array['surname'];
                $therapist->email = $params_array['email'];
                $therapist->password = $pwd;
                $therapist->role = 'THERAPIST';
                
                //guardar el terapeuta
                $therapist->save();

                $data = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'El terapeuta se ha creado correctamente',
                    'therapist' => $therapist
                );
            }
        } else {
            $data = array(
                    'status' => 'error',
                    'code' => 404,
                    'message' => 'Los datos enviados no son correctos'
                );
        }

        return response()->json($data, $data['code']);
    }
}
