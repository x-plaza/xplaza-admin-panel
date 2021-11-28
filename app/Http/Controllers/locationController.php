<?php

namespace App\Http\Controllers;

use App\Libraries\AclHandler;
use App\Libraries\HandleApi;
use App\shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class locationController extends Controller
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

    public function locationList()
    {
        if (AclHandler::hasAccess('Location','full') == false){
            die('Not access . Recorded this '); exit();
        }

        $api_url = env('API_BASE_URL','https://xplaza-backend.herokuapp.com')."/api/city";
        $curlOutput  = HandleApi::getCURLOutput( $api_url, 'GET', [] );
        $json_resp = json_decode($curlOutput);

        $cities = isset($json_resp->data) ? $json_resp->data : [];
        return view('location.location_list',compact('cities'));
    }


    public function getList()
    {
        $api_url = env('API_BASE_URL','https://xplaza-backend.herokuapp.com')."/api/location";
        $curlOutput  = HandleApi::getCURLOutput( $api_url, 'GET', [] );

        $decodedData = json_decode($curlOutput);
        $data = $decodedData->data;

        return Datatables::of(collect($data))
            ->addColumn('action', function ($data) {
                $action = '';
                if (AclHandler::hasAccess('Location','update') == true) {
                    $action = '<button type="button" class="btn btn-info btn-xs open_location_modal" data-location_id="' . $data->id . '" ><b><i class="fa fa-edit"></i> Edit</b></button> &nbsp;';
                }
                if (AclHandler::hasAccess('Location','delete') == true){
                    $action .= ' <button type="button" class="btn btn-danger btn-xs deleteLocation" data-location_id="'.$data->id.'"><b><i class="fa fa-trash"></i> Delete</b></button>';
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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if (AclHandler::hasAccess('Location','add') == false){
            return response()->json( ['responseCode'=>0,'message'=>'Not access . Recorded this']);
        }

        $rules = [
            'city_id'        => 'required',
            'location_name' => 'required'
        ];

        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required field']);
        }

        $city_id = $request->get('city_id');
        $location_name = $request->get('location_name');

        $bodyData = [
            "name"=>$location_name,
            "city_id"=>$city_id
        ];
        $fieldData = json_encode($bodyData);

        $api_url = env('API_BASE_URL')."/api/location/add";
        $curlOutput  = HandleApi::getCURLOutput( $api_url, 'POST', $fieldData );

        $decodedResp = json_decode($curlOutput);
        if($decodedResp->status == 201){
            return response()->json( ['responseCode'=>1,'message'=>'Successfully added']);
        }else{
            return response()->json( ['responseCode'=>0,'message'=>$decodedResp->message]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function locationInfo(Request $request)
    {
        $rules = [
            'location_id'        => 'required'
        ];
        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required field']);
        }

        $location_id = $request->get('location_id');

        $api_url = env('API_BASE_URL')."/api/city";
        $curlOutput  = HandleApi::getCURLOutput( $api_url, 'GET', [] );
        $json_resp = json_decode($curlOutput);
        $cities = isset($json_resp->data) ? $json_resp->data : [];

        $api_url = env('API_BASE_URL')."/api/location/".intval($location_id);
        $curlOutput  = HandleApi::getCURLOutput( $api_url, 'GET', [] );
        $decodedData = json_decode($curlOutput);
        $location_data = isset($decodedData->data) ? $decodedData->data : [];

        $public_html = strval(view("location.modal_data", compact('location_data','cities')));

        return response()->json(['responseCode' => 1, 'html' => $public_html, 'message'=>'Successfully fetches']);


    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function updateLocation(Request $request)
    {
        if (AclHandler::hasAccess('Location','update') == false){
            return response()->json( ['responseCode'=>0,'message'=>'Not access . Recorded this']);
        }

        $rules = [
            'location_id'     => 'required',
            'city_id' => 'required',
            'location_name'     => 'required'
        ];
        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required field']);
        }

        $location_id = $request->get('location_id');
        $city_id = $request->get('city_id');
        $location_name = $request->get('location_name');

        $bodyData = [
            "name"=>$location_name,
            "city_id"=>$city_id,
            "id"=>$location_id
        ];
        $fieldData = json_encode($bodyData);

        $api_url = env('API_BASE_URL')."/api/location/update";
        $curlOutput  = HandleApi::getCURLOutput( $api_url, 'PUT', $fieldData );

        $decodedResp = json_decode($curlOutput);
        if($decodedResp->status == 200){
            return response()->json( ['responseCode'=>1,'message'=>'Successfully updated']);
        }else{
            return response()->json( ['responseCode'=>0,'message'=>$decodedResp->message]);
        }

    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteLocation(Request $request)
    {
        if (AclHandler::hasAccess('Location','delete') == false){
            return response()->json( ['responseCode'=>0,'message'=>'Not access . Recorded this']);
        }

        $rules = [
            'location_id'        => 'required'
        ];
        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required field']);
        }

        $api_url = env('API_BASE_URL')."/api/location/".intval($request->get('location_id'));
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
     * @param  \App\shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function show(shop $shop)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function edit(shop $shop)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, shop $shop)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function destroy(shop $shop)
    {
        //
    }
}
