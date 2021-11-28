<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libraries\AclHandler;
use App\Libraries\HandleApi;
use App\shop;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class productDiscountController extends Controller
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

    public function productDiscountList()
    {
        if (AclHandler::hasAccess('Product Discount','full') == false){
            die('Not access . Recorded this '); exit();
        }

        $api_url_discount_type = env('API_BASE_URL','https://xplaza-backend.herokuapp.com')."/api/discount-type";
        $curlOutput_discount_type  = HandleApi::getCURLOutput( $api_url_discount_type, 'GET', [] );
        $json_resp_discount_type = json_decode($curlOutput_discount_type);
        $discount_type = isset($json_resp_discount_type->data) ? $json_resp_discount_type->data : [];

        $api_url_currency_id = env('API_BASE_URL','https://xplaza-backend.herokuapp.com')."/api/currency";
        $curlOutput_currency_id  = HandleApi::getCURLOutput( $api_url_currency_id, 'GET', [] );
        $json_resp_currency_id = json_decode($curlOutput_currency_id);
        $currency_id = isset($json_resp_currency_id->data) ? $json_resp_currency_id->data : [];

        $api_url = env('API_BASE_URL')."/api/product?user_id=".Session::get('userId');;
        $curlOutput  = HandleApi::getCURLOutput( $api_url, 'GET', [] );
        $decodedData = json_decode($curlOutput);
        $productData = isset($decodedData->data) ? $decodedData->data : [];

        $shops = Session::get('shopList');

        return view('product_discount.product_discount_list',compact('discount_type','currency_id','shops','productData'));
    }


    public function getList()
    {
        $api_url = env('API_BASE_URL','https://xplaza-backend.herokuapp.com')."/api/product-discount?user_id=".Session::get('userId');
        $curlOutput  = HandleApi::getCURLOutput( $api_url, 'GET', [] );

        $decodedData = json_decode($curlOutput);
        $data = $decodedData->data;

        return Datatables::of(collect($data))
            ->addColumn('action', function ($data) {
                $action = '';
                if (AclHandler::hasAccess('Product Discount','update') == true) {
                    $action = '<button type="button" class="btn btn-info btn-xs open_discount_modal" data-product_discount_id="' . $data->id . '" ><b><i class="fa fa-edit"></i> Edit</b></button> &nbsp;';
                }
                if (AclHandler::hasAccess('Product Discount','delete') == true){
                    $action .= ' <button type="button" class="btn btn-danger btn-xs deleteDiscount" data-product_discount_id="'.$data->id.'"><b><i class="fa fa-trash"></i> Delete</b></button>';
                }
                return $action;
            })
//            ->editColumn('start_date', function ($data) {
//                return date('d-m-Y',$data->start_date);
//            })
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
        if (AclHandler::hasAccess('Product Discount','add') == false){
            return response()->json( ['responseCode'=>0,'message'=>'Not access . Recorded this']);
        }

        $rules = [
            'discount_amount'        => 'required',
            'currency'        => 'required',
            'discount_type'        => 'required',
            'start_date'        => 'required',
            'end_date'        => 'required',
            'product'        => 'required'
        ];

        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required field']);
        }

        $bodyData = [
            "currency_id"=>$request->get('currency'),
            "discount_amount"=>$request->get('discount_amount'),
            "discount_type_id"=>$request->get('discount_type'),
            "end_date"=>$request->get('end_date'),
            "product_id"=>$request->get('product'),
            "start_date"=>$request->get('start_date')
        ];
        $fieldData = json_encode($bodyData);

        $api_url = env('API_BASE_URL')."/api/product-discount/add";
        $curlOutput  = HandleApi::getCURLOutput( $api_url, 'POST', $fieldData );

        $decodedResp = json_decode($curlOutput);
        if($decodedResp->status == 201){
            return response()->json( ['responseCode'=>1,'message'=>'Successfully added']);
        }else{
            return response()->json( ['responseCode'=>0,'message'=>$decodedResp->message]);
        }
    }


    public function productDiscountInfo(Request $request)
    {
        $rules = [
            'product_discount_id'        => 'required'
        ];
        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required field']);
        }

        $product_discount_id = $request->get('product_discount_id');

        $api_url_discount_type = env('API_BASE_URL','https://xplaza-backend.herokuapp.com')."/api/discount-type";
        $curlOutput_discount_type  = HandleApi::getCURLOutput( $api_url_discount_type, 'GET', [] );
        $json_resp_discount_type = json_decode($curlOutput_discount_type);
        $discount_type = isset($json_resp_discount_type->data) ? $json_resp_discount_type->data : [];

        $api_url_currency_id = env('API_BASE_URL','https://xplaza-backend.herokuapp.com')."/api/currency";
        $curlOutput_currency_id  = HandleApi::getCURLOutput( $api_url_currency_id, 'GET', [] );
        $json_resp_currency_id = json_decode($curlOutput_currency_id);
        $currency_id = isset($json_resp_currency_id->data) ? $json_resp_currency_id->data : [];

        $api_url = env('API_BASE_URL','https://xplaza-backend.herokuapp.com')."/api/product-discount/".intval($product_discount_id);
        $curlOutput  = HandleApi::getCURLOutput( $api_url, 'GET', [] );
        $decodedData = json_decode($curlOutput);
        $discount_data = isset($decodedData->data) ? $decodedData->data : [];

        $api_url = env('API_BASE_URL','https://xplaza-backend.herokuapp.com')."/api/product?user_id=".Session::get('userId');;
        $curlOutput  = HandleApi::getCURLOutput( $api_url, 'GET', [] );
        $decodedData = json_decode($curlOutput);
        $productData = isset($decodedData->data) ? $decodedData->data : [];

        $shops = Session::get('shopList');


        $public_html = strval(view("product_discount.modal_data", compact('discount_type','currency_id','productData','shops','discount_data')));

        return response()->json(['responseCode' => 1, 'html' => $public_html, 'message'=>'Successfully fetches']);


    }


    public function updateProductDiscount(Request $request)
    {
        if (AclHandler::hasAccess('Product Discount','update') == false){
            return response()->json( ['responseCode'=>0,'message'=>'Not access . Recorded this']);
        }

        $rules = [
            'product_discount_id'     => 'required',
            'discount_amount'        => 'required',
            'currency'        => 'required',
            'discount_type'        => 'required',
            'start_date'        => 'required',
            'end_date'        => 'required',
            'product'        => 'required'
        ];
        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required field']);
        }


        $bodyData = [
            "currency_id"=>$request->get('currency'),
            "discount_amount"=>$request->get('discount_amount'),
            "discount_type_id"=>$request->get('discount_type'),
            "end_date"=>$request->get('end_date'),
            "product_id"=>$request->get('product'),
            "start_date"=>$request->get('start_date'),
            "id"=>$request->get('product_discount_id')
        ];

        $fieldData = json_encode($bodyData);

        $api_url = env('API_BASE_URL')."/api/product-discount/update";
        $curlOutput  = HandleApi::getCURLOutput( $api_url, 'PUT', $fieldData );

        $decodedResp = json_decode($curlOutput);
        if($decodedResp->status == 200){
            return response()->json( ['responseCode'=>1,'message'=>'Successfully updated']);
        }else{
            return response()->json( ['responseCode'=>0,'message'=>$decodedResp->message]);
        }

    }



    public function deleteProductDiscount(Request $request)
    {
        if (AclHandler::hasAccess('Product Discount','delete') == false){
            return response()->json( ['responseCode'=>0,'message'=>'Not access . Recorded this']);
        }

        $rules = [
            'product_discount_id'   => 'required'
        ];
        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required field']);
        }

        $api_url = env('API_BASE_URL')."/api/product-discount/".intval($request->get('product_discount_id'));
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
