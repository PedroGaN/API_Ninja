<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NinjaController extends Controller
{
    //
    public function newMechanic(Request $request){

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
			$ninja->rank = (isset($data->rank) ? $data->rank : 'Genin');
            $ninja->status = (isset($data->status) ? $data->status : 'Active');

            //Guardar el ninja
            try{

                $ninja->save();

                $response = "Ninja with name:" + $data->name + " saved successfully";
            }catch(\Exception $e){
                $response = $e->getMessage();
            }

		}else{
			$response = "Incorrect Data";
		}
		


		return response($response);
	}
}
