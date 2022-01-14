<?php

namespace App\Http\Controllers;

use App\Libraries\HandleApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class homeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('authAndAcl');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shops = Session::get('shopList');
        $firstShop = 0;
        foreach($shops as $shop){
            $firstShop = $shop->shop_id;
            break;
        }

        return view('home',compact('firstShop'));
    }

    public function dashboardContent(Request $request)
    {
        try {

            $shop_id = intval($request->get('shop_id'));
            $monthId = intval($request->get('monthId'));

            $api_url = env('API_BASE_URL','https://xplaza-backend.herokuapp.com')."/api/dashboard?shop_id=".$shop_id;
            $curlOutput  = HandleApi::getCURLOutput( $api_url, 'POST', [] );
            $decodedData = json_decode($curlOutput);
            $shop_data = isset($decodedData->data) ? $decodedData->data : [];

            $profit_api_url = env('API_BASE_URL','https://xplaza-backend.herokuapp.com')."/api/dashboard/monthly-profit?month=".$monthId."&shop_id=".$shop_id;
            $profit_curlOutput  = HandleApi::getCURLOutput( $profit_api_url, 'POST', [] );
            $profit_decodedData = json_decode($profit_curlOutput);
            $profit_data = isset($profit_decodedData->data) ? $profit_decodedData->data : 0;


            $public_html = strval(view("dashboard_content", compact('shop_data','profit_data')));
            return response()->json(['responseCode' => 1, 'html' => $public_html]);

        } catch (\Exception $e) {
            return response()->json(['responseCode' => 0, 'message' => 'No data found']);
        }
    }
}
