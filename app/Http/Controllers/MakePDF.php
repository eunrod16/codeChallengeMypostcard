<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use PDF;
class MakePDF extends Controller
{
public function index(){
return view('PdfDemo');
}
public function samplePDF()
{
$html_content = '<h1>Generate a PDF using TCPDF in laravel </h1>
<h4>by<br/>Learn Infinity</h4>';
PDF::SetTitle('Sample PDF');
PDF::AddPage();
PDF::writeHTML($html_content, true, false, true, false, '');
PDF::Output('SamplePDF.pdf');
}
public function savePDF()
{
$html_content = '<h1>Generate a PDF using TCPDF in laravel </h1>
<h4>by<br/>Learn Infinity</h4>';
PDF::SetTitle('Sample PDF');
PDF::AddPage();
PDF::writeHTML($html_content, true, false, true, false, '');
PDF::Output(public_path(uniqid().'_SamplePDF.pdf'), 'F');
}
public function downloadPDF()
{
$html_content = '<h1>Generate a PDF using TCPDF in laravel </h1>
<h4>by<br/>Learn Infinity</h4>';
PDF::SetTitle('Sample PDF');
PDF::AddPage();
PDF::writeHTML($html_content, true, false, true, false, '');
PDF::Output(uniqid().'_SamplePDF.pdf', 'D');
}
public function HtmlToPDF()
{
$view = \View::make('HtmlToPDF');
$html_content = $view->render();
PDF::SetTitle('Sample PDF');
PDF::AddPage();
PDF::writeHTML($html_content, true, false, true, false, '');
PDF::Output(uniqid().'_SamplePDF.pdf');
}
}
