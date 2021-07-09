<?php

namespace App\Http\Controllers;

use App\Libraries\HandleApi;
use Illuminate\Http\Request;
use Mpdf\Mpdf;

class invoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($order_id)
    {

        $api_url = env('API_BASE_URL')."/api/order/".intval($order_id);
        $curlOutputMain  = HandleApi::getCURLOutput( $api_url, 'GET', [] );
        $decodedDataForOrderDetails = json_decode($curlOutputMain);
        $orderDetailsData = $decodedDataForOrderDetails->data;
        //  dd($orderDetailsData);
        if ( !isset($orderDetailsData) ) {
            die('No data found');
        }


        $contents = view("invoice_pdf",compact('orderDetailsData'))->render();

        $mpdf = new mPDF([
            'utf-8', // mode - default ''
            'A4', // format - A4, for example, default ''
            10, // font size - default 0
            'dejavusans', // default font family
            10, // margin_left
            10, // margin right
            10, // margin top
            10, // margin bottom
            10, // margin header
            10, // margin footer
            'P'
        ]);
        // $mpdf->Bookmark('Start of the document');
        $mpdf->useSubstitutions;
        $mpdf->SetProtection(array('print'));
        $mpdf->SetDefaultBodyCSS('color', '#000');
        $mpdf->SetTitle(config('app.project_name'));
        $mpdf->SetSubject("Subject");
        $mpdf->SetAuthor("Ecom-Xplaza");
        $mpdf->autoScriptToLang = true;
        $mpdf->baseScript = 1;
        $mpdf->autoVietnamese = true;
        $mpdf->autoArabic = true;

        $mpdf->autoLangToFont = true;
        $mpdf->SetDisplayMode('fullwidth');
        $mpdf->SetHTMLFooter('
                    <table width="100%">
                        <tr>
                            <td width="50%"><i style="font-size: 10px;">Download time: {DATE j-M-Y h:i a}</i></td>
                        </tr>
                    </table>');
        $stylesheet = file_get_contents(public_path().'/admin_src/pdf_style.css');
        $mpdf->setAutoTopMargin = 'stretch';
        $mpdf->setAutoBottomMargin = 'stretch';

        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->WriteHTML($contents, 2);

        $mpdf->defaultfooterfontsize = 10;
        $mpdf->defaultfooterfontstyle = 'B';
        $mpdf->defaultfooterline = 0;

        $mpdf->SetCompression(true);
        $mpdf->Output( 'invoice.pdf', 'I');
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
