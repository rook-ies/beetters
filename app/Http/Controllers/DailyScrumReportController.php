<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Validator;
use App\DailyScrumReport;
use App\Obstacle;

class DailyScrumReportController extends Controller
{
    public function index()
    {
        return response()->json(['success'=>'true','data'=>DailyScrumReport::all()],200);
    }

    public function show(DailyScrumReport $dailyScrumReport)
    {
        return response()->json(['success'=>'true','data'=>$dailyScrumReport],200);
    }

    public function store(Request $request)
    {
        //return response()->json(['req'=>$request->obstaclesb], 200);
        $validator = Validator::make($request->all(), [
            'id_team' => 'required',
            'last_24_hour_activities' => 'required',
            'next_24_hour_activities' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 200);
        }

        $dailyScrumReport = new DailyScrumReport;
        $dailyScrumReport->id_user = Auth::guard('api')->id();
        $dailyScrumReport->id_team = $request->id_team;
        $dailyScrumReport->last_24_hour_activities = $request->last_24_hour_activities;
        $dailyScrumReport->next_24_hour_activities = $request->next_24_hour_activities;
        $dailyScrumReport->save();

        $obstacles = $request->obstaclesb;

        foreach ($obstacles as $obstacle) {
            // $validatorObstacle = Validator::make($request->all(), [
            //     'content' => 'required',
            // ]);
            //
            // if ($validatorObstacle->fails()) {
            //     return response()->json(['error'=>$validatorObstacle->errors()], 200);
            // }

            $obstacleTable = new Obstacle;
            // $obstacleTable->id_daily_scrum_report = 7;
            $obstacleTable->id_daily_scrum_report = $dailyScrumReport->id;
            $obstacleTable->content = $obstacle['content'];

            $obstacleTable->save();
        }

        return response()->json(['success'=>'true','data'=>$dailyScrumReport,'data2'=>$obstacles],201);
    }

    public function getObstacle(Request $request){

    }

    public function check(Request $request){
        $validator = Validator::make($request->all(), [
            'id_team' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 200);
        }
      $todayDate = date('Y-m-d');
      $query = DailyScrumReport::where('id_user',Auth::guard('api')->id())
                                ->whereDate('created_at',$todayDate)
                                ->where('id_team',$request->id_team)->count();
      if ($query > 0) {
        return response()->json(['message'=>'sudah mengisi data hari ini']);
      } else {
        return response()->json(['message'=>'Belum mengisi data hari ini']);
      }
    }

    public function update(Request $request, DailyScrumReport $dailyScrumReport)
    {
        $validator = Validator::make($request->all(), [
            'id_team' => 'required',
            'last_24_hour_activities' => 'required',
            'next_24_hour_activities' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 200);
        }

        $dailyScrumReport->update($request->all());

        return response()->json(['success'=>'true','data'=>$dailyScrumReport],200);
    }

    public function delete(DailyScrumReport $dailyScrumReport)
    {
        $dailyScrumReport->delete();

        return response()->json(['success'=>'true','message'=>'successfully delete'],200);
    }
}
