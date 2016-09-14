<?php
	include("db.php");
	$code=trim(mysql_escape_String(!isset($_POST['prdCode'])?"":$_POST['prdCode']));
	$codes=array();
	$code=str_replace("\r\n","",$code);
	$codes=explode(",",$code);
	$da=date("Y-m-d");
	$flag=0;
	$allSold=count($codes);
	$productIds=array();
	$ids=array();
	$prices=array();
	$qtySold=0;
	$id=0;
	$qty_sold=0;
	$sl=0;
	$price=0;
	for($j=0;$j<$allSold;$j++){
		$cd=$codes[$j];
		$sql=mysql_query("select inventory.qtyleft, inventory.price, inventory.id from inventory LEFT JOIN product_codes ON(inventory.id=product_codes.product_id) where product_codes.code='$cd' AND product_codes.sold='0' ");
		$num=mysql_num_rows($sql);
		if($num==0){
			$flag=1;
		}
		else{
			$roww=mysql_fetch_array($sql);
			$tempId=$roww['id'];
			$productIds[]=$roww['id'];
			$q=mysql_query("SELECT expiry_date FROM product_codes WHERE product_id='$tempId' AND code='$cd'") or die(mysql_error());
			if(mysql_num_rows($q)>0){
				$r=mysql_fetch_assoc($q);
				$exp=$r['expiry_date'];
				$exp=($exp!="N/A"&&$exp!="0000-00-00"&&$exp!="")?strtotime($exp):"N/A";
				if($exp!="N/A"&&strtotime($da)>=$exp){
					$flag=2;
				}
			}
			//$prices[]=$roww['price'];
		}
	}
	if($flag==0){
		$ids=array_count_values($productIds);
		$stop=0;
		$ids2=array_keys($ids);
		$qtys_sold=array_values($ids);
		for($k=0;$k<count($ids);$k++){
			$id=$ids2[$k];
			$qty_sold=$qtys_sold[$k];
			$sql=mysql_query("select * from inventory where id='$id'");
			$num=mysql_num_rows($sql);
			while($row=mysql_fetch_array($sql))
			{
				$qtyleft=$row['qtyleft'];
				$qtySold=$row['qty_sold'];
				$sl=$row['sales'];
				$price=$row['price'];
			}
			$ssss=$qtyleft-$qty_sold;
			if($ssss<5){
				header("location: ims.php?msgSell=:::You can't sell $qty_sold amounts of this product.#page=sell");
			}
			else{
				$sale=$qty_sold*$price;
				$sl+=$sale;
				$qtySold+=$qty_sold;
				$sales_sql=mysql_query("select * from sales where date='$da' and product_id='$id'");
				$count=mysql_num_rows($sales_sql);

				if($count==0)
				{
					mysql_query("INSERT INTO sales (product_id, qty, date, sales) VALUES ('$id','$qty_sold','$da','$sale')");
				}
				if($count!=0)
				{
					mysql_query("UPDATE sales set qty=qty+'$qty_sold',sales=sales+'$sale' where date='$da' and product_id='$id'");
				}
				$q=mysql_query("select * from sales where date='$da'") or die(mysql_error());
				$sl2=0;
				while($rw=mysql_fetch_array($q))
				{
					$sl2+=$rw['sales'];
				}
				$q=mysql_query("select * from sales where date='$da' and product_id='$id'") or die(mysql_error());
				$sl3=0;
				while($rw=mysql_fetch_array($q))
				{
					$sl3+=$rw['sales'];
				}
				$sql = "update inventory set qtyleft='$ssss',price='$price',sales=sales+'$sale',qty_sold=qty_sold+'$qty_sold' where id='$id'";
				mysql_query($sql);
				for($j=0;$j<$qty_sold;$j++){
					$cd=$codes[$j+$stop];
					if(!mysql_query("UPDATE product_codes SET sold='1' WHERE product_id='$id' AND code='$cd'")){
						$flag=1;
					}
				}
				if($flag==1){
					header("location: ims.php?msgSell=:::Unable to update the database for now.#page=sell");
				}
				else{
					header("location: ims.php?msgSell=:::Product Sale Successfully Posted.#page=sell");
				}
			}
			$stop+=$qty_sold;
		}
	}
	else if($flag==1){
		header("location: ims.php?msgSell=:::Invalid Product Code.#page=sell");
	}
	else if($flag==2){
		header("location: ims.php?msgSell=:::Product Already Expired.#page=sell");
	}
?>


