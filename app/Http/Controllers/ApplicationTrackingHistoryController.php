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
  public function index()
  {
      return response()->json(['success'=>'true','data'=>ApplicationTrackingHistory::all()],200);
  }

  public function store(Request $request)
  {
      $validator = Validator::make($request->all(), [
          'id_tracking_history' => 'required',
          'id_application' => 'required',
          'start_time' => 'required',
          'end_time' => 'required',
          'duration' => 'required',
      ]);

      if ($validator->fails()) {
          return response()->json(['error'=>$validator->errors()], 401);
      }

      $applicationTrackingHistory = ApplicationTrackingHistory::create($request->all());

      return response()->json(['success'=>'true','data'=>$applicationTrackingHistory],201);
  }

  public function show(ApplicationTrackingHistory $applicationTrackingHistory)
  {
      return response()->json(['success'=>'true','data'=>$applicationTrackingHistory],200);
  }

  public function update(Request $request, ApplicationTrackingHistory $applicationTrackingHistory)
  {
      $validator = Validator::make($request->all(), [
          'id_tracking_history' => 'required',
          'id_application' => 'required',
          'start_time' => 'required',
          'end_time' => 'required',
          'duration' => 'required',
      ]);

      if ($validator->fails()) {
          return response()->json(['error'=>$validator->errors()], 200);
      }

      $applicationTrackingHistory->update($request->all());

      return response()->json(['success'=>'true','data'=>$applicationTrackingHistory],200);
  }

  public function delete(ApplicationTrackingHistory $applicationTrackingHistory)
  {
      $applicationTrackingHistory->delete();

      return response()->json(['success'=>'true','message'=>'successfully delete'],200);
  }
  public function acceptRespones(Request $request)
  {
        $dt = $request->data;
        $duration = 300;
        $todayDate = date('Y-m-d');
        $trakingHistorysCount = TrackingHistory::where('id_user',Auth::guard('api')->id())
                                ->whereDate('created_at',$todayDate)->count();
        // echo $trakingHistorysCount;

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
        // echo $trakingHistorysid;

        foreach ($dt as $key) {
            // echo "\n".$key['name'];
            $appCount = Application::where('application_file_name', 'like', '%' . $key['name'] . '%')->count();
            //ada app nya app enggak
            if($appCount > 0){
                // echo "ada ";
                $appId = Application::where('application_file_name', 'like', '%' . $key['name'] . '%')->first()->id;
                // echo "appID : ".$appId;

                $applicationTrackingHistoryCount = ApplicationTrackingHistory::
                    where('id_tracking_history',$trakingHistorysid)
                    ->where('id_application',$appId)->count();
                if($applicationTrackingHistoryCount>0){
                    // echo "\tuda ada";
                    $applicationTrackingHistory = ApplicationTrackingHistory::
                        where('id_tracking_history',$trakingHistorysid)
                        ->where('id_application',$appId)->first();
                    // echo "mengupdate durasi id: ";
                    // echo $applicationTrackingHistory->id;
                    $applicationTrackingHistory->duration = $applicationTrackingHistory->duration + $duration;
                    $applicationTrackingHistory->end_time =
                        date('Y-m-d H:i:s',strtotime('+'.$duration.' second',strtotime($applicationTrackingHistory->end_time)));
                    $applicationTrackingHistory->save();
                }
                else {
                    // echo "belm ada";
                    $datetime = date('Y-m-d H:i:s');
                    $applicationTrackingHistory = new ApplicationTrackingHistory;
                    $applicationTrackingHistory->id_tracking_history = $trakingHistorysid;
                    $applicationTrackingHistory->id_application = $appId;
                    $applicationTrackingHistory->start_time = $datetime;
                    $applicationTrackingHistory->end_time = date('Y-m-d H:i:s',strtotime('+'.$duration.' second',strtotime($datetime)));
                    $applicationTrackingHistory->duration = $duration;
                    $applicationTrackingHistory->save();
                    // echo "menambah app traking history 1";
                }
            }
            else {
                // echo "\tapp tidak ada";
            }
        }
      return $this->updateDailyTracking();
  }
  public function updateDailyTracking()
  {
      $todayDate = date('Y-m-d');
      // echo $todayDate;
      $dailyTrackingReportCount = DailyTrackingReport::where('id_user',Auth::guard('api')->id())
                              ->whereDate('created_at',$todayDate)->count();
      // echo $dailyTrackingReportCount;
        if($dailyTrackingReportCount==0){
                $dailyTrackingReport = new DailyTrackingReport;
                $dailyTrackingReport->id_user = Auth::guard('api')->id();
                $dailyTrackingReport->productive_value = 0;
                $dailyTrackingReport->netral_value = 0;
                $dailyTrackingReport->not_productive_value = 0;
                $dailyTrackingReport->save();
        }
        // if($dailyTrackingReportCount>0){
            $trakingHistorysCount = TrackingHistory::where('id_user',Auth::guard('api')->id())
                                    ->whereDate('created_at',$todayDate)->count();
            // echo $trakingHistorysCount;

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
            // echo '\n-----------'.$trakingHistorysid;
            $applicationTrackingHistory = ApplicationTrackingHistory::
                where('id_tracking_history',$trakingHistorysid)->get();


            $appArray= array();
            $totalTimeProductive=0;
            $totalTimeNetral=0;
            $totalTimeNotProductive=0;
            foreach ($applicationTrackingHistory as $key) {
                // echo 'id'.$key->id_application."role";
                $app = Application::where('id',$key->id_application)->first();
                // echo $app->id_app_productivity_type;
                // echo "duration".$key->duration;
                if($app->id_app_productivity_type==1){
                    // echo "prodtuctive";
                    $totalTimeProductive+=$key->duration;
                }else if($app->id_app_productivity_type==2){
                    // echo "netral";
                    $totalTimeNetral+=$key->duration;
                }else{
                    // echo "not productive";
                    $totalTimeNotProductive+=$key->duration;
                }
            }
            $prod = ($totalTimeProductive/($totalTimeProductive+$totalTimeNetral+$totalTimeNotProductive))*100;
            $net = ($totalTimeNetral/($totalTimeProductive+$totalTimeNetral+$totalTimeNotProductive))*100;
            $nonprod = ($totalTimeNotProductive/($totalTimeProductive+$totalTimeNetral+$totalTimeNotProductive))*100;

            // echo "---prod".$prod;
            // echo "---net".$net;
            // echo "---non".$nonprod;
            $dailyTrackingReport = DailyTrackingReport::where('id_user',Auth::guard('api')->id())
                                    ->whereDate('created_at',$todayDate)->first();
            $dailyTrackingReport->productive_value = $prod;
            $dailyTrackingReport->netral_value = $net;
            $dailyTrackingReport->not_productive_value = $nonprod;
            $dailyTrackingReport->save();

            return response()->json(['success'=>'true','message'=>'successfully updated daily traking report','data'=>$dailyTrackingReport],200);

        // }
        // else{
        // }
  }
}
