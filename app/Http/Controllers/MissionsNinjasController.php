<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ninja;
use App\Models\Mission;
use App\Models\MissionsNinjas;

use App\Http\Controllers\MissionController;

class MissionsNinjasController extends Controller
{

    protected $MissionController;
    public function __construct(MissionController $MissionController)
    {
        $this->MissionController = $MissionController;
    }

    //
    public function assignNinja($ninjaID,$missionID){

        $response = "";

        $ninja = Ninja::find($ninjaID);
        $mission = Mission::find($missionID);

        if($ninja && $mission){
            $missionsNinjas = new MissionsNinjas();

            $missionsNinjas->ninja_id = $ninja->id;
            $missionsNinjas->mission_id = $mission->id;

            try{

                $missionsNinjas->save();
                $this->MissionController->startMission($mission->id);

                $response = $ninja->name." assigned to the mission ".$mission->id;
            }catch(\Exception $e){
                print("entro");
                $response = $e->getMessage();
            }
        }else{
            $response = "Ninja or Mission Not Found";
        }
        
        return response($response);

    }

    public function dismissNinja($ninjaID,$missionID){

        $response = "";

        if(isset($ninjaID) && isset($missionID)){
            $missionsNinjas = MissionsNinjas::where('mission_id',$missionID)->get();
            foreach ($missionsNinjas as $missionNinja) {
            
                if($missionNinja->ninja_id == $ninjaID){
                    $ninjaToDismiss = $missionNinja;
                }
            }

            if(isset($ninjaToDismiss)){
                try{

                    $ninjaToDismiss->delete();
    
                    $response = "Dismissed Ninja";
                }catch(\Exception $e){
                    print("entro");
                    $response = $e->getMessage();
                }
                
            }else{
                $response = "Assignment Not Found";
            }
        }else{
            $response = "Missing parameters";
        }
        
        return response($response);
    }
}
