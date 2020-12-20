<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Client;

class ClientController extends Controller
{
    //

    public function newClient(Request $request){

		$response = "";

		//Procesar los datos recibidos
		$data = $request->getContent();

		//Verificar que hay datos
		$data = json_decode($data);

		if($data){
			//TODO: validar los datos introducidos
            //Crear el cliente
            $client = new CLient();


			//Valores obligatorios
			$client->secret_code = $data->secret_code;

			//Valores opcionales
            if(isset($data->VIP))
                $client->VIP = $data->VIP;

            //Guardar el cliente
            try{

                $client->save();

                $response = "Client saved successfully";
            }catch(\Exception $e){
                $response = $e->getMessage();
            }

		}else{
			$response = "Incorrect Data";
		}
		
		return response($response);
    }

    public function editClient(Request $request,$id){

		$response = "";

		//Buscar si existe la nave
		$client = Client::find($id);

		if($client){

			//Procesar los datos recibidos
			$data = $request->getContent();

			//Verificar que hay datos
			$data = json_decode($data);

			if($data){

				//TODO: validar los datos introducidos

				if(isset($data->secret_code))
					$client->secret_code = $data->secret_code;
				if(isset($data->VIP))
					$client->VIP = $data->VIP;

				//Guardar el cliente
				try{

					$client->save();

					$response = "Client updated successfully";
				}catch(\Exception $e){
					$response = $e->getMessage();
				}
			}else{
				$response = "Incorrect Data";
			}
		}else{
			$response = "Client Not Found";
		}

		return response($response);
    }
    
    public function listClients(){

		$clients = Client::all();

		$result = [];

		foreach ($clients as $client) {
			
			$result[] = [

				"secret_code" => $client->secret_code,
				"register_date" => $client->created_at,
                "VIP?" => $client->VIP

			];

        }

		return response()->json($result);

    }
    
    public function checkClient($id){

		$client = Client::find($id);

		if($client){

			return response()->json(

				[
					"id" => $client->id,
                    "secret_code" => $client->secret_code,
                    "VIP" => $client->VIP,
                    "register_date" => $client->created_at
                ]
                
                //ADD MISSIONS

			);
		}

		return response("Ninja Not Found");
	}
}
