<?php

namespace App\Http\Controllers;

use App\Libraries\AclHandler;
use App\Libraries\HandleApi;
use App\shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Session;

class ShopController extends Controller
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


    public function shopList()
    {
        if (AclHandler::hasAccess('Shop','full') == false){
            die('Not access . Recorded this '); exit();
        }

        $api_url = env('API_BASE_URL')."/api/location";
        $curlOutput  = HandleApi::getCURLOutput( $api_url, 'GET', [] );
        $json_resp = json_decode($curlOutput);

        $locations = isset($json_resp->data) ? $json_resp->data : [];
        return view('shop.shop_list',compact('locations'));
    }


    public function getList()
    {
        $api_url = env('API_BASE_URL')."/api/shop?user_id=".Session::get('userId');

        $curlOutput  = HandleApi::getCURLOutput( $api_url, 'GET', [] );

        $decodedData = json_decode($curlOutput);
        $data = $decodedData->data;

        return Datatables::of(collect($data))
            ->addColumn('action', function ($data) {
                $action = '';
                if (AclHandler::hasAccess('Shop','update') == true){
                    $action = '<button type="button" class="btn btn-info btn-xs open_shop_modal" data-shop_id="'.$data->id.'" ><b><i class="fa fa-edit"></i> Edit</b></button> &nbsp;';
                }
                if (AclHandler::hasAccess('Shop','delete') == true) {
                    $action .= ' <button type="button" class="btn btn-danger btn-xs deleteShop" data-shop_id="' . $data->id . '"><b><i class="fa fa-trash"></i> Delete</b></button>';
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
        if (AclHandler::hasAccess('Shop','add') == false){
            return response()->json( ['responseCode'=>0,'message'=>'Not access . Recorded this']);
        }

        $rules = [
            'shop_name'        => 'required',
            'owner'            => 'required',
            'shop_address'     => 'required',
            'location_id'      => 'required'
        ];
        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required field']);
        }

        $shop_name = $request->get('shop_name');
        $shop_owner = $request->get('owner');
        $shop_address = $request->get('shop_address');
        $location_id = $request->get('location_id');

        $bodyData = [
            "name"=>$shop_name,
            "owner"=>$shop_owner,
            "address"=>$shop_address,
            "location_id"=>$location_id
        ];
        $fieldData = json_encode($bodyData);

        $api_url = env('API_BASE_URL')."/api/shop/add";
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

    public function shopInfo(Request $request)
    {
        $rules = [
            'shop_id'        => 'required'
        ];
        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required field']);
        }

        $shop_id = $request->get('shop_id');

        $api_url = env('API_BASE_URL')."/api/location";
        $curlOutput  = HandleApi::getCURLOutput( $api_url, 'GET', [] );
        $json_resp = json_decode($curlOutput);
        $locations = isset($json_resp->data) ? $json_resp->data : [];

        $api_url = env('API_BASE_URL')."/api/shop/".intval($shop_id);
        $curlOutput  = HandleApi::getCURLOutput( $api_url, 'GET', [] );
        $decodedData = json_decode($curlOutput);
        $shop_data = isset($decodedData->data) ? $decodedData->data : [];

        $public_html = strval(view("shop.modal_data", compact('shop_data','locations')));

        return response()->json(['responseCode' => 1, 'html' => $public_html, 'shop_id'=>$shop_id,'message'=>'Successfully fetches']);


    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function updateShop(Request $request)
    {
        if (AclHandler::hasAccess('Shop','update') == false){
            return response()->json( ['responseCode'=>0,'message'=>'Not access . Recorded this']);
        }

        $rules = [
            'edit_shop_id'     => 'required',
            'edit_location_id' => 'required',
            'edit_shop_name'     => 'required',
            'edit_owner'      => 'required',
            'edit_shop_address'      => 'required'
        ];
        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required field']);
        }

        $shop_id = $request->get('edit_shop_id');
        $shop_name = $request->get('edit_shop_name');
        $shop_owner = $request->get('edit_owner');
        $shop_address = $request->get('edit_shop_address');
        $location_id = $request->get('edit_location_id');

        $bodyData = [
            "name"=>$shop_name,
            "owner"=>$shop_owner,
            "id"=>$shop_id,
            "address"=>$shop_address,
            "location_id"=>$location_id
        ];
        $fieldData = json_encode($bodyData);

        $api_url = env('API_BASE_URL')."/api/shop/update";
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
    public function deleteShop(Request $request)
    {
        if (AclHandler::hasAccess('Shop','delete') == false){
            return response()->json( ['responseCode'=>0,'message'=>'Not access . Recorded this']);
        }

        $rules = [
            'shop_id'        => 'required'
        ];
        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required field']);
        }

        $api_url = env('API_BASE_URL')."/api/shop/".intval($request->get('shop_id'));
        $curlOutput  = HandleApi::getCURLOutput( $api_url, 'DELETE', [] );

        $decodedData = json_decode($curlOutput);

        return response()->json( ['responseCode'=>1,'message'=>'Successfully Deleted']);


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
