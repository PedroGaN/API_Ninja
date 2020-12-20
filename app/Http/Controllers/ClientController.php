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
            //Crear el ninja
            $client = new CLient();


			//Valores obligatorios
			$client->secret_code = $data->secret_code;

			//Valores opcionales
            if(isset($data->VIP))
                $client->VIP = $data->VIP;

            //Guardar el ninja
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
			$data = json_decode($datos);

			if($data){

				//TODO: validar los datos introducidos

				if(isset($data->secret_code))
					$client->secret_code = $data->secret_code;
				if(isset($data->VIP))
					$client->VIP = $data->VIP;

				//Guardar el ninja
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
			$response = "Ninja Not Found";
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
        
        $decoded_result = json_decode($result);

		return response()->$decoded_result;

	}
}
