<?php

namespace App\Http\Controllers;

use App\Libraries\AclHandler;
use App\Libraries\HandleApi;
use App\shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class pvtController extends Controller
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

    public function pvtList()
    {
        return view('pvt.pvt_list');
    }


    public function getList()
    {
        if (AclHandler::hasAccess('Product Var Type','full') == false){
            die('Not access . Recorded this '); exit();
        }

        $api_url = "https://xplaza-backend.herokuapp.com/api/prodvartype";
        $curlOutput  = HandleApi::getCURLOutput( $api_url, 'GET', [] );

        $decodedData = json_decode($curlOutput);
        $data = $decodedData->data;

        return Datatables::of(collect($data))
            ->addColumn('action', function ($data) {
                $action = '';
                if (AclHandler::hasAccess('Product Var Type','update') == true) {
                    $action = '<button type="button" class="btn btn-info btn-xs open_pvt_modal" data-pvt_id="' . $data->id . '" ><b><i class="fa fa-edit"></i> Edit</b></button> &nbsp;';
                }
                if (AclHandler::hasAccess('Product Var Type','delete') == true){
                    $action .= ' <button type="button" class="btn btn-danger btn-xs deletePVT" data-pvt_id="'.$data->id.'"><b><i class="fa fa-trash"></i> Delete</b></button>';
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
        if (AclHandler::hasAccess('Product Var Type','add') == false){
            return response()->json( ['responseCode'=>0,'message'=>'Not access . Recorded this']);
        }

        $rules = [
            'name'        => 'required',
            'description' => 'required'
        ];
        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required field']);
        }

        $name = $request->get('name');
        $description = $request->get('description');

        $bodyData = [
            "name"=>$name,
            "description"=>$description
        ];
        $fieldData = json_encode($bodyData);

        $api_url = "https://xplaza-backend.herokuapp.com/api/prodvartype/add";
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

    public function pvtInfo(Request $request)
    {
        $rules = [
            'pvt_id'        => 'required'
        ];
        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required field']);
        }

        $pvt_id = $request->get('pvt_id');

        $api_url = "https://xplaza-backend.herokuapp.com/api/prodvartype/".intval($pvt_id);
        $curlOutput  = HandleApi::getCURLOutput( $api_url, 'GET', [] );
        $json_resp = json_decode($curlOutput);
        $pvt_info = isset($json_resp->data) ? $json_resp->data : [];

        $public_html = strval(view("pvt.modal_data", compact('pvt_info')));

        return response()->json(['responseCode' => 1, 'html' => $public_html, 'shop_id'=>$pvt_id,'message'=>'Successfully fetches']);


    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function updatePVT(Request $request)
    {
        if (AclHandler::hasAccess('Product Var Type','update') == false){
            return response()->json( ['responseCode'=>0,'message'=>'Not access . Recorded this']);
        }

        $rules = [
            'pvt_id'     => 'required',
            'pvt_name' => 'required',
            'pvt_description'     => 'required'
        ];
        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required field']);
        }

        $pvt_id = $request->get('pvt_id');
        $pvt_name = $request->get('pvt_name');
        $pvt_description = $request->get('pvt_description');

        $bodyData = [
            "name"=>$pvt_name,
            "description"=>$pvt_description,
            "id"=>$pvt_id
        ];
        $fieldData = json_encode($bodyData);

        $api_url = "https://xplaza-backend.herokuapp.com/api/prodvartype/update";
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
    public function deletePVT(Request $request)
    {
        if (AclHandler::hasAccess('Product Var Type','delete') == false){
            return response()->json( ['responseCode'=>0,'message'=>'Not access . Recorded this']);
        }

        $rules = [
            'pvt_id'        => 'required'
        ];
        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required field']);
        }

        $api_url = "https://xplaza-backend.herokuapp.com/api/prodvartype/".intval($request->get('pvt_id'));
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
