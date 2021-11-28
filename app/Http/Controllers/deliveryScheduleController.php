<?php

namespace App\Http\Controllers;

use App\Libraries\AclHandler;
use App\Libraries\HandleApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class deliveryScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function deliveryScheduleList()
    {
        if (AclHandler::hasAccess('Delivery Schedule','full') == false){
            die('Not access . Recorded this '); exit();
        }

        $api_url_currency_id = env('API_BASE_URL','https://xplaza-backend.herokuapp.com')."/api/day_names";
        $curlOutput_day_id  = HandleApi::getCURLOutput( $api_url_currency_id, 'GET', [] );
        $json_resp_day = json_decode($curlOutput_day_id);
        $day_id = isset($json_resp_day->data) ? $json_resp_day->data : [];

        $start= "00:00";
        $end = "24:00";
        $int = 30;


        $int *= 60;
        $start = strtotime($start);
        $end = strtotime($end);

        for($i = $start; $i < $end;){
            $res[] = date("H:i", $i);
            $i += $int;
        }

        return view('delivery_schedule.delivery_schedule_list',compact('day_id','res'));
    }


    public function getList()
    {
        $api_url = env('API_BASE_URL','https://xplaza-backend.herokuapp.com')."/api/delivery-schedules/";
        $curlOutput  = HandleApi::getCURLOutput( $api_url, 'GET', [] );

        $decodedData = json_decode($curlOutput);
        $data = $decodedData->data;
        $fullData = [];
        $subData = [];
        foreach ($data as $value){
            foreach ($value->delivery_schedules as $schedule){
                $subData['day_name'] = $value->day_name;
                $subData['day_id'] = $value->day_id;
                $subData['delivery_schedule_id'] = $schedule->delivery_schedule_id;
                $subData['delivery_schedule_start'] = $schedule->delivery_schedule_start;
                $subData['delivery_schedule_end'] = $schedule->delivery_schedule_end;
                $fullData[] = $subData;
            }
        }

        return Datatables::of(collect($fullData))
            ->addColumn('action', function ($fullData) {
                $action = '';
                if (AclHandler::hasAccess('Delivery Schedule','update') == true) {
                    $action = '<button type="button" class="btn btn-info btn-xs open_delivery_schedule_modal" data-delivery_schedule_id="' . $fullData['delivery_schedule_id'] . '" ><b><i class="fa fa-edit"></i> Edit</b></button> &nbsp;';
                }
                if (AclHandler::hasAccess('Delivery Schedule','delete') == true){
                    $action .= ' <button type="button" class="btn btn-danger btn-xs deleteDeliverySchedule" data-delivery_schedule_id="'.$fullData['delivery_schedule_id'].'"><b><i class="fa fa-trash"></i> Delete</b></button>';
                }
                return $action;
            })

          //  ->removeColumn('id')
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (AclHandler::hasAccess('Delivery Schedule','add') == false){
            return response()->json( ['responseCode'=>0,'message'=>'Not access . Recorded this']);
        }

        $rules = [
            'day'        => 'required',
            'st_time'        => 'required',
            'end_time'        => 'required'
        ];

        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required field']);
        }

        $bodyData = [
            "day_id"=>$request->get('day'),
            "delivery_schedule_start"=>$request->get('st_time'),
            "delivery_schedule_end"=>$request->get('end_time')
        ];
        $fieldData = json_encode($bodyData);

        $api_url = env('API_BASE_URL','https://xplaza-backend.herokuapp.com')."/api/delivery-schedules/add";
        $curlOutput  = HandleApi::getCURLOutput( $api_url, 'POST', $fieldData );

        $decodedResp = json_decode($curlOutput);

        if($decodedResp->status == 201){
            return response()->json( ['responseCode'=>1,'message'=>'Successfully added']);
        }else{
            return response()->json( ['responseCode'=>0,'message'=>$decodedResp->message]);
        }
    }


    public function deliveryScheduleInfo(Request $request)
    {
        $rules = [
            'delivery_schedule_id'        => 'required'
        ];
        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required field']);
        }

        $delivery_schedule_id = $request->get('delivery_schedule_id');

        $api_url_currency_id = env('API_BASE_URL','https://xplaza-backend.herokuapp.com')."/api/day_names";
        $curlOutput_day_id  = HandleApi::getCURLOutput( $api_url_currency_id, 'GET', [] );
        $json_resp_day = json_decode($curlOutput_day_id);
        $day_id = isset($json_resp_day->data) ? $json_resp_day->data : [];

        $start= "00:00";
        $end = "24:00";
        $int = 30;


        $int *= 60;
        $start = strtotime($start);
        $end = strtotime($end);

        for($i = $start; $i < $end;){
            $res[] = date("H:i", $i);
            $i += $int;
        }

        $api_url = env('API_BASE_URL','https://xplaza-backend.herokuapp.com')."/api/delivery-schedules/".intval($delivery_schedule_id);
        $curlOutput  = HandleApi::getCURLOutput( $api_url, 'GET', [] );
        $decodedData = json_decode($curlOutput);
        $schedule_data = isset($decodedData->data) ? $decodedData->data : [];

     //   $startRange = explode('-',$cost_data->delivery_slab_range)[0];
      //  $endRange = explode('-',$cost_data->delivery_slab_range)[1];
        $public_html = strval(view("delivery_schedule.modal_data", compact('schedule_data','day_id','res')));

        return response()->json(['responseCode' => 1, 'html' => $public_html, 'message'=>'Successfully fetches']);


    }



    public function updateDeliverySchedule(Request $request)
    {
        if (AclHandler::hasAccess('Delivery Cost','update') == false){
            return response()->json( ['responseCode'=>0,'message'=>'Not access . Recorded this']);
        }

        $rules = [
            'day'        => 'required',
            'st_time'    => 'required',
            'end_time'   => 'required'
        ];

        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required field']);
        }

        $bodyData = [
            "delivery_schedule_id"=>$request->get('delivery_schedule_id'),
            "day_id"=>$request->get('day'),
            "delivery_schedule_start"=>$request->get('st_time'),
            "delivery_schedule_end"=>$request->get('end_time')
        ];
        $fieldData = json_encode($bodyData);

        $api_url = env('API_BASE_URL','https://xplaza-backend.herokuapp.com')."/api/delivery-schedules/update";
        $curlOutput  = HandleApi::getCURLOutput( $api_url, 'PUT', $fieldData );

        $decodedResp = json_decode($curlOutput);
        if($decodedResp->status == 200){
            return response()->json( ['responseCode'=>1,'message'=>'Successfully updated']);
        }else{
            return response()->json( ['responseCode'=>0,'message'=>$decodedResp->message]);
        }

    }


    public function deleteDeliverySchedule(Request $request)
    {
        if (AclHandler::hasAccess('Delivery Schedule','delete') == false){
            return response()->json( ['responseCode'=>0,'message'=>'Not access . Recorded this']);
        }

        $rules = [
            'delivery_schedule_id'   => 'required'
        ];
        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required field']);
        }

        $api_url = env('API_BASE_URL','https://xplaza-backend.herokuapp.com')."/api/delivery-schedules/".intval($request->get('delivery_schedule_id'));
        $curlOutput  = HandleApi::getCURLOutput( $api_url, 'DELETE', [] );

        $decodedData = json_decode($curlOutput);

        if($decodedData->status == 200){
            return response()->json( ['responseCode'=>1,'message'=>'Successfully updated']);
        }else{
            return response()->json( ['responseCode'=>0,'message'=>$decodedData->message]);
        }

    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
