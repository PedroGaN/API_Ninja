<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Mission;
use App\Models\Client;

class MissionController extends Controller
{
    //

    public function newMission(Request $request){

        $response = "";
        
        $clients = Client::all();

		//Procesar los datos recibidos
		$data = $request->getContent();

		//Verificar que hay datos
		$data = json_decode($data);

		if($data){
			//TODO: validar los datos introducidos
            //Crear el misión
            $mission = new Mission();

            
            foreach ($clients as $client) {
                
                if ($client->secret_code == $data->secret_code){
                    $mission->client_code = $data->secret_code;
                }

            }

			//Valores obligatorios
            $mission->request = $data->request;
            $mission->payment = $data->payment;

			//Valores opcionales
            if(isset($data->stimated_ninjas))
                $mission->stimated_ninjas = $data->stimated_ninjas;
            if(isset($data->URGENT))
                $mission->URGENT = $data->URGENT;

            //Guardar la misión
            try{

                $mission->save();

                $response = "Mission saved successfully";
            }catch(\Exception $e){
                $response = $e->getMessage();
            }

		}else{
			$response = "Incorrect Data";
		}
		
		return response($response);
    }

    public function editMission(Request $request,$id){

		$response = "";

		//Buscar si existe la nave
		$mission = Mission::find($id);

		if($mission){

			//Procesar los datos recibidos
			$data = $request->getContent();

			//Verificar que hay datos
			$data = json_decode($datos);

			if($data){

                //TODO: validar los datos introducidos

                if($data->client_code == $mission->client_code){
                    if(isset($data->URGENT))
                        $mission->URGENT = $data->URGENT;
                    if(isset($data->stimated_ninjas))
                        $mission->stimated_ninjas = $data->stimated_ninjas;
                    if(isset($data->payment))
                        $mission->payment = $data->payment;
                    if(isset($data->request))
                        $mission->request = $data->request;

                    //Guardar la misión
                    try{

                        $mission->save();

                        $response = "Mission updated successfully";
                    }catch(\Exception $e){
                        $response = $e->getMessage();
                    }
                }else{
                    $responde = "Incorrect Client Code";
                }

			}else{
				$response = "Incorrect Data";
			}
		}else{
			$response = "Mission Not Found";
		}

		return response($response);
    }

    public function changeMissionStatus(Request $request,$id){

		$response = "";

		//Buscar si existe la nave
		$mission = Mission::find($id);

		if($mission){

			//Procesar los datos recibidos
			$data = $request->getContent();

			//Verificar que hay datos
			$data = json_decode($datos);

			if($data){

                //TODO: validar los datos introducidos
                if($data->ninja_quartels_code == "kill_everybody"){
                    if(isset($data->status))
                        $mission->status = $data->status;
                }


				//Guardar la misión
				try{

					$mission->save();

					$response = "Mission status updated successfully";
				}catch(\Exception $e){
					$response = $e->getMessage();
				}
			}else{
				$response = "Incorrect Data";
			}
		}else{
			$response = "Mission Not Found";
		}

		return response($response);
    }
    
    //SIN ORDENAR
    public function listMissions(){

		$missions = Mission::all();

		$result = [];

		foreach ($missions as $mission) {
			
			$result[] = [

				"mission_code" => $mission->id,
				"register_date" => $mission->created_at,
                "URGENT" => $mission->URGENT,
                "client_code" => $mission->client_code,
                "status" => $mission->status

			];

        }
        
        $decoded_result = json_decode($result);

		return response()->$decoded_result;

    }
    
    public function checkMission($id){

		$mission = Mission::find($id);

		if($mission){

			return response()->json(

				[
					"id" => $mission->id,
					"client_code" => $mission->client_code,
					"request" => $mission->request,
					"stimated_ninjas" => $mission->stimated_ninjas,
                    "payment" => $mission->payment,
                    "status" => $mission->status,
                    "URGENT" => $mission->URGENT,
                    "request_date" => $mission->created_at
                ]
                
                //ADD NINJAS

			);
		}

		return response("Pilot Not Found");
	}
}
