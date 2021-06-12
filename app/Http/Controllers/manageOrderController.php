<?php

namespace App\Http\Controllers;

use App\Libraries\AclHandler;
use App\Libraries\HandleApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class manageOrderController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function index()
    {
        return view('order.order_list');
    }


    public function getPendingList()
    {
        $api_url = "https://xplaza-backend.herokuapp.com/api/category";
        $curlOutput  = HandleApi::getCURLOutput( $api_url, 'GET', [] );

        $decodedData = json_decode($curlOutput);
        $data = $decodedData->data;

        return Datatables::of(collect($data))
            ->addColumn('action', function ($data) {
                $action = '<button type="button" class="btn btn-info btn-xs view_pending_order_details" data-category_id="' . $data->id . '" ><b><i class="fa fa-folder"></i> Details </b></button> &nbsp;';
                return $action;
            })
            ->removeColumn('id')
            ->rawColumns(['action'])
            ->make(true);
    }


    public function inprogressContent(Request $request)
    {
        $api_url = "https://xplaza-backend.herokuapp.com/api/category";
        $curlOutput  = HandleApi::getCURLOutput( $api_url, 'GET', [] );

        $decodedData = json_decode($curlOutput);
        $data = $decodedData->data;

        return Datatables::of(collect($data))
            ->addColumn('action', function ($data) {
                $action = '<button type="button" class="btn btn-info btn-xs view_pending_order_details" data-category_id="' . $data->id . '" ><b><i class="fa fa-folder"></i> Details </b></button> &nbsp;';
                return $action;
            })
            ->removeColumn('id')
            ->rawColumns(['action'])
            ->make(true);

    }


    public function deliveredContent(Request $request)
    {

        $api_url = "https://xplaza-backend.herokuapp.com/api/category";
        $curlOutput  = HandleApi::getCURLOutput( $api_url, 'GET', [] );

        $decodedData = json_decode($curlOutput);
        $data = $decodedData->data;

        return Datatables::of(collect($data))
            ->addColumn('action', function ($data) {
                $action = '<button type="button" class="btn btn-info btn-xs view_pending_order_details" data-category_id="' . $data->id . '" ><b><i class="fa fa-folder"></i> Details </b></button> &nbsp;';
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
