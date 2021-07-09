<?php

namespace App\Http\Controllers;

use App\category;
use App\Libraries\AclHandler;
use App\Libraries\Encryption;
use App\Libraries\HandleApi;
use App\shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class categoryController extends Controller
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function categoryList()
    {
        if (AclHandler::hasAccess('Category','full') == false){
            die('Not access . Recorded this '); exit();
        }

        $api_url = env('API_BASE_URL')."/api/category";
        $curlOutput  = HandleApi::getCURLOutput( $api_url, 'GET', [] );
        $json_resp = json_decode($curlOutput);

        $categories = isset($json_resp->data) ? $json_resp->data : [];
        return view('category.category_list',compact('categories'));
    }


    public function getList()
    {
        $api_url = env('API_BASE_URL')."/api/category";
        $curlOutput  = HandleApi::getCURLOutput( $api_url, 'GET', [] );

        $decodedData = json_decode($curlOutput);
        $data = $decodedData->data;

        return Datatables::of(collect($data))
            ->addColumn('action', function ($data) {
                $action = '';
                if (AclHandler::hasAccess('Category','update') == true) {
                    $action = '<button type="button" class="btn btn-info btn-xs open_category_modal" data-category_id="' . $data->id . '" ><b><i class="fa fa-edit"></i> Edit</b></button> &nbsp;';
                }
                if (AclHandler::hasAccess('Category','delete') == true) {
                    $action .= ' <button type="button" class="btn btn-danger btn-xs deleteCategory" data-category_id="' . $data->id . '"><b><i class="fa fa-trash"></i> Delete</b></button>';
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
        if (AclHandler::hasAccess('Category','add') == false){
            return response()->json( ['responseCode'=>0,'message'=>'Not access . Recorded this']);
        }

        $rules = [
            'category_name'    => 'required',
            'description'      => 'required'
        ];
        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required field']);
        }

        $category_name = $request->get('category_name');
        $description = $request->get('description');
        $parent_category_id = $request->get('parent_category');
        $parent_category = isset($parent_category_id) ? $parent_category_id : 0;

        $bodyData = [
            "name"=>$category_name,
            "description"=>$description,
            "parent_category_id"=>$parent_category
        ];
        $fieldData = json_encode($bodyData);

        $api_url = env('API_BASE_URL')."/api/category/add";
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

        $api_url = env('API_BASE_URL')."/api/category";
        $curlOutput  = HandleApi::getCURLOutput( $api_url, 'GET', [] );
        $json_resp = json_decode($curlOutput);
        $categories = isset($json_resp->data) ? $json_resp->data : [];

        $api_url = env('API_BASE_URL')."/api/category/".intval($category_id);
        $curlOutput  = HandleApi::getCURLOutput( $api_url, 'GET', [] );
        $decodedData = json_decode($curlOutput);
        $category_data = isset($decodedData->data) ? $decodedData->data : [];

        $public_html = strval(view("category.modal_data", compact('category_data','categories')));

        return response()->json(['responseCode' => 1, 'html' => $public_html, 'message'=>'Successfully fetches']);

    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateCategory(Request $request)
    {
        if (AclHandler::hasAccess('Category','update') == false){
            return response()->json( ['responseCode'=>0,'message'=>'Not access . Recorded this']);
        }

        $rules = [
            'category_id'    => 'required',
            'category_name'    => 'required',
            'description'      => 'required'
        ];
        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required field']);
        }

        $category_id = $request->get('category_id');
        $category_name = $request->get('category_name');
        $description = $request->get('description');
        $parent_category_id = $request->get('parent_category');
        $parent_category = isset($parent_category_id) ? $parent_category_id : 0;

        $bodyData = [
            "name"=>$category_name,
            "description"=>$description,
            "id"=>$category_id,
            "parent_category_id"=>$parent_category
        ];
        $fieldData = json_encode($bodyData);

        $api_url = env('API_BASE_URL')."/api/category/update";
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
    public function deleteCategory(Request $request)
    {
        if (AclHandler::hasAccess('Category','delete') == false){
            return response()->json( ['responseCode'=>0,'message'=>'Not access . Recorded this']);
        }

        $rules = [
            'category_id'        => 'required'
        ];
        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required field']);
        }

        $api_url = env('API_BASE_URL')."/api/category/".intval($request->get('category_id'));
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
