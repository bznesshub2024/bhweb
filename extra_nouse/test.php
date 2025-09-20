<?php

require_once('tcpdf/tcpdf.php');



$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator('Webinovers');
$pdf->SetAuthor('Webinovers');
$pdf->SetTitle('Webinovers');
$pdf->SetSubject('Webinovers');
$pdf->SetKeywords('Webinovers');

	
// set default header data
 $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->SetHeaderData('media/google_play.png', PDF_HEADER_LOGO_WIDTH, '', '', array(
            0,
            0,
            0
        ), array(
            255,
            255,
            255
        ));
        $pdf->SetTitle('Invoice - ' . $result[0]["order_invoice"]);
        $pdf->SetMargins(20, 0, 20, true);
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once (dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }
        $pdf->SetFont('helvetica', '', 11);
        $pdf->AddPage();

$html2 = '

<html>
<head></head>
<body>
<div style="text-align:center;">
        <b>Tax Invoice</b>
    </div>
<table style="line-height: 1.5;">
    <tr><td style="font-size:10px;"><b>Sold By: Tech-Connect Retail Private Limited</b> </td>
        <td style="text-align:right;"><b>Invoice Number:</b> #4234234</td>
    </tr>
    <tr>
        <td colspan="2"><b style="font-size:10px;">Ship-from Address:</b> <span style="font-size:8px;">Marasandra and Madnahatti -Venkatapura Villages, Kasaba Hobli, Malur Taluk ,Dist -Kolar, Malur, Bangalore,
Karnataka, India - 563130, IN-KA</span></td>
    </tr>
    <tr>
        <td  colspan="2"><b style="font-size:10px;">GSTIN: </b>29AAICA4872D1Z3  </td>
        
    </tr>

</table>
    <div style="text-align: left;border-top:1px solid #000;">
        
    </div>
<table style="line-height: 1.5;">
    <tr>
		<td width="35%"><b  style="font-size:9px;">Order ID:</b> <span style="font-size:8px;">OD121286153268977000 </span></td>
        <td width="25%" style="text-align:left;font-size:9px;"><b>Bill To</b></td>
        <td width="25%" style="text-align:left;font-size:9px;"><b>Shipping To</b></td>
        <td width="15%"style="text-align:left;"></td>
    </tr>
    <tr>
        <td><b  style="font-size:9px;">Order Date:</b> <span style="font-size:8px;">2021-03-31</span></td>
        <td style="text-align:left;font-size:9px;"><b>Sandeep Yadav</b></td>
        <td style="text-align:left;font-size:9px;"><b>Sandeep Yadav</b></td>
        <td style="font-size:8px;text-align:left;" rowspan="5">*Keep this invoice and manufacturer box for warranty purposes.</td>
    </tr>
    <tr>
        <td><b  style="font-size:9px;">Invoice Date:</b> <span style="font-size:8px;"> 2021-03-31</span></td>
        <td style="text-align:left;"><span style="font-size:8px;">vpo-baldhan kalan, Near post office.
			Rewari 123411 Haryana</span></td>
		<td style="text-align:left;"><span style="font-size:8px;">vpo-baldhan kalan, Near post office.
			Rewari 123411 Haryana</span></td>
    </tr>
	 <tr>
        <td><b  style="font-size:9px;">PAN:</b> <span style="font-size:8px;"> 2423434</span></td>
        <td style="text-align:left;"><b  style="font-size:9px;">Phone:</b> <span style="font-size:8px;"> 2423434</span></td>
        <td style="text-align:left;"><b  style="font-size:9px;">Phone:</b> <span style="font-size:8px;"> 2423434</span></td>
    </tr>
	<tr>
        <td><b  style="font-size:9px;">CIN:</b> <span style="font-size:8px;"> 2423434</span></td>
        
    </tr>
</table>

<div></div>
    <div style="border-bottom:1px solid #000;  margin-left: 10%;">
        <table style="line-height: 2;">
            <tr style="font-weight: bold;border:1px solid #cccccc;background-color:#f2f2f2;">
                <td style="border:1px solid #cccccc;width:200px;">Item Description</td>
                <td style = "text-align:right;border:1px solid #cccccc;width:85px">Price ($)</td>
                <td style = "text-align:right;border:1px solid #cccccc;width:75px;">Quantity</td>
                <td style = "text-align:right;border:1px solid #cccccc;">Subtotal ($)</td>
            </tr>
    <tr> <td style="border:1px solid #cccccc;">FinePix Pro2 3D Camera</td>
                    <td style = "text-align:right; border:1px solid #cccccc;">1,500.00</td>
                    <td style = "text-align:right; border:1px solid #cccccc;">2</td>
                    <td style = "text-align:right; border:1px solid #cccccc;">3,000.00</td>
               </tr>
    <tr> <td style="border:1px solid #cccccc;">Luxury Ultra thin Wrist Watch</td>
                    <td style = "text-align:right; border:1px solid #cccccc;">300.00</td>
                    <td style = "text-align:right; border:1px solid #cccccc;">1</td>
                    <td style = "text-align:right; border:1px solid #cccccc;">300.00</td>
               </tr>
<tr style = "font-weight: bold;">
    <td></td><td></td>
    <td style = "text-align:right;">Total ($)</td>
    <td style = "text-align:right;">3,300.00</td>
</tr>
<tr><td></td><td></td><td colspan="2" style = "text-align:right;">Tech-Connect Retail Private Limited</td></tr>
<tr><td></td></tr>

<tr>
    <td></td><td></td>
    <td style = "text-align:right;"></td>
    <td style = "text-align:right;">Authorized Signatory</td>
</tr>
</table></div>

<p><i>Note: Please send a remittance advice by email to sandeep@test.com</i></p>
</body>
</html>


';
//echo $html2;die;
$pdf->writeHTML($html2, true, false, true, false, ''); 


//Close and output PDF document
$pdf->Output('invoice.pdf', 'D');
