<?php
	include("db.php");
	include("fpdf17/fpdf.php");
	$date=date("d/m/Y");
	$da=$date;
	$pdf = new FPDF();
	$pdf->AddPage();
	
	$pdf->Cell(20,10," ",0,1,'C');
	$totalPrice=0;
	$totalAmountBilled=0;
	$previousTotalAmountPaid=0;
	$latestTotalAmountPaid=0;
	$totalAmountPaid=0;
	$totalBalance=0;
	$pdf->SetTextColor(100,20,20);
	$pdf->SetFillColor(240,240,240);
	$pdf->SetFont('Times','',8);
	$pdf->Cell(23,8,"DATE",1,0,'C',true);
	
	$pdf->SetFont('Times','',8);
	$pdf->Cell(46,8,"ITEM",1,0,'C',true);
	
	$pdf->SetFont('Times','',8);
	$pdf->Cell(23,8,"QUANTITY SOLD",1,0,'C',true);
	
	$pdf->SetFont('Times','',8);
	$pdf->Cell(23,8,"QUANTITY START",1,0,'C',true);
	
	$pdf->SetFont('Times','',8);
	$pdf->Cell(23,8,"PRICE",1,0,'C',true);
	
	$pdf->SetFont('Times','',8);
	$pdf->Cell(25,8,"SALES",1,0,'C',true);
	
	$pdf->SetFont('Times','',8);
	$pdf->Cell(25,8,"QUANTITY END",1,0,'C',true);
	
	$i=0;
	$pdf->SetTextColor(30,20,20);
	$qq=mysql_query("select * from inventory");
	while($row=mysql_fetch_array($qq)){
		$rtrt=0;
		$id=$row['id'];
		$item=$row['item'];
		$qtyleft=$row['qtyleft'];
		$qty_sold=$row['qty_sold'];
		$price=$row['price'];
		$sales=$row['sales'];
		$q=mysql_query("select * from sales where product_id='$id'") or die(mysql_error());
		$n=mysql_num_rows($q);
		if($n==0){
			//echo "0";
		}
		else if($n>0){
			while($rows=mysql_fetch_array($q))
			{
				$rtrt+=$rows['qty'];
			}
			$begbal=$rtrt+$qtyleft;
			$dailysales=$rtrt*$price;
			if($i%2==0){
				$pdf->SetFillColor(255,250,250);
			}
			if($i%2==1){
				$pdf->SetFillColor(249,249,249);
			}
			$pdf->SetFont('Times','',9);
			$pdf->Cell(46,6,"$date",1,0,'C',true);
			
			$pdf->SetFont('Times','',9);
			$pdf->Cell(46,6,"$item",1,0,'C',true);
			
			$pdf->SetFont('Times','',9);
			$pdf->Cell(23,6,"$rtrt",1,0,'C',true);
			
			$pdf->SetFont('Times','',9);
			$pdf->Cell(23,6,"$begbal",1,0,'C',true);
			
			$pdf->SetFont('Times','',9);
			$pdf->Cell(23,6,"=N=".formatNaira($price, true),1,0,'C',true);
			
			$pdf->SetFont('Times','',9);
			$pdf->Cell(25,6,"=N=".formatNaira($dailysales, true),1,0,'C',true);
			
			$pdf->SetFont('Times','',9);
			$pdf->Cell(25,6,"$qtyleft",1,0,'C',true);
			
		}
		$i++;
		$pdf->Cell(20,10," ",0,1,'C');
	}
	$pdf->Cell(20,10," ",0,1,'C');
	
	$result1 = mysql_query("SELECT sales FROM sales");
	$sls=0;
	while($row = mysql_fetch_array($result1))
	{
		$rrr=$row['sales'];
		$sls+=$rrr;
		
	}
	
	$result1 = mysql_query("SELECT inventory.price from inventory LEFT JOIN product_codes ON(inventory.id=product_codes.product_id) where product_codes.disposed_of='1'");
	$pr=0;
	while($row = mysql_fetch_array($result1))
	{
		$rrr=$row['price'];
		$pr+=$rrr;
	}
	$pdf->SetFillColor(244,250,250);
	
	$pdf->SetTextColor(50,140,250);
	$pdf->SetFont('Times','',10);
	$pdf->Cell(40,5,"Total Sales:",0,0,'L');
	
	$pdf->SetTextColor(100,20,20);
	$pdf->SetFont('Times','I',10);
	$pdf->Cell(40,5,"=N=".formatNaira($sls, true),1,0,'L',true);
	
	$pdf->Cell(20,10," ",0,0,'C');
	
	$pdf->SetTextColor(50,140,250);
	$pdf->SetFont('Times','',10);
	$pdf->Cell(40,5,"Total Expired and Disposed Products Worth:",0,0,'L');
	
	$pdf->SetTextColor(100,20,20);
	$pdf->SetFont('Times','I',10);
	$pdf->Cell(50,5,"=N=".formatNaira($pr, true),1,0,'L',true);
	
	$pdf->Cell(20,10," ",0,1,'C');
	
	$pdf->Output();
?>