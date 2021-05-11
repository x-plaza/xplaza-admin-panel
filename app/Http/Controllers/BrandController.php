<?php

namespace App\Http\Controllers;

use App\brand;
use App\Libraries\HandleApi;
use App\shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class BrandController extends Controller
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
        return view('brand.brand_list');
    }


    public function getList()
    {
        $api_url = "https://xplaza-backend.herokuapp.com/api/brand";
        $curlOutput  = HandleApi::getCURLOutput( $api_url, 'GET', [] );

        $decodedData = json_decode($curlOutput);
        $data = $decodedData->data;

        return Datatables::of(collect($data))
            ->addColumn('action', function ($data) {
                $action = '<button type="button" class="btn btn-info btn-xs open_brand_modal" data-brand_id="'.$data->id.'" ><b><i class="fa fa-edit"></i> Edit</b></button> &nbsp;';
                $action .= ' <button type="button" class="btn btn-danger btn-xs deleteBrand" data-brand_id="'.$data->id.'"><b><i class="fa fa-trash"></i> Delete</b></button>';

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

        $api_url = "https://xplaza-backend.herokuapp.com/api/brand/add";
        $curlOutput  = HandleApi::getCURLOutput( $api_url, 'POST', $fieldData );

        return response()->json( ['responseCode'=>1,'message'=>'Successfully added']);


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

        $bodyData = [
            "brand_id"=>$brand_id
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
    public function deleteBrand(Request $request)
    {
        $rules = [
            'brand_id'        => 'required'
        ];
        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required field']);
        }

        $api_url = "https://xplaza-backend.herokuapp.com/api/brand/".intval($request->get('brand_id'));
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
