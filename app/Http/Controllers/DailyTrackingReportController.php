<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Validator;
use App\DailyTrackingReport;
use App\UserTeam;
use App\User;
class DailyTrackingReportController extends Controller
{
    public function index()
    {
        return response()->json(['success'=>'true','data'=>DailyTrackingReport::all()],200);
    }

    public function show(DailyTrackingReport $dailyTrackingReport)
    {
        return response()->json(['success'=>'true','data'=>$dailyTrackingReport],200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'productive_value' => 'required',
            'netral_value' => 'required',
            'not_productive_value' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 200);
        }

        $dailyTrackingReport = new DailyTrackingReport;
        $dailyTrackingReport->id_user = Auth::guard('api')->id();
        $dailyTrackingReport->productive_value = $request->productive_value;
        $dailyTrackingReport->netral_value = $request->netral_value;
        $dailyTrackingReport->not_productive_value = $request->not_productive_value;
        $dailyTrackingReport->save();

        return response()->json(['success'=>'true','data'=>$dailyTrackingReport],201);
    }

    public function update(Request $request, DailyTrackingReport $dailyTrackingReport)
    {
        $validator = Validator::make($request->all(), [
            'productive_value' => 'required',
            'netral_value' => 'required',
            'not_productive_value' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 200);
        }

        $dailyTrackingReport->update($request->all());

        return response()->json(['success'=>'true','data'=>$dailyTrackingReport],200);
    }

    public function delete(DailyTrackingReport $dailyTrackingReport)
    {
        $dailyTrackingReport->delete();

        return response()->json(['success'=>'true','message'=>'successfully delete'],200);
    }
    public function overalPerUser()
    {
        $todayDate = date('Y-m-d');
        $dailyTrackingReportCount = DailyTrackingReport::where('id_user', Auth::guard('api')->id())->whereDate('created_at',$todayDate)->count();
        if($dailyTrackingReportCount>0){
            $dailyTrackingReport = DailyTrackingReport::where('id_user', Auth::guard('api')->id())->whereDate('created_at',$todayDate)->first();
            $productiveValue=
            $netralValue=0;
            $notProductiveValue=0;
            $pembagi=$dailyTrackingReportCount;
            $data['value']['productive_value'] = $dailyTrackingReport->productive_value;
            $data['value']['netral_value'] = $dailyTrackingReport->netral_value;
            $data['value']['not_productive_value'] = $dailyTrackingReport->not_productive_value;
        }
        else{
            $data['value']['productive_value'] = 0;
            $data['value']['netral_value'] = 0;
            $data['value']['not_productive_value'] = 0;
        }

        return response()->json(['success'=>'true','data'=>$data],200);
    }
    public function historyPerUser()
    {
        $todayDate = date('Y-m-d');
        $from =  date('Y-m-d',strtotime('-6 days',strtotime($todayDate)));
        $to = $todayDate;
        $dailyTrackingReportCount = DailyTrackingReport::where('id_user', Auth::guard('api')->id())->whereBetween('created_at', [$from, $to])->count();
        if($dailyTrackingReportCount>0){
            $date=$from;
            for ($i=0; $i < 7; $i++) {
                $date = date('Y-m-d',strtotime('+'.$i.' days',strtotime($from)));
                $dailyTrackingReportDate = DailyTrackingReport::where('id_user', Auth::guard('api')->id())->whereDate('created_at', $date)->count();
                if($dailyTrackingReportDate>0){
                    $key = DailyTrackingReport::where('id_user', Auth::guard('api')->id())->whereDate('created_at', $date)->first();
                    $data[$i]['value']['productive_value'] = $key['productive_value'];
                    $data[$i]['value']['netral_value'] =  $key['netral_value'];
                    $data[$i]['value']['not_productive_value'] =  $key['not_productive_value'];
                    $data[$i]['value']['date'] = $key['created_at'];
                }
                else{
                    $data[$i]['value']['productive_value'] = 0;
                    $data[$i]['value']['netral_value'] = 0;
                    $data[$i]['value']['not_productive_value'] =  0;
                    $data[$i]['value']['date'] = $date;
                }
            }
        }
        else{
            $data[0]['value']['productive_value'] = 0;
            $data[0]['value']['netral_value'] = 0;
            $data[0]['value']['not_productive_value'] = 0;
        }

        return response()->json(['success'=>'true','data'=>$data],200);
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
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 200);
        }
        $userTeams = UserTeam::where('id_team',$request->id_team)->orderBy('id_role', 'asc')->get();

        $i=0;
        $memberArray= array();
        foreach ($userTeams as $member) {
            $memberArray[$i]['user'] = User::where('id', $member->id_user)->first();
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
                $memberArray[$i]['value']['productive_value'] = $productiveValue;
                $memberArray[$i]['value']['netral_value'] = $netralValue;
                $memberArray[$i]['value']['not_productive_value'] = $notProductiveValue;
            }else{
                $memberArray[$i]['value']['productive_value'] = 0;
                $memberArray[$i]['value']['netral_value'] = 0;
                $memberArray[$i]['value']['not_productive_value'] = 0;
            }
            $i++;
         }
         function sortBySubkey(&$array, $subkey, $sortType = SORT_DESC) {
            foreach ($array as $subarray) {
                $keys[] = $subarray[$subkey];
            }
            array_multisort($keys, $sortType, $array);
        }
        $keys = "value";
        sortBySubkey($memberArray, $keys);
         //arsort($memberArray);
        // echo $grandTotal;
        return response()->json(['success'=>'true','data'=>$memberArray],200);
    }
}
