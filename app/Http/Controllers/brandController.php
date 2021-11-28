<?php

namespace App\Http\Controllers;

use App\brand;
use App\Libraries\AclHandler;
use App\Libraries\HandleApi;
use App\shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class brandController extends Controller
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


    public function brandList()
    {
        if (AclHandler::hasAccess('Brand','full') == false){
            die('Not access . Recorded this '); exit();
        }

        return view('brand.brand_list');
    }


    public function getList()
    {
        $api_url = env('API_BASE_URL','https://xplaza-backend.herokuapp.com')."/api/brand";
        $curlOutput  = HandleApi::getCURLOutput( $api_url, 'GET', [] );

        $decodedData = json_decode($curlOutput);
        $data = $decodedData->data;

        return Datatables::of(collect($data))
            ->addColumn('action', function ($data) {
                $action = '';
                if (AclHandler::hasAccess('Brand','update') == true) {
                    $action = '<button type="button" class="btn btn-info btn-xs open_brand_modal" data-brand_id="' . $data->id . '" ><b><i class="fa fa-edit"></i> Edit</b></button> &nbsp;';
                }
                if (AclHandler::hasAccess('Brand','delete') == true) {
                    $action .= ' <button type="button" class="btn btn-danger btn-xs deleteBrand" data-brand_id="' . $data->id . '"><b><i class="fa fa-trash"></i> Delete</b></button>';
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
        if (AclHandler::hasAccess('Brand','add') == false){
            return response()->json( ['responseCode'=>0,'message'=>'Not access . Recorded this']);
        }

        $rules = [
            'brand_name'  => 'required',
            'description' => 'required'
        ];
        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required field']);
        }

        $brand_name = $request->get('brand_name');
        $description = $request->get('description');

        $bodyData = [
            "name"=>$brand_name,
            "description"=>$description
        ];
        $fieldData = json_encode($bodyData);

        $api_url = env('API_BASE_URL','https://xplaza-backend.herokuapp.com')."/api/brand/add";
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
    public function updateBrand(Request $request)
    {
        if (AclHandler::hasAccess('Brand','update') == false){
            return response()->json( ['responseCode'=>0,'message'=>'Not access . Recorded this']);
        }

        $rules = [
            'brand_id'  => 'required',
            'brand_name'  => 'required',
            'description' => 'required'
        ];
        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required field']);
        }

        $brand_id = $request->get('brand_id');
        $brand_name = $request->get('brand_name');
        $description = $request->get('description');

        $bodyData = [
            "name"=>$brand_name,
            "id"=>$brand_id,
            "description"=>$description
        ];
        $fieldData = json_encode($bodyData);

        $api_url = env('API_BASE_URL','https://xplaza-backend.herokuapp.com')."/api/brand/update";
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

    public function brandInfo(Request $request)
    {
        $rules = [
            'brand_id'        => 'required'
        ];
        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required field']);
        }

        $brand_id = $request->get('brand_id');

        $api_url = env('API_BASE_URL','https://xplaza-backend.herokuapp.com')."/api/brand/".intval($brand_id);
        $curlOutput  = HandleApi::getCURLOutput( $api_url, 'GET', [] );
        $decodedData = json_decode($curlOutput);
        $brand_data = isset($decodedData->data) ? $decodedData->data : [];

        $public_html = strval(view("brand.modal_data", compact('brand_data')));

        return response()->json(['responseCode' => 1, 'html' => $public_html, 'message'=>'Successfully fetches']);



    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteBrand(Request $request)
    {
        if (AclHandler::hasAccess('Brand','delete') == false){
            return response()->json( ['responseCode'=>0,'message'=>'Not access . Recorded this']);
        }

        $rules = [
            'brand_id'        => 'required'
        ];
        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required field']);
        }

        $api_url = env('API_BASE_URL','https://xplaza-backend.herokuapp.com')."/api/brand/".intval($request->get('brand_id'));
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
