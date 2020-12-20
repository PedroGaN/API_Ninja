<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Client;

use App\Models\Ninja;
use App\Models\MissionsNinjas;
use App\Models\Mission;

class MissionController extends Controller
{
    //

    public function newMission(Request $request){

        $response = "Secret Code not found";
        
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
                }
            }

		}else{
			$response = "Incorrect Data";
		}
		
		return response($response);
    }

    public function editMission(Request $request,$id){

		$response = "Incorrect Client Code";

		//Buscar si existe la nave
		$mission = Mission::find($id);

		if($mission){

			//Procesar los datos recibidos
			$data = $request->getContent();

			//Verificar que hay datos
			$data = json_decode($data);

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

    
    //SIN ORDENAR
    public function listMissions(){

		$missions = Mission::orderBy('URGENT','DESC')->orderBy('created_at','ASC')->get();

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

		return response()->json($result);

    }

    public function listMissionsFiltered($filter,$value){

		$missions = Mission::all();

        $result = [];
        
        if(isset($filter) && isset($value)){
            $result = $this->filter($filter,$value);
        }else{

            foreach ($missions as $mission) {
                $result[] = [

                    "mission_code" => $mission->id,
                    "register_date" => $mission->created_at,
                    "URGENT" => $mission->URGENT,
                    "client_code" => $mission->client_code,
                    "status" => $mission->status

                ];
            }
        }

		return response()->json($result);

    }
    
    public function checkMission($id){

        $mission = Mission::find($id);
        
        $missionsNinjas = MissionsNinjas::all();

        $result = [];

		if($mission){

			$result[] =

				[
					"id" => $mission->id,
					"client_code" => $mission->client_code,
					"request" => $mission->request,
					"stimated_ninjas" => $mission->stimated_ninjas,
                    "payment" => $mission->payment,
                    "status" => $mission->status,
                    "URGENT" => $mission->URGENT,
                    "request_date" => $mission->created_at
                ];
                
            foreach ($missionsNinjas as $missionNinja) {
    
                if($missionNinja->mission_id == $mission->id){

                    $ninja = Ninja::where('id',$missionNinja->ninja_id)->get();

                    if($ninja){
                        foreach ($ninja as $ninja) {
    
                            if($missionNinja->mission_id == $mission->id){
        
                                $result[] = [
            
                                    "ninja_name" => $ninja->name
                    
                                ];
                            }
    
                        }
    
                    }

                }

            }

		}else{
            return response("Mission Not Found");
        }

		return response()->json($result);
    }
    
    public function filter($filter,$value){

        $missions = Mission::orderBy('URGENT','DESC')->orderBy('created_at','ASC')->get();

        $result = [];

        foreach ($missions as $mission) {
            
            if ($mission->$filter == $value){
                $result[] = [
    
                    "mission_code" => $mission->id,
                    "register_date" => $mission->created_at,
                    "URGENT" => $mission->URGENT,
                    "client_code" => $mission->client_code,
                    "status" => $mission->status
    
                ];
            }
        }

        return $result;
    }

    public function startMission($id){

        $mission = Mission::find($id);

        if($mission){
            $mission->status = "Ongoing";

            try{

                $mission->save();

            }catch(\Exception $e){
                $response = $e->getMessage();
            }

        }

    }

    public function endMission(Request $request,$id,$status){

        $mission = Mission::find($id);

        $response = "";

        //Procesar los datos recibidos
        $data = $request->getContent();

        //Verificar que hay datos
        $data = json_decode($data);

        if($data){
            if($data->ninja_quartels_code == "kill_everybody"){

                if($mission){
                    if($status == "Failed" || $status == "Successful"){
                        $mission->status = $status;
                        $mission->end_date = date('Y-m-d');

                        //Guardar la misión
                        try{

                            $mission->save();

                            $response = "Mission Ended";
                        }catch(\Exception $e){
                            $response = $e->getMessage();
                        }

                    }else{
                        $response = "Incorrect Status";
                    }
                }else{
                    $response = "Mission Not Found";
                }
    
            }else{
                $response = "Incorrect Password";
            }
        }else{
            $response = "Incorrect Data";
        }

        return response($response);
    }
}
