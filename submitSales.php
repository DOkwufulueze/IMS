<?php
	include("db.php");
	$id=mysql_escape_String(!isset($_GET['id'])?"":$_GET['id']);
	$code=trim(mysql_escape_String(!isset($_GET['code'])?"":$_GET['code']));
	$codes=array();
	$codes=explode(",",$code);
	$qty_sold=mysql_escape_String(!isset($_GET['qty_sold'])?"":$_GET['qty_sold']);
	$price=mysql_escape_String(!isset($_GET['price'])?"":$_GET['price']);
	$da=date("Y-m-d");
	$flag=0;
	if($qty_sold==count($codes)){
		for($j=0;$j<$qty_sold;$j++){
			$cd=$codes[$j];
			$sql=mysql_query("select inventory.qtyleft, inventory.price, product_codes.code from inventory LEFT JOIN product_codes ON(inventory.id=product_codes.product_id) where inventory.id='$id' AND product_codes.code='$cd' AND product_codes.sold='0'");
			$num=mysql_num_rows($sql);
			if($num==0){
				$flag=1;
			}
			else{
				$q=mysql_query("SELECT expiry_date FROM product_codes WHERE product_id='$id' AND code='$cd'") or die(mysql_error());
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
				echo ":::You can't sell $qty_sold amounts of this product.";
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
					$cd=$codes[$j];
					if(!mysql_query("UPDATE product_codes SET sold='1' WHERE product_id='$id' AND code='$cd'")){
						$flag=1;
					}
				}
				if($flag==1){
					echo ":::Unable to update the database for now.";
				}
				else{
					echo "1".$ssss."~".$qtySold."*".$sl."<".formatNaira($sl2,true).">".$sl3.")";
				}
			}
		}
		else if($flag==1){
			echo ":::Invalid Product Code.";
		}
		else if($flag==2){
			echo ":::Product Already Expired.";
		}
	}
	else{
		echo ":::The number of Product codes does not match the quantity sold.";//.count($codes)." ".$codes[0];
	}
?>


