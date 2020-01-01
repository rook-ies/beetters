<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Validator;
use App\DailyTrackingReport;
use App\ApplicationTrackingHistory;
use App\TrackingHistory;
use App\Application;
use App\UserTeam;
use App\User;
class DailyTrackingReportController extends Controller
{

    public function overalPerUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 200);
        }
        $date = $request->date;
        $dailyTrackingReportCount = DailyTrackingReport::where('id_user', Auth::guard('api')->id())->whereDate('created_at',$date)->count();
        if($dailyTrackingReportCount>0){
            $dailyTrackingReport = DailyTrackingReport::where('id_user', Auth::guard('api')->id())->whereDate('created_at',$date)->first();
            $productiveValue=
            $netralValue=0;
            $notProductiveValue=0;
            $pembagi=$dailyTrackingReportCount;
            $data['value'][0] = $dailyTrackingReport->productive_value;
            $data['value'][1] = $dailyTrackingReport->netral_value;
            $data['value'][2] = $dailyTrackingReport->not_productive_value;

            $trakingHistorysid = TrackingHistory::where('id_user',Auth::guard('api')->id())
                                    ->whereDate('created_at',$date)->first()->id;
            $grandTotal=0;
            $applicationTrackingHistory = ApplicationTrackingHistory::
                where('id_tracking_history',$trakingHistorysid)->get();

            $i=0;
            $j=0;
            $k=0;

            $data['app']['productive'][0]['name'] = "noting";
            $data['app']['productive'][0]['duration'] = "0 second";
            $data['app']['netral'][0]['name'] = "noting";
            $data['app']['netral'][0]['duration'] = "0 second";
            $data['app']['not_productive'][0]['name'] = "noting";
            $data['app']['not_productive'][0]['duration'] = "0 second";
            foreach ($applicationTrackingHistory as $key) {
                $app = Application::where('id',$key->id_application)->first();
                $grandTotal+=$key->duration;
                if($app->id_app_productivity_type==1){
                    $data['app']['productive'][$i]['name'] = $app->name;
                    $data['app']['productive'][$i]['duration'] = $key->duration." second";
                    $i++;
                }else if($app->id_app_productivity_type==2){
                    $data['app']['netral'][$j]['name'] = $app->name;
                    $data['app']['netral'][$j]['duration'] = $key->duration." second";
                    $j++;
                }else{
                    $data['app']['not_productive'][$k]['name'] = $app->name;
                    $data['app']['not_productive'][$k]['duration'] = $key->duration." second";
                    $k++;
                }
            }
            $data['time_consumed'] = $grandTotal;
        }
        else{
            $data['time_consumed'] = 0;
            $data['value'][0] = 0;
            $data['value'][1] = 0;
            $data['value'][2] = 0;
            $data['app']['productive'][0]['name'] = "nothing";
            $data['app']['productive'][0]['duration'] = "0 second";
            $data['app']['netral'][0]['name'] = "nothing";
            $data['app']['netral'][0]['duration'] = "0 second";
            $data['app']['not_productive'][0]['name'] = "nothing";
            $data['app']['not_productive'][0]['duration'] = "0 second";
        }

        return response()->json(['success'=>'true','data'=>$data],200);
    }
    public function overalPerUserId(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required',
            'id_user'=>'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 200);
        }
        $date = $request->date;
        $dailyTrackingReportCount = DailyTrackingReport::where('id_user', $request->id_user)->whereDate('created_at',$date)->count();
        if($dailyTrackingReportCount>0){
            $dailyTrackingReport = DailyTrackingReport::where('id_user', $request->id_user)->whereDate('created_at',$date)->first();
            $productiveValue=
            $netralValue=0;
            $notProductiveValue=0;
            $pembagi=$dailyTrackingReportCount;
            $data['value'][0] = $dailyTrackingReport->productive_value;
            $data['value'][1] = $dailyTrackingReport->netral_value;
            $data['value'][2] = $dailyTrackingReport->not_productive_value;

            $trakingHistorysid = TrackingHistory::where('id_user',$request->id_user)
                                    ->whereDate('created_at',$date)->first()->id;
            $grandTotal=0;
            $applicationTrackingHistory = ApplicationTrackingHistory::
                where('id_tracking_history',$trakingHistorysid)->get();

            $i=0;
            $j=0;
            $k=0;

            $data['app']['productive'][0]['name'] = "noting";
            $data['app']['productive'][0]['duration'] = "0 second";
            $data['app']['netral'][0]['name'] = "noting";
            $data['app']['netral'][0]['duration'] = "0 second";
            $data['app']['not_productive'][0]['name'] = "noting";
            $data['app']['not_productive'][0]['duration'] = "0 second";
            foreach ($applicationTrackingHistory as $key) {
                $app = Application::where('id',$key->id_application)->first();
                $grandTotal+=$key->duration;
                if($app->id_app_productivity_type==1){
                    $data['app']['productive'][$i]['name'] = $app->name;
                    $data['app']['productive'][$i]['duration'] = $key->duration." second";
                    $i++;
                }else if($app->id_app_productivity_type==2){
                    $data['app']['netral'][$j]['name'] = $app->name;
                    $data['app']['netral'][$j]['duration'] = $key->duration." second";
                    $j++;
                }else{
                    $data['app']['not_productive'][$k]['name'] = $app->name;
                    $data['app']['not_productive'][$k]['duration'] = $key->duration." second";
                    $k++;
                }
            }
            $data['time_consumed'] = $grandTotal;
        }
        else{
            $data['time_consumed'] = 0;
            $data['value'][0] = 0;
            $data['value'][1] = 0;
            $data['value'][2] = 0;
            $data['app']['productive'][0]['name'] = "nothing";
            $data['app']['productive'][0]['duration'] = "0 second";
            $data['app']['netral'][0]['name'] = "nothing";
            $data['app']['netral'][0]['duration'] = "0 second";
            $data['app']['not_productive'][0]['name'] = "nothing";
            $data['app']['not_productive'][0]['duration'] = "0 second";
        }

        return response()->json(['success'=>'true','data'=>$data],200);
    }
    public function overalPerUserTeam(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required',
            'id_team'=>'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 200);
        }
        $userTeamIds = UserTeam::where('id_team',$request->id_team)->get();
        $date = $request->date;
        $uid=0;
        foreach ($userTeamIds as $key) {
            $dailyTrackingReportCount = DailyTrackingReport::where('id_user', $key->id_user)->whereDate('created_at',$date)->count();
            if($dailyTrackingReportCount>0){
                $dailyTrackingReport = DailyTrackingReport::where('id_user', $key->id_user)->whereDate('created_at',$date)->first();
                $productiveValue=
                $netralValue=0;
                $notProductiveValue=0;
                $pembagi=$dailyTrackingReportCount;
                $data[$uid]['user']=User::where('id', $key->id_user)->first();
                $data[$uid]['value'][0] = $dailyTrackingReport->productive_value;
                $data[$uid]['value'][1] = $dailyTrackingReport->netral_value;
                $data[$uid]['value'][2] = $dailyTrackingReport->not_productive_value;

                $trakingHistorysid = TrackingHistory::where('id_user',$key->id_user)
                                        ->whereDate('created_at',$date)->first()->id;
                $grandTotal=0;
                $applicationTrackingHistory = ApplicationTrackingHistory::
                    where('id_tracking_history',$trakingHistorysid)->get();

                $i=0;
                $j=0;
                $k=0;
                $data[$uid]['app']['productive'][0]['name'] = "noting";
                $data[$uid]['app']['productive'][0]['duration'] = "0 second";
                $data[$uid]['app']['netral'][0]['name'] = "noting";
                $data[$uid]['app']['netral'][0]['duration'] = "0 second";
                $data[$uid]['app']['not_productive'][0]['name'] = "noting";
                $data[$uid]['app']['not_productive'][0]['duration'] = "0 second";
                foreach ($applicationTrackingHistory as $key) {
                    $app = Application::where('id',$key->id_application)->first();
                    $grandTotal+=$key->duration;
                    if($app->id_app_productivity_type==1){
                        $data[$uid]['app']['productive'][$i]['name'] = $app->name;
                        $data[$uid]['app']['productive'][$i]['duration'] = $key->duration." second";
                        $i++;
                    }else if($app->id_app_productivity_type==2){
                        $data[$uid]['app']['netral'][$j]['name'] = $app->name;
                        $data[$uid]['app']['netral'][$j]['duration'] = $key->duration." second";
                        $j++;
                    }else{
                        $data[$uid]['app']['not_productive'][$k]['name'] = $app->name;
                        $data[$uid]['app']['not_productive'][$k]['duration'] = $key->duration." second";
                        $k++;
                    }
                }
                $data[$uid]['time_consumed'] = $grandTotal/3600;
            }
            else{
                $data[$uid]['user']=User::where('id', $key->id_user)->first();
                $data[$uid]['value'][0] = 0;
                $data[$uid]['value'][1] = 0;
                $data[$uid]['value'][2] = 0;
                $data[$uid]['app']['productive'][0]['name'] = "nothing";
                $data[$uid]['app']['productive'][0]['duration'] = "0 second";
                $data[$uid]['app']['netral'][0]['name'] = "nothing";
                $data[$uid]['app']['netral'][0]['duration'] = "0 second";
                $data[$uid]['app']['not_productive'][0]['name'] = "nothing";
                $data[$uid]['app']['not_productive'][0]['duration'] = "0 second";
                $data[$uid]['time_consumed'] = 0;
            }
            $uid++;
        }
            return response()->json(['success'=>'true','data'=>$data],200);
    }

    public function historyPerUser()
    {
        $todayDate = date('Y-m-d');
        $from =  date('Y-m-d',strtotime('-6 days',strtotime($todayDate)));
        $to = $todayDate;
        $dailyTrackingReportCount = DailyTrackingReport::where('id_user', Auth::guard('api')->id())->whereBetween('created_at', [$from, $to])->count();
        $totalTime = 0;
        if($dailyTrackingReportCount>0){
            $date=$from;
            for ($i=0; $i < 7; $i++) {
                $date = date('Y-m-d',strtotime('+'.$i.' days',strtotime($from)));
                $dailyTrackingReportDate = DailyTrackingReport::where('id_user', Auth::guard('api')->id())->whereDate('created_at', $date)->count();
                if($dailyTrackingReportDate>0){
                    $key = DailyTrackingReport::where('id_user', Auth::guard('api')->id())->whereDate('created_at', $date)->first();
                    $data[$i] = $key['productive_value'];
                    $dailyTrackingReportId = $key['id'];
                    $duration = ApplicationTrackingHistory::where('id_tracking_history',$dailyTrackingReportId)->get();
                    foreach ($duration as $durationItem) {
                        $totalTime = $totalTime + $durationItem['duration'];
                    }
                }
                else{
                     $data[$i] = 0;
                }
            }
        }
        else{
            $data[0] = 0;
        }

        return response()->json(['success'=>'true','data'=>$data,'total_time'=>$totalTime],200);
    }
    public function historyPerTeam(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_team' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 200);
        }
        $todayDate = date('Y-m-d');
        $from =  date('Y-m-d',strtotime('-6 days',strtotime($todayDate)));
        $to = $todayDate;
        $userTeamsCount = UserTeam::where('id_team', $request->id_team)->count();
        $userTeams = UserTeam::where('id_team', $request->id_team)->get();
        $chart=array();
        $average=0;
        $date=$from;
        $totalTime =0;
        for ($i=0; $i < 7; $i++) {
            $totalToday=0;
            foreach ($userTeams as $key) {
                $date = date('Y-m-d',strtotime('+'.$i.' days',strtotime($from)));
                $dailyTrackingReportDate = DailyTrackingReport::where('id_user', $key->id_user)->whereDate('created_at', $date)->count();
                if($dailyTrackingReportDate>0){
                    $key = DailyTrackingReport::where('id_user', $key->id_user)->whereDate('created_at', $date)->first();
                    $totalToday+= $key['productive_value'];
                    $dailyTrackingReportId = $key['id'];
                    $duration = ApplicationTrackingHistory::where('id_tracking_history',$dailyTrackingReportId)->get();
                    foreach ($duration as $durationItem) {
                        $totalTime = $totalTime + $durationItem['duration'];
                    }
                }
            }
            $totalToday = $totalToday/$userTeamsCount;
            $average+=$totalToday;
            $chart[$i]=$totalToday;
        }
        $average=$average/7;
        return response()->json(['success'=>'true','data'=>$chart,'average'=>$average,'total_time'=>$totalTime],200);
    }
    public function overalPerTeam(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_team' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 200);
        }
        $userTeams = UserTeam::where('id_team',$request->id_team)->orderBy('id_role', 'asc')->get();

        $i=0;
        $grandTotal['value']['productive_value']=0;
        $grandTotal['value']['netral_value']=0;
        $grandTotal['value']['not_productive_value']=0;
        foreach ($userTeams as $member) {
            $dailyTrackingReportCount = DailyTrackingReport::where('id_user', $member->id_user)->count();
            if($dailyTrackingReportCount>0){
                $dailyTrackingReport = DailyTrackingReport::where('id_user', $member->id_user)->get();
                $productiveValue=0;
                $netralValue=0;
                $notProductiveValue=0;
                $pembagi=$dailyTrackingReportCount;
                foreach ($dailyTrackingReport as $key) {
                    $productiveValue = $productiveValue + $key['productive_value'];
                    $netralValue = $netralValue + $key['netral_value'];
                    $notProductiveValue = $notProductiveValue + $key['not_productive_value'];
                }
                $productiveValue = $productiveValue/$pembagi;
                $netralValue = $netralValue/$pembagi;
                $notProductiveValue = $notProductiveValue/$pembagi;
                //echo "total : ".$total;
                $grandTotal['value']['productive_value'] = $grandTotal['value']['productive_value'] + $productiveValue;
                $grandTotal['value']['netral_value'] = $grandTotal['value']['netral_value'] + $netralValue;
                $grandTotal['value']['not_productive_value'] = $grandTotal['value']['not_productive_value'] + $notProductiveValue;
            }
            $i++;
         }
        $grandTotal['value']['productive_value'] = $grandTotal['value']['productive_value']/$i;
        $grandTotal['value']['netral_value'] = $grandTotal['value']['netral_value']/$i;
        $grandTotal['value']['not_productive_value'] = $grandTotal['value']['not_productive_value']/$i;
        // echo $grandTotal;
        return response()->json(['success'=>'true','data'=>$grandTotal],200);
    }
    public function overalPerMemberTeam(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_team' => 'required',
            'date' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 200);
        }
        $userTeams = UserTeam::where('id_team',$request->id_team)->orderBy('id_role', 'asc')->get();

        $i=0;
        $date = $request->date;
        $memberArray= array();
        foreach ($userTeams as $member) {
            $memberArray[$i]['user'] = User::where('id', $member->id_user)->first();
            $dailyTrackingReportCount = DailyTrackingReport::where('id_user', $member->id_user)->whereDate('created_at',$date)->count();
            if($dailyTrackingReportCount>0){
                $key = DailyTrackingReport::where('id_user', $member->id_user)->whereDate('created_at',$date)->first();
                $memberArray[$i]['value']['productive_value'] = $key->productive_value;
                $memberArray[$i]['value']['netral_value'] = $key->netral_value;
                $memberArray[$i]['value']['not_productive_value'] = $key->not_productive_value;

                $trakingHistorysid = TrackingHistory::where('id_user',$member->id_user)
                                    ->whereDate('created_at',$date)->first()->id;
                $grandTotal=0;
                $applicationTrackingHistory = ApplicationTrackingHistory::
                    where('id_tracking_history',$trakingHistorysid)->get();

                foreach ($applicationTrackingHistory as $key) {
                    $app = Application::where('id',$key->id_application)->first();
                    $grandTotal+=$key->duration;
                }
                $memberArray[$i]['time_consumed'] = $grandTotal/3600;
            }else{
                $memberArray[$i]['value']['productive_value'] = 0;
                $memberArray[$i]['value']['netral_value'] = 0;
                $memberArray[$i]['value']['not_productive_value'] = 0;
                $memberArray[$i]['time_consumed'] = 0;
            }
            $i++;
         }
         function sortBySubkey(&$array, $subkey, $sortType = SORT_ASC) {
            foreach ($array as $subarray) {
                $keys[] = $subarray[$subkey];
            }
            array_multisort($keys, $sortType, $array);
        }
        $keys = "value";
        sortBySubkey($memberArray, $keys);
        return response()->json(['success'=>'true','data'=>$memberArray],200);
    }
    public function rewardPerUser()
    {
        $month = date('m');
        $idUser = Auth::guard('api')->id();
        $tracking = DailyTrackingReport::where('id_user',$idUser)->whereMonth('created_at',$month)->get();
        $totalReward = 0;
        foreach ($tracking as $key) {
            $totalReward = $totalReward + $key['productive_value'];
        }
        return response()->json(['success'=>'true','data'=>$totalReward],200);
    }
    public function rewardTablePerTeam(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_team' => 'required',
            'date' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 200);
        }
        $userTeams = UserTeam::where('id_team',$request->id_team)->get();
        $timestamp = strtotime($request->date);
        $month = date('m', $timestamp);
        $i=0;
        $grandTotal = 0;
        $dataReward= array();
        foreach ($userTeams as $key) {
            $idUser = $key['id_user'];
            $dataReward[$i]['user'] = User::where('id',$idUser)->first()->name;
            $tracking = DailyTrackingReport::where('id_user',$idUser)->whereMonth('created_at',$month)->get();
            $totalReward = 0;
            foreach ($tracking as $trackingKey) {
                $totalReward = $totalReward + $trackingKey['productive_value'];
            }
            $dataReward[$i]['reward'] = $totalReward;
            $grandTotal = $grandTotal + $totalReward;
            $tracking = DailyTrackingReport::where('id_user',$idUser)->whereDate('created_at',$request->date)->get();
            $totalReward = 0;
            foreach ($tracking as $trackingKey) {
                $totalReward = $totalReward + $trackingKey['productive_value'];
            }
            $dataReward[$i]['current_reward'] = $totalReward;
            $dataReward[$i]['date'] = $request->date;
            $i++;
        }
        return response()->json(['success'=>'true','data'=>$dataReward,'total'=>$grandTotal],200);

    }
}
