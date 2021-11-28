<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libraries\AclHandler;
use App\Libraries\HandleApi;
use App\shop;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class deliveryCostController extends Controller
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


    public function deliveryCostList()
    {
        if (AclHandler::hasAccess('Delivery Cost','full') == false){
            die('Not access . Recorded this '); exit();
        }

        $api_url_currency_id = env('API_BASE_URL','https://xplaza-backend.herokuapp.com')."/api/currency";
        $curlOutput_currency_id  = HandleApi::getCURLOutput( $api_url_currency_id, 'GET', [] );
        $json_resp_currency_id = json_decode($curlOutput_currency_id);
        $currency_id = isset($json_resp_currency_id->data) ? $json_resp_currency_id->data : [];

        return view('delivery_cost.delivery_cost_list',compact('currency_id'));
    }


    public function getList()
    {
        $api_url = env('API_BASE_URL','https://xplaza-backend.herokuapp.com')."/api/delivery-cost/";
        $curlOutput  = HandleApi::getCURLOutput( $api_url, 'GET', [] );

        $decodedData = json_decode($curlOutput);
        $data = $decodedData->data;

        return Datatables::of(collect($data))
            ->addColumn('action', function ($data) {
                $action = '';
                if (AclHandler::hasAccess('Delivery Cost','update') == true) {
                    $action = '<button type="button" class="btn btn-info btn-xs open_delivery_cost_modal" data-delivery_cost_id="' . $data->id . '" ><b><i class="fa fa-edit"></i> Edit</b></button> &nbsp;';
                }
                if (AclHandler::hasAccess('Delivery Cost','delete') == true){
                    $action .= ' <button type="button" class="btn btn-danger btn-xs deleteDeliveryCost" data-delivery_cost_id="'.$data->id.'"><b><i class="fa fa-trash"></i> Delete</b></button>';
                }
                return $action;
            })

            ->removeColumn('id')
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
        if (AclHandler::hasAccess('Delivery Cost','add') == false){
            return response()->json( ['responseCode'=>0,'message'=>'Not access . Recorded this']);
        }

        $rules = [
            'cost'        => 'required',
            'currency'        => 'required',
            'end_range'        => 'required',
            'start_range'        => 'required'
        ];

        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required field']);
        }

        $bodyData = [
            "cost"=>$request->get('cost'),
            "currency_id"=>$request->get('currency'),
            "end_range"=>$request->get('end_range'),
            "start_range"=>$request->get('start_range')
        ];
        $fieldData = json_encode($bodyData);

        $api_url = env('API_BASE_URL','https://xplaza-backend.herokuapp.com')."/api/delivery-cost/add";
        $curlOutput  = HandleApi::getCURLOutput( $api_url, 'POST', $fieldData );

        $decodedResp = json_decode($curlOutput);
        if($decodedResp->status == 201){
            return response()->json( ['responseCode'=>1,'message'=>'Successfully added']);
        }else{
            return response()->json( ['responseCode'=>0,'message'=>$decodedResp->message]);
        }
    }


    public function deliveryCostInfo(Request $request)
    {
        $rules = [
            'delivery_cost_id'        => 'required'
        ];
        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required field']);
        }

        $delivery_cost_id = $request->get('delivery_cost_id');

        $api_url_currency_id = env('API_BASE_URL','https://xplaza-backend.herokuapp.com')."/api/currency";
        $curlOutput_currency_id  = HandleApi::getCURLOutput( $api_url_currency_id, 'GET', [] );
        $json_resp_currency_id = json_decode($curlOutput_currency_id);
        $currency_id = isset($json_resp_currency_id->data) ? $json_resp_currency_id->data : [];

        $api_url = env('API_BASE_URL','https://xplaza-backend.herokuapp.com')."/api/delivery-cost/".intval($delivery_cost_id);
        $curlOutput  = HandleApi::getCURLOutput( $api_url, 'GET', [] );
        $decodedData = json_decode($curlOutput);
        $cost_data = isset($decodedData->data) ? $decodedData->data : [];

        $startRange = explode('-',$cost_data->delivery_slab_range)[0];
        $endRange = explode('-',$cost_data->delivery_slab_range)[1];
        $public_html = strval(view("delivery_cost.modal_data", compact('cost_data','currency_id','startRange','endRange')));

        return response()->json(['responseCode' => 1, 'html' => $public_html, 'message'=>'Successfully fetches']);


    }



    public function updateDeliveryCost(Request $request)
    {
        if (AclHandler::hasAccess('Delivery Cost','update') == false){
            return response()->json( ['responseCode'=>0,'message'=>'Not access . Recorded this']);
        }

        $rules = [
            'delivery_cost_id'     => 'required',
            'cost'        => 'required',
            'currency'        => 'required',
            'end_range'        => 'required',
            'start_range'        => 'required'
        ];
        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required field']);
        }


        $bodyData = [
            "start_range"=>$request->get('start_range'),
            "end_range"=>$request->get('end_range'),
            "currency_id"=>$request->get('currency'),
            "cost"=>$request->get('cost'),
            "id"=>$request->get('delivery_cost_id')
        ];

        $fieldData = json_encode($bodyData);

        $api_url = env('API_BASE_URL','https://xplaza-backend.herokuapp.com')."/api/delivery-cost/update";
        $curlOutput  = HandleApi::getCURLOutput( $api_url, 'PUT', $fieldData );

        $decodedResp = json_decode($curlOutput);
        if($decodedResp->status == 200){
            return response()->json( ['responseCode'=>1,'message'=>'Successfully updated']);
        }else{
            return response()->json( ['responseCode'=>0,'message'=>$decodedResp->message]);
        }

    }


    public function deleteDeliveryCost(Request $request)
    {
        if (AclHandler::hasAccess('Delivery Cost','delete') == false){
            return response()->json( ['responseCode'=>0,'message'=>'Not access . Recorded this']);
        }

        $rules = [
            'delivery_cost_id'   => 'required'
        ];
        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required field']);
        }

        $api_url = env('API_BASE_URL','https://xplaza-backend.herokuapp.com')."/api/delivery-cost/".intval($request->get('delivery_cost_id'));
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
