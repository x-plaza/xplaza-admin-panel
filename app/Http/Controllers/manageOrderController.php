<?php

namespace App\Http\Controllers;

use App\Libraries\AclHandler;
use App\Libraries\HandleApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Session;

class manageOrderController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function index()
    {
        return view('order.order_list');
    }


    public function getPendingList(Request $request)
    {
        $date = $request->get('date');
        if (isset($date)){
            $api_url = env('API_BASE_URL','https://xplaza-backend.herokuapp.com')."/api/order/?order_date=".$date."&status=Pending&user_id=".Session::get('userId');
        }else{
            $api_url = env('API_BASE_URL','https://xplaza-backend.herokuapp.com')."/api/order/?status=Pending&user_id=".Session::get('userId');
        }

        $curlOutput  = HandleApi::getCURLOutput( $api_url, 'GET', [] );

        $decodedData = json_decode($curlOutput);
        $data = $decodedData->data;

        return Datatables::of(collect($data))
            ->addColumn('invoice_number', function ($data) {
                return 'INVGEN'.$data->invoice_number;
            })
            ->addColumn('action', function ($data) {
                $action = '<button type="button" class="btn btn-info btn-xs view_order_details" data-order_id="' . $data->invoice_number . '" ><b><i class="fa fa-folder"></i> Details </b></button> &nbsp;';
                return $action;
            })
           // ->removeColumn('id')
            ->rawColumns(['invoice_number','action'])
            ->make(true);
    }

    public function orderDetails(Request $request)
    {
        $rules = [
            'order_id'        => 'required'
        ];

        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required field']);
        }

        $order_id = $request->get('order_id');

        $api_url = env('API_BASE_URL','https://xplaza-backend.herokuapp.com')."/api/order/".intval($order_id);
        $curlOutputMain  = HandleApi::getCURLOutput( $api_url, 'GET', [] );
        $decodedDataForOrderDetails = json_decode($curlOutputMain);
        $orderDetailsData = $decodedDataForOrderDetails->data;
         //  dd($orderDetailsData);
        if ( !isset($orderDetailsData) ) {
            return response()->json( ['responseCode'=>0,'message'=>'No data found']);
        }

        $public_html = strval(view("order.modal_data_pending_details", compact('orderDetailsData')));

        return response()->json(['responseCode' => 1, 'html' => $public_html,'message'=>'Successfully fetches']);

    }


    public function updateStatus(Request $request)
    {
        $rules = [
            'status_id'        => 'required',
            'invoice_number'        => 'required',
        ];

        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required field']);
        }

        $status_id = $request->get('status_id');
        $invoice_number = $request->get('invoice_number');

        $api_url = env('API_BASE_URL','https://xplaza-backend.herokuapp.com')."/api/order/status-update?invoice_number=".intval($invoice_number)."&status=".intval($status_id);
        $curlOutputMain  = HandleApi::getCURLOutput( $api_url, 'PUT', [] );
        $decodedDataForOrderDetails = json_decode($curlOutputMain);
        if ( isset($decodedDataForOrderDetails->status) && $decodedDataForOrderDetails->status == 200 ) {
            return response()->json( ['responseCode'=>1,'message'=>'Successfully updated status']);
        }else{
            return response()->json( ['responseCode'=>0,'message'=>'Not updated status']);
        }

    }


    public function updateOrderQuantity(Request $request)
    {
        $rules = [
            'order_item_quantity'   => 'required',
            'invoice_number'        => 'required',
            'order_item_id'         => 'required',
        ];


        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required field']);
        }

        $order_item_quantity = $request->get('order_item_quantity');
        $invoice_number = $request->get('invoice_number');
        $order_item_id = $request->get('order_item_id');

        $api_url = env('API_BASE_URL','https://xplaza-backend.herokuapp.com')."/api/order-items/update?order_item_id=".intval($order_item_id)."&quantity=".intval($order_item_quantity);
        $curlOutputMain  = HandleApi::getCURLOutput( $api_url, 'PUT', [] );
        $decodedDataForOrderDetails = json_decode($curlOutputMain);

        if ( isset($decodedDataForOrderDetails->status) && $decodedDataForOrderDetails->status == 200 ) {
            return response()->json( ['responseCode'=>1,'message'=>'Successfully updated']);
        }else{
            return response()->json( ['responseCode'=>0,'message'=>$decodedDataForOrderDetails->message]);
        }

    }


    public function removeItem(Request $request)
    {
        $rules = [
            'invoice_number'        => 'required',
            'order_item_id'         => 'required',
        ];


        $validator = Validator::make( $request->all(), $rules );
        if ( $validator->fails() ) {
            return response()->json( ['responseCode'=>0,'message'=>'Please fill up required field']);
        }

        $order_item_quantity = $request->get('order_item_quantity');
        $invoice_number = $request->get('invoice_number');
        $order_item_id = $request->get('order_item_id');

        $api_url = env('API_BASE_URL','https://xplaza-backend.herokuapp.com')."/api/order-items/".intval($order_item_id);
        $curlOutputMain  = HandleApi::getCURLOutput( $api_url, 'DELETE', [] );
        $decodedDataForOrderDetails = json_decode($curlOutputMain);

        if ( isset($decodedDataForOrderDetails->status) && $decodedDataForOrderDetails->status == 200 ) {
            return response()->json( ['responseCode'=>1,'message'=>'Successfully removed']);
        }else{
            return response()->json( ['responseCode'=>0,'message'=>$decodedDataForOrderDetails->message]);
        }

    }


    public function confirmedContent(Request $request)
    {

        $date = $request->get('date');
        if (isset($date)){
            $api_url = env('API_BASE_URL','https://xplaza-backend.herokuapp.com')."/api/order/?order_date=".$date."&status=Confirmed&user_id=".Session::get('userId');
        }else{
            $api_url = env('API_BASE_URL','https://xplaza-backend.herokuapp.com')."/api/order/?status=Confirmed&user_id=".Session::get('userId');
        }

        $curlOutput  = HandleApi::getCURLOutput( $api_url, 'GET', [] );

        $decodedData = json_decode($curlOutput);
        $data = $decodedData->data;

        return Datatables::of(collect($data))
            ->addColumn('invoice_number', function ($data) {
                return 'INVGEN'.$data->invoice_number;
            })
            ->addColumn('action', function ($data) {
                $action = '<button type="button" class="btn btn-info btn-xs view_order_details" data-order_id="' . $data->invoice_number . '" ><b><i class="fa fa-folder"></i> Details </b></button> &nbsp;';
                return $action;
            })
          //  ->removeColumn('id')
            ->rawColumns(['invoice_number','action'])
            ->make(true);

    }

    public function pickedForDeliveryContent(Request $request)
    {
        $date = $request->get('date');
        if (isset($date)){
            $api_url = urlencode(env('API_BASE_URL','https://xplaza-backend.herokuapp.com')."/api/order/?order_date=".$date."&status=Picked%20for%20delivery&user_id=".Session::get('userId'));
        }else{
            $api_url = env('API_BASE_URL','https://xplaza-backend.herokuapp.com')."/api/order/?status=Picked%20for%20delivery&user_id=".Session::get('userId');
        }

        $curlOutput  = HandleApi::getCURLOutput( $api_url, 'GET', [] );

        $decodedData = json_decode($curlOutput);
        $data = $decodedData->data;

        return Datatables::of(collect($data))
            ->addColumn('invoice_number', function ($data) {
                return 'INVGEN'.$data->invoice_number;
            })
            ->addColumn('action', function ($data) {
                $action = '<button type="button" class="btn btn-info btn-xs view_order_details" data-order_id="' . $data->invoice_number . '" ><b><i class="fa fa-folder"></i> Details </b></button> &nbsp;';
                return $action;
            })
            //  ->removeColumn('id')
            ->rawColumns(['invoice_number','action'])
            ->make(true);

    }


    public function deliveredContent(Request $request)
    {

        $date = $request->get('date');
        if (isset($date)){
            $api_url = env('API_BASE_URL','https://xplaza-backend.herokuapp.com')."/api/order/?order_date=".$date."&status=Delivered&user_id=".Session::get('userId');
        }else{
            $api_url = env('API_BASE_URL','https://xplaza-backend.herokuapp.com')."/api/order/?status=Delivered&user_id=".Session::get('userId');
        }

        $curlOutput  = HandleApi::getCURLOutput( $api_url, 'GET', [] );

        $decodedData = json_decode($curlOutput);
        $data = $decodedData->data;

        return Datatables::of(collect($data))
            ->addColumn('invoice_number', function ($data) {
                return 'INVGEN'.$data->invoice_number;
            })
            ->addColumn('action', function ($data) {
                $action = '<button type="button" class="btn btn-info btn-xs view_order_details" data-order_id="' . $data->invoice_number . '" ><b><i class="fa fa-folder"></i> Details </b></button> &nbsp;';
                return $action;
            })
          //  ->removeColumn('id')
            ->rawColumns(['invoice_number','action'])
            ->make(true);

    }


    public function canceledContent(Request $request)
    {

        $date = $request->get('date');
        if (isset($date)){
            $api_url = env('API_BASE_URL','https://xplaza-backend.herokuapp.com')."/api/order/?order_date=".$date."&status=Cancelled&user_id=".Session::get('userId');
        }else{
            $api_url = env('API_BASE_URL','https://xplaza-backend.herokuapp.com')."/api/order/?status=Cancelled&user_id=".Session::get('userId');
        }

        $curlOutput  = HandleApi::getCURLOutput( $api_url, 'GET', [] );

        $decodedData = json_decode($curlOutput);
        $data = $decodedData->data;

        return Datatables::of(collect($data))
            ->addColumn('invoice_number', function ($data) {
                return 'INVGEN'.$data->invoice_number;
            })
            ->addColumn('action', function ($data) {
                $action = '<button type="button" class="btn btn-info btn-xs view_order_details" data-order_id="' . $data->invoice_number . '" ><b><i class="fa fa-folder"></i> Details </b></button> &nbsp;';
                return $action;
            })
            //  ->removeColumn('id')
            ->rawColumns(['invoice_number','action'])
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
