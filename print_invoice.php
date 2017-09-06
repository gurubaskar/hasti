<?php
require('html_table.php');

define('DRUPAL_ROOT', getcwd());
require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);

$orderid = $_GET['orderid'];
$partyId = $_GET['partyid'];
//href="print_invoice.php?orderid=WOI10845&partyid=10201"
$orderInformation = print_order_invoice($orderid,$partyId);
//echo "<pre>";print_r($orderInformation);
//echo $orderInformation['orderId'];
define('INR',chr(128));
$pdf = new PDF();
$pdf->AddPage('P'); 
$pdf->SetFont('Arial','B',16);
$pdf->SetAuthor('Lana Kovacevic');
$pdf->SetTitle('FPDF tutorial');
$pdf->SetTextColor(50,60,100);
//$pdf->SetDisplayMode(real,'default');
$pdf->SetXY(50,20);
$pdf->SetDrawColor(50,60,100);
$pdf->Cell(100,10,'Order Invoice',0,0,'C',0);
$pdf->SetXY(10,50);
$pdf->SetFontSize(10);
$orderdate = $orderInformation['orderDate'];
$html ='<table border="0" width="900px">
<tr>
<td height="70" colspan="5"><div>'.$orderInformation['shippingAddress'][0]['toName'].'</div></td></tr>
<tr>
<td height="70" colspan="5"><div>'.$orderInformation['shippingAddress'][0]['address1'].', '.$orderInformation['shippingAddress'][0]['address2'].'</div></td></tr>
<tr>
<td height="70" colspan="5"><div>'.$orderInformation['shippingAddress'][0]['postalCode'].'</div></td></tr>
<tr>
<td height="70" colspan="5"><div>'.$orderInformation['shippingAddress'][0]['city'].'</div></td></tr>
<tr>
<td height="70" colspan="5"><div>'.$orderInformation['shippingAddress'][0]['contactNumber'].'</div></td></tr>
<tr>
<td height="70" colspan="2"><div>Order Id:'.$orderInformation['orderId'].' </div><br/><div>Date: '.date('d-m-Y H:i:s',strtotime($orderdate)).' </div></td>
</tr>
<tr>
  <td height="30">Product</td>
  <td height="30">Description</td>
  <td height="30">Qty</td>
  <td height="30">Unit Price</td>
  <td height="30">Amount</td>
</tr>
<hr>';
foreach($orderInformation['OrderHeader'] as $order){
$html.='<tr>
		  <td height="30">'.$order['productName'][0].'</td>
		  <td height="30">'.$order['productName'][0].'</td>
		  <td height="30">'.round($order['quantity']).'</td>
		  <td height="30">Rs.'.$order['unitPrice'].'</td>
		  <td height="30">Rs.'.$order['unitPrice'].'</td>
		</tr>';	
}
$html.='<tr>
<td width="670px" height="30" align="right" colspan="4"></td>
<td width="670px" height="70"><div><hr><br></div></td></tr>
<tr>
<td width="670px" height="30" style="border: 1px solid black" colspan="4">SignUpOffers</td>
<td height="30">Rs. 0.00</td></tr>
<tr>
<tr>
<td width="670px" height="30" colspan="4">Invoice Item Shipping Charge</td>
<td height="30" style="border-bottom: 2px solid #000000;">Rs. '.number_format($orderInformation['orderShippingTotal'],2).'</td></tr>
<tr>
<td width="670px" height="30" align="right" colspan="4">Total</td>
<td width="670px" height="70">Rs. '.number_format($orderInformation['orderGrandTotal'],2).'</td></tr>';
$html.='</table>';
$pdf->WriteHTML($html);
$filename=$orderid.'.pdf';
//$pdf->Cell(40,10,'Hello World!');
$pdf->Output($filename,'I');
?>