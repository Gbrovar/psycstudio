<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
                $pwd = hash('sha256', $params->password);
                                
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
    
        
    //metodo de login de Therapist
    public function login(Request $request) {
        $jwtAuth = new \JwtAuth();
        
        //recibir datos por POST
        $json = $request->input('json', null);
        $params = json_decode($json);
        $params_array = json_decode($json, true);

        //Validar datos recibidos
        $validate = \Validator::make($params_array, [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        if ($validate->fails()) {
            //la validación ha fallado.
            $signup = array(
                'status' => 'error',
                'code' => 404,
                'message' => 'El usuario Terapeuta no se ha podido identificar',
                'error' => $validate->errors()
            );
        } else {
            //Cifrar el password
            $pwd = hash('sha256' , $params->password);
            
            
            //Devolver token
            $signup = $jwtAuth->signup($params->email, $pwd);

            if (!empty($params->gettoken)) {
                $signup = $jwtAuth->signup($params->email, $pwd, true);
            }
        }
        
        return response()->json($signup, 200);
        
    }
    
    //metodo tokenControl
    public function tokenControl(Request $request) {
        $token = $request->header('Authorization');
        $jwtAuth = new \JwtAuth();
        $checkToken = $jwtAuth->checkToken($token);

        if($checkToken){
           $data = array(
              'code' => 200,
              'status' => 'success',
              'message' => 'El usuario Terapeuta esta identificado.'
          );
        }else{
          $data = array(
              'code' => 400,
              'status' => 'error',
              'message' => 'El usuario Terapeuta NO esta identificado.'
          );
        }
        
        return response()->json($data, $data['code']);
    }
    
        
    
    //update method
    public function update(Request $request){

      // Comprobar si el usuario esta identificado.
      $token = $request->header('Authorization');
      $jwtAuth = new \JwtAuth();
      $checkToken = $jwtAuth->checkToken($token);

      //collect user data
      $json = $request->input('json', null);
      $params_array = json_decode($json, true);
      
      if($checkToken && !empty($params_array)){

        //bring identified user
        $user = $jwtAuth->checkToken($token, true);
        
        $userId = Therapist::where('id', $user->sub)
                ->where('role', $user->role)
                ->first();
        
        
        if(!is_null($userId)){
            //validate data
            $validate = \Validator::make($params_array, [
              'name' => 'required|alpha',
              'surname' => 'required|alpha',
              'email' => 'required|email|unique:users'.$user->sub
            ]);

            //remove the values we don't want to update
            unset($params_array['id']);
            unset($params_array['password']);
            unset($params_array['role']);
            unset($params_array['remember_token']);
            unset($params_array['created_at']);


            //update user in DB
            $user_update = Therapist::where('id', $user->sub)->update($params_array);

            //return result
            $data = array(
              'code' => 200,
              'status' => 'success',
              'message' => 'El usuario Terapeuta se ha actualizado.',
              'user' => $user,
              'changes' => $params_array
            );
        } else {
            $data = array(
              'code' => 400,
              'status' => 'error',
              'message' => 'Tus credenciales no coinciden con el usuario que intentas actualizar'
            );
          }
      } else {
        $data = array(
          'code' => 400,
          'status' => 'error',
          'message' => 'El usuario Terapeuta no está identificado.'
        );
      }

      return response()->json($data, $data['code']);
    }
    
    //upload method
    public function upload(Request $request){
        
        //get data of request
        $image = $request->file('file0');
        
        //Validate image
        $validate = \Validator::make($request->all(), [
            'file0' => 'required|image|mimes:jpg, jpeg, png, gif'
        ]);
        
        //upload & save image
        if(!$image || $validate->fails()){
            $data = array(
                'code' => 400,
                'status' => 'error',
                'message' => 'Error al subir imagen.'
              );
        }else{
            $image_name = time().$image->getClientOriginalName();
            \Storage::disk('therapist_images')->put($image_name, \File::get($image));
            
            //return response data
            $data = array(
                'code' => 200,
                'status' => 'success',
                'image' => $image_name
            );
        }
        
        return response($data, $data['code']);
    }
    
    //method get image
    public function getImage($filename){
        
        $isset = \Storage::disk('therapist_images')->exists($filename);
        
        if($isset){
            $file = \Storage::disk('therapist_images')->get($filename);
            return new Response($file, 200);
        } else {
            $data = array(
                'code' => 400,
                'status' => 'error',
                'message' => 'Error, la imagen no existe'
              );
            
            return response($data, $data['code']);
            
        }

    }
    
    //method get Therapist
    public function detail($id) {
        $user = Therapist::find($id);
        
        if (is_object($user)) {
            $data = array(
                'code' => 200,
                'status' => 'success',
                'user' => $user
            );
        } else {
            $data = array(
                'code' => 400,
                'status' => 'error',
                'message' => 'El usuario no existe.'
              );
        }
        
        return response()->json($data, $data['code']);
    }

    
    
}
