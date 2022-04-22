<?php

namespace App\Http\Controllers;
use Laravel\Lumen\Routing\Controller as Controller;
use App\Models\Disability;
use Illuminate\Http\Request;

class DisabilityController extends Controller
{
    
     public function showOneDisability (Request $request)
     {

        // extracting request parameters
        $id = $request->input('ORG_ID');

        // Model objects
        $disability = new Disability(); 
        //Formate for failed api response
        $response = ["status" => 'failed'];

         if($id != null){

            $result = $disability->getDocTypeCount($id);
            $uidresult = $disability->getUidCount($id);

            //Response Format
            $response['status']='success';
            $response['data'] = ['Total_Disability_Certificate'=>0, 'Total_UID_Card'=>0, 'Total_Awards'=>0];
          
         
             foreach($result as $resultline) {

                if($resultline->DOC_TYPE == 'DPICR') {      
                // Count certificate when Doc Type is DPICR
                    $response['data']['Total_Disability_Certificate'] = $resultline->aggregate;
                    $response['data']['Total_Awards'] += $resultline->aggregate;
                
                }

            }

             foreach($uidresult as $resultline){

                if($resultline->UID == 'govid'){
                // Count certificate when Doc Type is govid
                    $response['data']['Total_UID_Card'] = $resultline->aggregate;
                    $response['data']['Total_Awards'] += $resultline->aggregate;
                }
            }

    }   


       return response()->json($response);
        
    }   
}