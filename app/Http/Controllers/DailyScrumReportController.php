<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Validator;
use App\DailyScrumReport;
use App\Obstacle;
use App\UserTeam;
use App\User;

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

        //$obstacles = $request->obstacles;

        // foreach ($obstacles as $obstacle) {
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
            // $obstacleTable->content = $obstacle['content'];
            $obstacleTable->content = $request->obstacle;

            $obstacleTable->save();
        // }

        return response()->json(['success'=>'true','data'=>$dailyScrumReport],201);
    }

    public function complete(Request $request){
      $validator = Validator::make($request->all(), [
          'id' => 'required',
          'date' => 'required',
      ]);
      if ($validator->fails()) {
          return response()->json(['error'=>$validator->errors()], 200);
      }

      $originalDate = $request->date;
      $date = date("Y-m-d", strtotime($originalDate));

      $userTeams = UserTeam::where('id_team',$request->id)->orderBy('id_role', 'asc')->get('id_user');
      $dailyTeam = DailyScrumReport::whereDate('created_at',$date)
                                ->where('id_team',$request->id)->get('id_user');
      $memberArray= array();
      // echo $userTeams;
      // echo $dailyTeam;
      $i=0;
        foreach ($userTeams as $member) {
            $found = 0;
            foreach ($dailyTeam as $key) {
              // echo $member->id_user;
              // echo $key->id_user;
              if($member->id_user == $key->id_user)
                $found=1;
            }
            if ($found == 1) {
               $memberArray[$i]['status'] = "complete";
            } else {
               $memberArray[$i]['status'] = "not complete";

            }
            $memberArray[$i]['user_detail'] = User::where('id',$member->id_user)->first();

            $i++;

        }

      return response()->json(['success'=>'true','data'=>$memberArray],200);

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

    public function list(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 200);
        }
        $originalDate = $request->date;
        $date = date("Y-m-d", strtotime($originalDate));
        $result = DailyScrumReport::where('id_team', $request->id)
                                 ->whereDate('created_at', $date)
                                ->get();
        $daily=array();
        $i=0;
        foreach ($result as $key) {
            $daily[$i]['user'] = User::where('id',$key->id_user)->first();
            $daily[$i]['daily'] = $key;
            $j=0;
            $obs = Obstacle::where('id_daily_scrum_report',$key->id)->get();
            $num = $obs->count();
            if($num>0){
                foreach ($obs as $ob) {
                    $daily[$i]['obstacle'][$j] = $ob;
                    $j++;
                }
            }else{
                $daily[$i]['obstacle'][0] = "----";
            }
            $i++;
        }
        return response()->json(['success'=>'true','data'=>$daily],200);
    }
}
