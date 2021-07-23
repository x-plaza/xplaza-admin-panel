<?php

namespace App\Http\Controllers;

use App\Libraries\HandleApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class apiAuthenticationsController extends Controller
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
    public function create()
    {
        //
    }


    /**
     * @param Request $request
     * @return \Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */

    public function loginAttempt(Request $request)
    {
      //  dd($request->all());
        $bodyData = [
            "username "=>$request->get('email'),
            "password "=>$request->get('password')
        ];
        $fieldData = json_encode($bodyData);
        $pass = $request->get('password');
        $username = $request->get('email');

        try{

            $api_url = env('API_BASE_URL')."/api/login?password=".$pass."&username=".$username;
            $curlOutput  = HandleApi::getCURLOutput( $api_url, 'POST', [] );
            $decodedResp = json_decode($curlOutput);

            if(!isset($decodedResp->data->authentication)) {return redirect()->back()->with('error', "Opps! Something wrong");}

            if($decodedResp->data->authentication == true){
                $shopList = isset($decodedResp->data->shopList)? $decodedResp->data->shopList : [];
                $userId = isset($decodedResp->data->id)? $decodedResp->data->id : '';
                Session::put('authenticated', 'true');
                Session::put('authData', $decodedResp->data->authData);
                Session::put('permissions', $decodedResp->data->permissions);
                Session::put('shopList', $shopList);
                Session::put('userId', $userId);
                return redirect('/home');
            }else{
                return redirect()->back()->with('error', "Sorry! Invalid Credentials");
            }

        } catch (\Exception $e) {
            Session::forget('authenticated');
            Session::forget('authData');
            Session::forget('permissions');
            Session::forget('shopList');
            Session::forget('userId');
            return redirect()->back()->with('error', "Something wrong");
        }
    }



    public function logOutAttempt()
    {
        Session::forget('authenticated');
        Session::forget('authData');
        Session::forget('permissions');
        Session::forget('shopList');
        Session::forget('userId');
        return redirect('/login');
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
