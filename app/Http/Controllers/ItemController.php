<?php

namespace App\Http\Controllers;

use App\item;
use App\Libraries\HandleApi;
use App\shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('item.add_item');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function itemList()
    {
        $brand_api_url = "https://xplaza-backend.herokuapp.com/api/brand";
        $brandCurlOutput  = HandleApi::getCURLOutput( $brand_api_url, 'GET', [] );
        $brand_json_resp = json_decode($brandCurlOutput);
        $brands = isset($brand_json_resp->data) ? $brand_json_resp->data : [];

        $category_api_url = "https://xplaza-backend.herokuapp.com/api/category";
        $categoryCurlOutput  = HandleApi::getCURLOutput( $category_api_url, 'GET', [] );
        $category_json_resp = json_decode($categoryCurlOutput);
        $categories = isset($category_json_resp->data) ? $category_json_resp->data : [];

        $shop_api_url = "https://xplaza-backend.herokuapp.com/api/shop";
        $shopCurlOutput  = HandleApi::getCURLOutput( $shop_api_url, 'GET', [] );
        $shop_json_resp = json_decode($shopCurlOutput);
        $shops = isset($shop_json_resp->data) ? $shop_json_resp->data : [];

        return view('item.item_list',compact('brands','categories','shops'));
    }


    public function getList()
    {
        $api_url = "https://xplaza-backend.herokuapp.com/api/product";
        $curlOutput  = HandleApi::getCURLOutput( $api_url, 'GET', [] );

        $decodedData = json_decode($curlOutput);
        $data = $decodedData->data;

        return Datatables::of(collect($data))
            ->addColumn('action', function ($data) {
                $action = '<button type="button" class="btn btn-info btn-xs open_category_modal" data-item_id="'.$data->id.'" ><b><i class="fa fa-edit"></i> Edit</b></button> &nbsp;';
                $action .= ' <button type="button" class="btn btn-danger btn-xs deleteItem" data-item_id="'.$data->id.'"><b><i class="fa fa-trash"></i> Delete</b></button>';

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
            'item_name'    => 'required',
            'description'    => 'required',
            'shop_id'    => 'required',
            'brand_id'    => 'required',
            'category_id'    => 'required',
            'buying_price'    => 'required',
            'selling_price'    => 'required',
            'currency_id'    => 'required',
            'product_var_type_id'    => 'required',
            'product_var_type_option'    => 'required'
        ];
        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required field']);
        }

        $item_name = $request->get('item_name');
        $description = $request->get('description');
        $shop_id = $request->get('shop_id');
        $brand_id = $request->get('brand_id');
        $category_id = $request->get('category_id');
        $buying_price = $request->get('buying_price');
        $selling_price = $request->get('selling_price');
        $currency_id = $request->get('currency_id');
        $product_var_type_id = $request->get('product_var_type_id');
        $product_var_type_option = $request->get('product_var_type_option');

        $bodyData = [
            "brand_id"=>$brand_id,
            "buying_price"=>$buying_price ,
            "category_id"=>$category_id,
            "currency_id"=>$currency_id,
            "description"=>$description,
            "name"=>$item_name,
            "product_var_type_id"=>$product_var_type_id,
            "product_var_type_option"=>$product_var_type_option,
            "selling_price"=>$selling_price,
            "shop_id"=>$shop_id
        ];
        $fieldData = json_encode($bodyData);

        $api_url = "https://xplaza-backend.herokuapp.com/api/product/add";
        $curlOutput  = HandleApi::getCURLOutput( $api_url, 'POST', $fieldData );

        return response()->json( ['responseCode'=>1,'message'=>'Successfully added']);


    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function categoryInfo(Request $request)
    {
        $rules = [
            'category_id'        => 'required'
        ];
        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required field']);
        }

        $category_id = $request->get('category_id');

        $bodyData = [
            "category_id"=>$category_id
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
    public function deleteItem(Request $request)
    {
        $rules = [
            'item_id'        => 'required'
        ];
        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required field']);
        }

        $api_url = "https://xplaza-backend.herokuapp.com/api/product/".intval($request->get('item_id'));
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
