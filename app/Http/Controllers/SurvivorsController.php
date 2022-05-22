<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Survivors;
use App\Models\InfectedReport;
use Validator;

class SurvivorsController extends Controller
{
    ///add survivors in DB
    public function add_survivors(Request $request)
    {

        $validator = \Validator::make(
                $request->all(),
                [
                    'name'    => 'required',
                    'age'     => 'required|numeric',
                    'gender'  => 'required',
                    'lat'     => 'required',
                    'lng'     => 'required',
                    'food'    => 'required|numeric',
                    'water'   => 'required|numeric',
                    'medication'  => 'required|numeric',
                    'ammunition'  => 'required|numeric',
                ]
            );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            return response()->json([
             'message' => $messages
               ]);
        }
        $survivor = new Survivors;
        $survivor->name = $request->name;
        $survivor->age = $request->age;
        $survivor->gender = $request->gender;
        $survivor->lat = $request->lat;
        $survivor->lng = $request->lng;
        $survivor->food = $request->food;
        $survivor->water = $request->water;
        $survivor->medication = $request->medication;
        $survivor->ammunition = $request->ammunition;
        if($survivor->save()){
            $res=[
                'responseCode'=>1,
                'message' => 'Data inserted successfully',
                ];
                return response()->json($res);
        }
        else{
            $res=[
                'responseCode'=>0,
                'message' => 'Something went wrong',
                ];
                return response()->json($res);
        }
    }
  ////update location of survivor
public function update_location(Request $request)
    {
        $validator = \Validator::make(
                $request->all(),
                [
                    'survivor_id' => 'required|numeric',
                    'lat'         => 'required',
                    'lng'         => 'required',
                ]
            );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            return response()->json([
             'message' => $messages
            ]);
        }
        $Survivor = Survivors::findOrFail($request->survivor_id);
        if($Survivor){
            $Survivor->lat = $request->lat;
            $Survivor->lng = $request->lng;
            if($Survivor->save()){
                $res=[
                'responseCode'=>1,
                'message' => 'Location Updated successfully',
                ];
                return response()->json($res);
            }
            $res=[
                'responseCode'=>0,
                'message' => 'Something went wrong',
                ];
                return response()->json($res);
        }
        $res=[
                'responseCode'=>0,
                'message' => 'Survivor not found',
                ];
                return response()->json($res);
    }
public function infected_report(Request $request)
    { 
        $validator = \Validator::make(
                $request->all(),
                [
                    'survivor_id' => 'required|numeric',
                    'report_by'   => 'required',
                    // 'flag'        => 'required',
                ]
            );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            return response()->json([
             'message' => $messages
            ]);
        }
      
       $infected_person = Survivors::findOrFail($request->survivor_id);

       $report_by_person = Survivors::findOrFail($request->report_by);
       ////
       $IsReported=InfectedReport::where('survivor_id', $request->survivor_id)
            ->where('report_by',$request->report_by)
            ->get();
        if ($IsReported) 
        {
            $res=[  
            'responseCode'=>0,
            'message' => 'This report_by already report this survivor_id',
            ];
            return response()->json($res);
        }    
       ///
       if ($infected_person) {
            if ($report_by_person) {
              
        $infectedReport = new InfectedReport;
        $infectedReport->report_by   = $request->report_by;
        $infectedReport->survivor_id = $request->survivor_id;
        $infectedReport->flag        = 1;
        if($infectedReport->save()){
            // echo "string";die;
            ///check the max limit 3
            $flag=0;  
            $InfectedCount=InfectedReport::where('survivor_id', $request->survivor_id)
            ->where('flag', 1)
            ->get(); 
            // echo "string";print_r(count($InfectedCount));
            // die();
            $count=count($InfectedCount);
            if ($count<=3) {
                $flag=1;
                ////update in Survivor table
                $infected_person->is_infected=1;
                if($infected_person->save()){
                $res=[
                'responseCode'=>1,
                'message' => 'Data insert & Updated successfully',
                ];
                return response()->json($res); 
                }
                else{
                $res=[   
                'responseCode'=>0,
                'message' => 'Something went wrong',
                ];
                return response()->json($res);
                }
            }else{
                $res=[
                'responseCode'=>1,
                'message' => 'infected person report by less then 3 person',
                ];
                return response()->json($res);    
            }

            }
            else{
                $res=[  
                'responseCode'=>0,
                'message' => 'Something went wrong',
                ];
                return response()->json($res);
            }
        }
        else{
            $res=[  
            'responseCode'=>0,
            'message' => 'report_by not found',
            ];
            return response()->json($res);
        } 
    }
    else{
        $res=[  
            'responseCode'=>0,
            'message' => 'report_by not found',
            ];
            return response()->json($res);
        } 
 }
}
