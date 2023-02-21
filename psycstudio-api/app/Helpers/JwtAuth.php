<?php

namespace App\Helpers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Therapist;

class JwtAuth{
    
    
    public $key;

    public function __construct() {
        $this->key = 'El_hombre_es_algo_que_tiene_que_ser_superado_y_por_ello_tienes_que_amar_tus_virtudes,_pues_pereceras_a_causa_de_ellas';    
    }


    public function signup($email, $password, $getToken = null) {
        //Buscar si existe el usuario con sus credenciales

        $user = null;

        $user = Therapist::Where([   
                    'email' => $email,
                    'password' => $password,
        ])->first();
        
        if(is_null($user)){
            $user = User::Where([  
                'email' => $email,
                'password' => $password,
            ])->first();
        }
        
        
        //comprobar si son correctas
        $signup = false;
        if(is_object($user)){
            $signup = true;
        } 
        
        //generar un token con los datos del usuario
        if($signup) {  
            //var_dump($user->role); die();
            
            if($user->role == 'USER'){
                $token = array(
                    'sub'           =>  $user->id,
                    'email'         =>  $user->email,
                    'name'          =>  $user->name,
                    'surname'       =>  $user->surname,
                    'role'          =>  $user->role,
                    'therapist_id'  =>  $user->therapist_id,
                    'iat'           =>  time(), //time start token
                    'exp'           =>  time() + (60*60*24) //time expire token
                );
            }elseif ($user->role == 'THERAPIST') {
                $token = array(
                    'sub'           =>  $user->id,
                    'email'         =>  $user->email,
                    'name'          =>  $user->name,
                    'surname'       =>  $user->surname,
                    'role'          =>  $user->role,
                    'iat'           =>  time(), //time start token
                    'exp'           =>  time() + (60*60*24) //time expire token
                );               
            }else {
                $data = array(
                    'status' => 'error',
                    'message' => 'No se encontró al usuario'
                );
            }

            
            $jwt = JWT::encode($token, $this->key, 'HS256');
            $decoded = JWT::decode($jwt, new Key($this->key, 'HS256'));
            
            //devolver los datos decodificados o el token
            if(is_null($getToken)){
                $data = $jwt;
            }else{
                $data = $decoded;
            }
            
        }else{
            $data = array(
                'status' => 'error',
                'message' => 'Loguin incorrecto.'
            );
        }
           
        return $data;    
    }
    
    
    public function checkToken($jwt, $getIdentity = false ) {
        $auth = false;
        
        try {
            $jwt = str_replace('"', '', $jwt);
            $decoded = JWT::decode($jwt, new Key($this->key, 'HS256'));    
        } catch (\UnexpectedValueException $e){
            $auth = false;
        } catch (\DomainException $e) {
            $auth = false;
        }
        

        if (!empty($decoded) && is_object($decoded) && isset($decoded->sub)) {
            $auth = true;          
        } else {
            $auth = false;
        }
        
        if($getIdentity){
            return $decoded;  
        }
        
        return $auth;
    }

}




