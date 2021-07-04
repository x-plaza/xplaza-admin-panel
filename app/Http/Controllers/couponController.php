<?php

namespace App\Http\Controllers;

use App\Libraries\AclHandler;
use App\Libraries\HandleApi;
use App\shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class couponController extends Controller
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

    public function couponList()
    {
        if (AclHandler::hasAccess('Coupon','full') == false){
            die('Not access . Recorded this '); exit();
        }

        $api_url_discount_type = env('API_BASE_URL')."/api/discount-type";
        $curlOutput_discount_type  = HandleApi::getCURLOutput( $api_url_discount_type, 'GET', [] );
        $json_resp_discount_type = json_decode($curlOutput_discount_type);
        $discount_type = isset($json_resp_discount_type->data) ? $json_resp_discount_type->data : [];

        $api_url_currency_id = env('API_BASE_URL')."/api/currency";
        $curlOutput_currency_id  = HandleApi::getCURLOutput( $api_url_currency_id, 'GET', [] );
        $json_resp_currency_id = json_decode($curlOutput_currency_id);
        $currency_id = isset($json_resp_currency_id->data) ? $json_resp_currency_id->data : [];

        return view('coupon.coupon_list',compact('discount_type','currency_id'));
    }


    public function getList()
    {
        $api_url = env('API_BASE_URL')."/api/coupon";
        $curlOutput  = HandleApi::getCURLOutput( $api_url, 'GET', [] );

        $decodedData = json_decode($curlOutput);
        $data = $decodedData->data;

        return Datatables::of(collect($data))
            ->addColumn('action', function ($data) {
                $action = '';
                if (AclHandler::hasAccess('Coupon','update') == true) {
                    $action = '<button type="button" class="btn btn-info btn-xs open_coupon_modal" data-coupon_id="' . $data->id . '" ><b><i class="fa fa-edit"></i> Edit</b></button> &nbsp;';
                }
                if (AclHandler::hasAccess('Coupon','delete') == true){
                    $action .= ' <button type="button" class="btn btn-danger btn-xs deleteCoupon" data-coupon_id="'.$data->id.'"><b><i class="fa fa-trash"></i> Delete</b></button>';
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
        if (AclHandler::hasAccess('Coupon','add') == false){
            return response()->json( ['responseCode'=>0,'message'=>'Not access . Recorded this']);
        }

        $rules = [
            'amount'        => 'required',
            'coupon_code'        => 'required',
            'currency'        => 'required',
            'discount_type'        => 'required',
            'start_date'        => 'required',
            'end_date'        => 'required',
            'is_active'        => 'required',
            'max_amount' => 'required'
        ];

        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required field']);
        }

        $bodyData = [
            "amount"=>$request->get('amount'),
            "coupon_code"=>$request->get('coupon_code'),
            "currency_id"=>$request->get('currency'),
            "discount_type_id"=>$request->get('discount_type'),
            "end_date"=>$request->get('end_date'),
            "is_active"=>$request->get('is_active'),
            "max_amount"=>$request->get('max_amount'),
            "start_date"=>$request->get('start_date'),
            "_active"=>true
        ];
        $fieldData = json_encode($bodyData);

        $api_url = env('API_BASE_URL')."/api/coupon/add";
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

    public function couponInfo(Request $request)
    {
        $rules = [
            'coupon_id'        => 'required'
        ];
        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required field']);
        }

        $coupon_id = $request->get('coupon_id');

        $api_url_discount_type = env('API_BASE_URL')."/api/discount-type";
        $curlOutput_discount_type  = HandleApi::getCURLOutput( $api_url_discount_type, 'GET', [] );
        $json_resp_discount_type = json_decode($curlOutput_discount_type);
        $discount_type = isset($json_resp_discount_type->data) ? $json_resp_discount_type->data : [];

        $api_url_currency_id = env('API_BASE_URL')."/api/currency";
        $curlOutput_currency_id  = HandleApi::getCURLOutput( $api_url_currency_id, 'GET', [] );
        $json_resp_currency_id = json_decode($curlOutput_currency_id);
        $currency_id = isset($json_resp_currency_id->data) ? $json_resp_currency_id->data : [];

        $api_url = env('API_BASE_URL')."/api/coupon/".intval($coupon_id);
        $curlOutput  = HandleApi::getCURLOutput( $api_url, 'GET', [] );
        $decodedData = json_decode($curlOutput);
        $coupon_data = isset($decodedData->data) ? $decodedData->data : [];

        $public_html = strval(view("coupon.modal_data", compact('discount_type','currency_id','coupon_data')));

        return response()->json(['responseCode' => 1, 'html' => $public_html, 'message'=>'Successfully fetches']);


    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function updateCoupon(Request $request)
    {
        if (AclHandler::hasAccess('Coupon','update') == false){
            return response()->json( ['responseCode'=>0,'message'=>'Not access . Recorded this']);
        }

        $rules = [
            'coupon_id'     => 'required',
            'amount'        => 'required',
            'coupon_code'        => 'required',
            'currency'        => 'required',
            'discount_type'        => 'required',
            'start_date'        => 'required',
            'end_date'        => 'required',
            'is_active'        => 'required',
            'max_amount' => 'required'
        ];
        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required field']);
        }

        $coupon_id = $request->get('coupon_id');

        $bodyData = [
            "amount"=>$request->get('amount'),
            "coupon_code"=>$request->get('coupon_code'),
            "currency_id"=>$request->get('currency'),
            "discount_type_id"=>$request->get('discount_type'),
            "end_date"=>$request->get('end_date'),
            "is_active"=>$request->get('is_active'),
            "max_amount"=>$request->get('max_amount'),
            "start_date"=>$request->get('start_date'),
            "_active"=>true,
            "id"=>$coupon_id
        ];
        $fieldData = json_encode($bodyData);

        $api_url = env('API_BASE_URL')."/api/coupon/update";
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
    public function deleteCoupon(Request $request)
    {
        if (AclHandler::hasAccess('Coupon','delete') == false){
            return response()->json( ['responseCode'=>0,'message'=>'Not access . Recorded this']);
        }

        $rules = [
            'coupon_id'        => 'required'
        ];
        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required field']);
        }

        $api_url = env('API_BASE_URL')."/api/coupon/".intval($request->get('coupon_id'));
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
