<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Robots;
use App\Models\Survivors;
use Validator;
use Session;
class RobotsController extends Controller
{
    public function index()
    {
        // return view('json_data');
        return view('demo');
    }
    ///add Robots data from json file to DB
    public function upload_json_data(Request $request)
    { 

        $validator = \Validator::make(
                $request->all(),
                [
                    'json_file' =>'required|mimes:json|max:2048',
                    // 'json_file' =>'required|max:2048',
                ]
            );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            // return redirect()->back()->withInput()->with('error', $messages->first());
            return redirect()->back()->withInput()->withErrors($validator, 'errormsg');
        }
         ///
        // $fileName = time().'.'.$request->json_file->extension();  
        $file = $request->file('json_file');
        $destinationPath = public_path()."/";
        $extension = $request->file('json_file')->extension();
       $name=rand().'.'.$file->getClientOriginalExtension();
        $image = $request->file('json_file');
        $destinationPath = public_path('/');
        $image->move($destinationPath, $name);
        ////
         $file_loc=asset('public/'.$name);
         $jsondata = file_get_contents($file_loc);
         $data = json_decode($jsondata, true);
         // echo "<pre>";print_r($data);die;
         foreach ($data as  $value) {
            $robot = new Robots;
            $robot->model = $value['model'];
            $robot->serialNumber = $value['serialNumber'];
            $robot->manufacturedDate = $value['manufacturedDate'];
            $robot->category = $value['category'];
            $robot->save();
         }
         Session::flash('message','Record inserted successfull..!!!'); 
        return redirect('upload-json-data');
    }
 public function robots_report()
 {
     $robots_data = Robots::all();
     $all_survivors_data = Survivors::all();
     $infectedSurvivorData = Survivors::where('is_infected','=',1)->get();
     $percentage_infected_survivor=count($infectedSurvivorData)*100/count($all_survivors_data);
     $data['infectedSurvivorData']=count($infectedSurvivorData);
     $data['percentage_infected_survivor_%']=$percentage_infected_survivor;
     ///
     $non_infectedSurvivorData = Survivors::where('is_infected','=',0)->get();
     $percentage_non_infected_survivor=count($non_infectedSurvivorData)*100/count($all_survivors_data);
     $data['non_infectedSurvivorData']=count($non_infectedSurvivorData);
     $data['percentage_non_infected_survivor_%']=$percentage_non_infected_survivor;
    
     $data['list_of_infected_survivor_data']=$infectedSurvivorData;
     $data['list_of_non_infected_survivor_data']=$non_infectedSurvivorData;
     $data['robots_data']=$robots_data;
      // echo "<pre>";print_r($data);
      return response()->json($data);
 }
}
