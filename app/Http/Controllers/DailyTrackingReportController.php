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
        $dailyTrackingReportCount = DailyTrackingReport::where('id_user', Auth::guard('api')->id())->count();
        if($dailyTrackingReportCount>0){
            $dailyTrackingReport = DailyTrackingReport::where('id_user', Auth::guard('api')->id())->get();
            $total=0;
            $pembagi=$dailyTrackingReportCount;
            foreach ($dailyTrackingReport as $key) {
                $total = $total + $key['productive_value'];
            }
            $total = $total/$pembagi;
            //echo "total : ".$total;
            return response()->json(['success'=>'true','productive_value'=>$total],200);
        }
        else{
            return response()->json(['success'=>'true','productive_value'=>0],200);
        }
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
        $grandTotal=0;
        foreach ($userTeams as $member) {
            $dailyTrackingReportCount = DailyTrackingReport::where('id_user', $member->id_user)->count();
            if($dailyTrackingReportCount>0){
                $dailyTrackingReport = DailyTrackingReport::where('id_user', $member->id_user)->get();
                $total=0;
                $pembagi=$dailyTrackingReportCount;
                foreach ($dailyTrackingReport as $key) {
                    $total = $total + $key['productive_value'];
                }
                $total = $total/$pembagi;
                //echo "total : ".$total;
                $grandTotal = $grandTotal + $total;
            }
            $i++;
         }
        $grandTotal = $grandTotal/$i;
        // echo $grandTotal;
        return response()->json(['success'=>'true','productive_value'=>$grandTotal],200);
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
                $total=0;
                $pembagi=$dailyTrackingReportCount;
                foreach ($dailyTrackingReport as $key) {
                    $total = $total + $key['productive_value'];
                }
                $total = $total/$pembagi;
                //echo "total : ".$total;
                $memberArray[$i]['productive_value'] = $total;
            }else{
                $memberArray[$i]['productive_value'] = 0;
            }
            $i++;
         }
         krsort($memberArray);
        // echo $grandTotal;
        return response()->json(['success'=>'true','data'=>$memberArray],200);
    }
}
