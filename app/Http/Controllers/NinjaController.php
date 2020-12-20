<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Ninja;

class NinjaController extends Controller
{
    //
    public function newNinja(Request $request){

		$response = "";

		//Procesar los datos recibidos
		$data = $request->getContent();

		//Verificar que hay datos
		$data = json_decode($data);

		if($data){
			//TODO: validar los datos introducidos
            //Crear el ninja
            $ninja = new Ninja();


			//Valores obligatorios
			$ninja->name = $data->name;
			$ninja->skill_inform = $data->skill_inform;

			//Valores opcionales
            if(isset($data->rank))
                $ninja->rank = $data->rank;
            if(isset($data->status))
                $ninja->status = $data->status;

            //Guardar el ninja
            try{

                $ninja->save();

                $response = "Ninja with name:".$ninja->name." saved successfully";
            }catch(\Exception $e){
                print("entro");
                $response = $e->getMessage();
            }

		}else{
			$response = "Incorrect Data";
		}
		
		return response($response);
    }
    
    public function editNinja(Request $request,$id){

		$response = "";

		//Buscar si existe la nave
		$ninja = Ninja::find($id);

		if($ninja){

			//Procesar los datos recibidos
			$data = $request->getContent();

			//Verificar que hay datos
			$data = json_decode($data);

			if($data){

				//TODO: validar los datos introducidos

				if(isset($data->name))
					$ninja->name = $data->name;
				if(isset($data->skill_inform))
					$ninja->skill_inform = $data->skill_inform;
                if(isset($data->rank))
                    $ninja->rank = $data->rank;
                if(isset($data->status))
                    $ninja->status = $data->status;

				//Guardar el ninja
				try{

					$ninja->save();

					$response = "Ninja with name:".$ninja->name." updated successfully";
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
    
    public function changeNinjaStatus(Request $request,$id){

		$response = "";

		//Buscar si existe la nave
		$ninja = Ninja::find($id);

		if($ninja){

			//Procesar los datos recibidos
			$data = $request->getContent();

			//Verificar que hay datos
			$data = json_decode($data);

			if($data){

				//TODO: validar los datos introducidos

                if(isset($data->status)){
                    $ninja->status = $data->status;

                    //Guardar el ninja
                    try{

                        $ninja->save();

                        $response = "Ninja with name:".$ninja->name." status updated successfully";
                    }catch(\Exception $e){
                        $response = $e->getMessage();
                    }
                }else{
                    $response = "Status unchanged";
                }

			}else{
				$response = "Incorrect Data";
			}
		}else{
			$response = "Ninja Not Found";
		}

		return response($response);
	}

	public function listNinjas(){

		$ninjas = Ninja::all();

		$result = [];

		foreach ($ninjas as $ninja) {
			
			$result[] = [

				"name" => $ninja->name,
				"register_date" => $ninja->created_at,
                "rank" => $ninja->rank,
                "status" => $ninja->status

			];

		}

		return response()->json($result);

    }
    
    public function checkNinja($id){

		$ninja = Ninja::find($id);

		if($ninja){

			return response()->json(

				[
					"id" => $ninja->id,
					"name" => $ninja->name,
					"rank" => $ninja->rank,
					"skill_inform" => $ninja->skill_inform,
                    "status" => $ninja->status,
                    "register_date" => $ninja->created_at
                ]
                
                //ADD MISSIONS

			);
		}

		return response("Ninja Not Found");
	}

}
