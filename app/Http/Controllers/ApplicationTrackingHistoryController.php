<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ApplicationTrackingHistory;
use App\DailyTrackingReport;
use App\TrackingHistory;
use App\Application;
use Illuminate\Support\Facades\Auth;
use Validator;

class ApplicationTrackingHistoryController extends Controller
{

  public function acceptRespones(Request $request)
  {
        $dt = $request->data;
        $duration = 120;
        $todayDate = date('Y-m-d');
        $trakingHistorysCount = TrackingHistory::where('id_user',Auth::guard('api')->id())
                                ->whereDate('created_at',$todayDate)->count();

        $trakingHistorysid = 0;
        $trakingHistory = new TrackingHistory;

        if($trakingHistorysCount==0){
            $trakingHistory->id_user = Auth::guard('api')->id();
            $trakingHistory->save();
            $trakingHistorysid = $trakingHistory->id;
        } else {
            $trakingHistorysid = TrackingHistory::where('id_user',Auth::guard('api')->id())
                                    ->whereDate('created_at',$todayDate)->first()->id;
        }

        foreach ((array) $dt as $key) {
            $appCount = Application::where('application_file_name', 'like', '%' . $key . '%')->count();
            if($appCount > 0){
                $appId = Application::where('application_file_name', 'like', '%' . $key . '%')->first()->id;

                $applicationTrackingHistoryCount = ApplicationTrackingHistory::
                    where('id_tracking_history',$trakingHistorysid)
                    ->where('id_application',$appId)->count();
                if($applicationTrackingHistoryCount>0){

                    $applicationTrackingHistory = ApplicationTrackingHistory::
                        where('id_tracking_history',$trakingHistorysid)
                        ->where('id_application',$appId)->first();
                    $applicationTrackingHistory->duration = $applicationTrackingHistory->duration + $duration;
                    $applicationTrackingHistory->end_time =
                        date('Y-m-d H:i:s',strtotime('+'.$duration.' second',strtotime($applicationTrackingHistory->end_time)));
                    $applicationTrackingHistory->save();
                }
                else {
                    $datetime = date('Y-m-d H:i:s');
                    $applicationTrackingHistory = new ApplicationTrackingHistory;
                    $applicationTrackingHistory->id_tracking_history = $trakingHistorysid;
                    $applicationTrackingHistory->id_application = $appId;
                    $applicationTrackingHistory->start_time = $datetime;
                    $applicationTrackingHistory->end_time = date('Y-m-d H:i:s',strtotime('+'.$duration.' second',strtotime($datetime)));
                    $applicationTrackingHistory->duration = $duration;
                    $applicationTrackingHistory->save();
                }
            }
            else {
            }
        }
      return $this->updateDailyTracking();
  }
  public function updateDailyTracking()
  {
      $todayDate = date('Y-m-d');
      $dailyTrackingReportCount = DailyTrackingReport::where('id_user',Auth::guard('api')->id())
                              ->whereDate('created_at',$todayDate)->count();
        if($dailyTrackingReportCount==0){
                $dailyTrackingReport = new DailyTrackingReport;
                $dailyTrackingReport->id_user = Auth::guard('api')->id();
                $dailyTrackingReport->productive_value = 0;
                $dailyTrackingReport->netral_value = 0;
                $dailyTrackingReport->not_productive_value = 0;
                $dailyTrackingReport->save();
        }
            $trakingHistorysCount = TrackingHistory::where('id_user',Auth::guard('api')->id())
                                    ->whereDate('created_at',$todayDate)->count();

            $trakingHistorysid = 0;
            $trakingHistory = new TrackingHistory;

            if($trakingHistorysCount==0){
                $trakingHistory->id_user = Auth::guard('api')->id();
                $trakingHistory->save();
                $trakingHistorysid = $trakingHistory->id;
            } else {
                $trakingHistorysid = TrackingHistory::where('id_user',Auth::guard('api')->id())
                                        ->whereDate('created_at',$todayDate)->first()->id;
            }
            $applicationTrackingHistory = ApplicationTrackingHistory::
                where('id_tracking_history',$trakingHistorysid)->get();


            $appArray= array();
            $totalTimeProductive=0;
            $totalTimeNetral=0;
            $totalTimeNotProductive=0;
            foreach ($applicationTrackingHistory as $key) {
                $app = Application::where('id',$key->id_application)->first();
                if($app->id_app_productivity_type==1){
                    $totalTimeProductive+=$key->duration;
                }else if($app->id_app_productivity_type==2){
                    $totalTimeNetral+=$key->duration;
                }else{
                    $totalTimeNotProductive+=$key->duration;
                }
            }
            $prod = ($totalTimeProductive/($totalTimeProductive+$totalTimeNetral+$totalTimeNotProductive))*100;
            $net = ($totalTimeNetral/($totalTimeProductive+$totalTimeNetral+$totalTimeNotProductive))*100;
            $nonprod = ($totalTimeNotProductive/($totalTimeProductive+$totalTimeNetral+$totalTimeNotProductive))*100;

            $dailyTrackingReport = DailyTrackingReport::where('id_user',Auth::guard('api')->id())
                                    ->whereDate('created_at',$todayDate)->first();
            $dailyTrackingReport->productive_value = $prod;
            $dailyTrackingReport->netral_value = $net;
            $dailyTrackingReport->not_productive_value = $nonprod;
            $dailyTrackingReport->save();

            return response()->json(['success'=>'true','message'=>'successfully updated daily traking report','data'=>$dailyTrackingReport],200);

  }
}
