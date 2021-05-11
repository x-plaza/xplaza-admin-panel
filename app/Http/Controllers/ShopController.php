<?php

namespace App\Http\Controllers;

use App\Libraries\HandleApi;
use App\shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

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
        $api_url = "https://xplaza-backend.herokuapp.com/api/location";
        $curlOutput  = HandleApi::getCURLOutput( $api_url, 'GET', [] );
        $json_resp = json_decode($curlOutput);

        $locations = isset($json_resp->data) ? $json_resp->data : [];
        return view('shop.shop_list',compact('locations'));
    }


    public function getList()
    {
        $api_url = "https://xplaza-backend.herokuapp.com/api/shop";
        $curlOutput  = HandleApi::getCURLOutput( $api_url, 'GET', [] );

        $decodedData = json_decode($curlOutput);
        $data = $decodedData->data;

        return Datatables::of(collect($data))
            ->addColumn('action', function ($data) {
                $action = '<button type="button" class="btn btn-info btn-xs open_shop_modal" data-shop_id="'.$data->id.'" ><b><i class="fa fa-edit"></i> Edit</b></button> &nbsp;';
                $action .= ' <button type="button" class="btn btn-danger btn-xs deleteShop" data-shop_id="'.$data->id.'"><b><i class="fa fa-trash"></i> Delete</b></button>';

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
        $rules = [
            'shop_name'        => 'required',
            'shop_description' => 'required',
            'shop_address'     => 'required',
            'location_id'      => 'required'
        ];
        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required field']);
        }

        $shop_name = $request->get('shop_name');
        $shop_description = $request->get('shop_description');
        $shop_address = $request->get('shop_address');
        $location_id = $request->get('location_id');

        $bodyData = [
            "name"=>$shop_name,
            "description"=>$shop_description,
            "address"=>$shop_address,
            "location_id"=>$location_id
        ];
        $fieldData = json_encode($bodyData);

        $api_url = "https://xplaza-backend.herokuapp.com/api/shop/add";
        $curlOutput  = HandleApi::getCURLOutput( $api_url, 'POST', $fieldData );

        return response()->json( ['responseCode'=>1,'message'=>'Successfully added']);


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

        $bodyData = [
            "shop_id"=>$shop_id
        ];
        $fieldData = json_encode($bodyData);

        $api_url = "https://xplaza-backend.herokuapp.com/api/shop/add";
      //  $curlOutput  = HandleApi::getCURLOutput( $api_url, 'POST', $fieldData );

        return response()->json( ['responseCode'=>1,'message'=>'Successfully fetches']);


    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteShop(Request $request)
    {
        $rules = [
            'shop_id'        => 'required'
        ];
        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required field']);
        }

        $api_url = "https://xplaza-backend.herokuapp.com/api/shop/".intval($request->get('shop_id'));
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
