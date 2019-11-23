<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ApplicationTrackingHistory;
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
        echo $trakingHistorysid;

        foreach ($dt as $key) {
            echo "\n".$key['name'];
            $appCount = Application::where('application_file_name', 'like', '%' . $key['name'] . '%')->count();
            //ada app nya app enggak
            if($appCount > 0){
                echo "ada ";
                $appId = Application::where('application_file_name', 'like', '%' . $key['name'] . '%')->first()->id;
                echo "appID : ".$appId;

                $applicationTrackingHistoryCount = ApplicationTrackingHistory::
                    where('id_tracking_history',$trakingHistorysid)
                    ->where('id_application',$appId)->count();
                if($applicationTrackingHistoryCount>0){
                    echo "\tuda ada";
                    $applicationTrackingHistory = ApplicationTrackingHistory::
                        where('id_tracking_history',$trakingHistorysid)
                        ->where('id_application',$appId)->first();
                    echo "mengupdate durasi id: ";
                    echo $applicationTrackingHistory->id;
                    $applicationTrackingHistory->duration = $applicationTrackingHistory->duration + $duration;
                    $applicationTrackingHistory->end_time =
                        date('Y-m-d H:i:s',strtotime('+'.$duration.' second',strtotime($applicationTrackingHistory->end_time)));
                    $applicationTrackingHistory->save();
                }
                else {
                    echo "belm ada";
                    $datetime = date('Y-m-d H:i:s');
                    $applicationTrackingHistory = new ApplicationTrackingHistory;
                    $applicationTrackingHistory->id_tracking_history = $trakingHistorysid;
                    $applicationTrackingHistory->id_application = $appId;
                    $applicationTrackingHistory->start_time = $datetime;
                    $applicationTrackingHistory->end_time = date('Y-m-d H:i:s',strtotime('+'.$duration.' second',strtotime($datetime)));
                    $applicationTrackingHistory->duration = $duration;
                    $applicationTrackingHistory->save();
                    echo "menambah app traking history 1";
                }
            }
            else {
                echo "\tapp tidak ada";
            }
        }

      //   foreach ($dt as $key) {
      //       echo count($dt);
      //       echo "\n".$key['name'];
      //       $appCount = Application::where('application_file_name', 'like', '%' . $key['name'] . '%')->count();
      //       //ada app nya app enggak
      //       if($appCount > 0){
      //           // echo "ada ";
      //           $appId = Application::where('application_file_name', 'like', '%' . $key['name'] . '%')->first();
      //           // echo "appID : ".$appId['id'];
      //           $idUser = Auth::guard('api')->id();
      //           $todayDate = date('Y-m-d');
      //           $trakingHistorysCount = TrackingHistory::where('id_user',$idUser)
      //                            ->whereDate('created_at',$todayDate)->count();
      //           //ada data track hari ini apa enggak
      //           if($trakingHistorysCount>0){
      //               $trakingHistorys = TrackingHistory::where('id_user',$idUser)
      //                                 ->whereDate('created_at',$todayDate)->get();
      //                //echo $trakingHistoryIds[0]['id'];
      //                   $i=0;
      //                   for ($i = 0; $i < count($dt); $i++ ) {
      //                       //echo "wher app id".$appId."dan id traking histoy".$trakingHistoryId['id'];
      //                       $applicationTrackingHistoryCount =
      //                       ApplicationTrackingHistory::where('id_application',$appId['id'])
      //                         ->where('id_tracking_history',$trakingHistorys[$i]['id'])->count();
      //
      //                       if($applicationTrackingHistoryCount>0){
      //                           // echo "TrackingHistoryID : ".$trakingHistoryId['id'];
      //                           $applicationTrackingHistory =
      //                           ApplicationTrackingHistory::where('id_application',$appId['id'])
      //                                       ->where('id_tracking_history',$trakingHistorys[$i]['id'])->first();
      //                           //echo "ApplicationTrackingHistoryID : ".$applicationTrackingHistory['id']."---\n";
      //                           $trakingHistorys[$i]->duration = $trakingHistory->duration+$duration;
      //                           $trakingHistorys[$i]->save();
      //                           echo "menambah durasi".$trakingHistorys[$i]['id'];
      //                           // break;
      //                       }
      //                       else{
      //                           $trakingHistory = new TrackingHistory;
      //                           $trakingHistory->id_user = Auth::guard('api')->id();
      //                           $trakingHistory->start_time = "2019-11-13 00:00:00";
      //                           $trakingHistory->end_time = "2019-11-13 00:00:00";
      //                           $trakingHistory->duration = $duration;
      //                           $trakingHistory->save();
      //
      //                           $applicationTrackingHistory = new ApplicationTrackingHistory;
      //                           $applicationTrackingHistory->id_tracking_history = $trakingHistory->id;
      //                           // $trakingHistory->id_tracking_history = 3;
      //                           $applicationTrackingHistory->id_application =
      //                           Application::where('application_file_name', 'like', '%' . $key['name'] . '%')->get('id')->first()->id;
      //                           $applicationTrackingHistory->save();
      //                           echo "menambah record traking history baru";
      //                           // break;
      //                       }
      //                   }
      //
      //           }
      //           else{
      //               $trakingHistory = new TrackingHistory;
      //               $trakingHistory->id_user = Auth::guard('api')->id();
      //               $trakingHistory->save();
      //
      //               $applicationTrackingHistory = new ApplicationTrackingHistory;
      //               $applicationTrackingHistory->id_tracking_history = $trakingHistory->id;
      //               $applicationTrackingHistory->id_application =
      //               Application::where('application_file_name', 'like', '%' . $key['name'] . '%')->get('id')->first()->id;
      //               $applicationTrackingHistory->start_time = "2019-11-13 00:00:00";
      //               $applicationTrackingHistory->end_time = "2019-11-13 00:00:00";
      //               $applicationTrackingHistory->duration = $duration;
      //               $applicationTrackingHistory->save();
      //               echo "menambah record traking history";
      //           }
      //      }
      //      else {
      //          echo "gak ada";
      //      }
      // }
  }
}
