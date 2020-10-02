<?php

namespace App\Http\Controllers;
require_once('MakePDF.php');

use Illuminate\Http\Request;
use PDF;
class Welcome extends Controller
{
  public function index()
 {

    $service_url = 'https://appdsapi-6aa0.kxcdn.com/content.php?lang=de&json=1&search_text=berlin&currencyiso=EUR';
    $curl = curl_init($service_url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $curl_response = curl_exec($curl);
    if ($curl_response === false) {
        $info = curl_getinfo($curl);
        curl_close($curl);
        die('error occured during curl exec. ' . var_export($info));
    }
    curl_close($curl);
    $jsonRes = json_decode($curl_response);
    if (isset($jsonRes->response->status) && $decoded->response->status == 'ERROR') {
        die('error: ' . $jsonRes->response->errormessage);
    }

    return view('welcome',['response'=>$jsonRes->content]);
 }

 public function getPrices(Request $request){
   $service_url = 'http://www.mypostcard.com/mobile/product_prices.php?json=1&type=get_postcard_products&currencyiso=EUR&store_id='.$request->rowId;
   $curl = curl_init($service_url);
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
   $curl_response = curl_exec($curl);
   if ($curl_response === false) {
       $info = curl_getinfo($curl);
       curl_close($curl);
       die('error occured during curl exec. ' . var_export($info));
   }
   curl_close($curl);


   return $curl_response;
 }

 public function makePDF(Request $request){
   PDF::SetTitle($request->title);
   // set margins
   PDF::SetMargins(0, 0, 0);
   PDF::setCellPaddings(0,0,0,0);
   PDF::SetAutoPageBreak(TRUE, 0);
   if($request->orientation=='portrait') {
     PDF::AddPage('P', 'A4');
     $w = 210;
     $h = 297;
   }
   else{
     PDF::AddPage('L', 'A4');
     $w = 347;
     $h = 290;
   }
   /*PDF::writeHTML($html_content, true, false, true, false, '');*/
   PDF::setImageScale ( PDF_IMAGE_SCALE_RATIO );
   PDF::setJPEGQuality ( 10 );
   /*PDF::Image ( $request->thumbnail);*/
   /*Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false)*/
   PDF::Image ($request->thumbnail, 0, 0, $w,  $h,'', '', '', false, 200, '', false, false, 0,$fitonpage=true);
   PDF::Output('SamplePDF.pdf');
 }
}
