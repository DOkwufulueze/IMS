<?php
	include("db.php");
	$flag=0;
	$codes=array();
	$proid=$_POST['ITEM'];
	$itemnumber=$_POST['itemnumber'];
	$exp=$_POST['exp']==""?"N/A":$_POST['exp'];
	$date=date("Y-m-d");
	$future=strtotime($date)+(60*60*24*14);
	if($exp!="N/A"&&strtotime($date)==strtotime($exp)){
		echo "<script>document.location.href='ims.php?msgProd=:::Product Expires today.#page=addproitem'</script>";
	}
	else if($exp!="N/A"&&strtotime($date)>strtotime($exp)){
		echo "<script>document.location.href='ims.php?msgProd=:::Product Already Expired.#page=addproitem'</script>";
	}
	else if($exp!="N/A"&&$future>=strtotime($exp)&&strtotime($exp)>strtotime($date)){
		echo "<script>document.location.href='ims.php?msgProd=:::Product Expires within 2 weeks time.#page=addproitem'</script>";
	}
	else{
		$q=mysql_query("SELECT * FROM inventory WHERE id='$proid' ")or die(mysql_error());
		$n=mysql_num_rows($q);
		if($n>0){
			$r=mysql_fetch_assoc($q);
			$oldQty=$r['qtyleft'];
			$totalQty=$oldQty+$itemnumber;
			if(mysql_query("UPDATE inventory SET qtyleft='$totalQty' WHERE id='$proid'")){
				for($i=0;$i<$itemnumber;$i++){
					$code=codeId();
					$codes[$i]=$code;
					if(!mysql_query("INSERT INTO product_codes(product_id, code, expiry_date, sold, expired, disposed_of, date) VALUES ('$proid','$code', '$exp','0','0','0','$date')")){
						$flag=1;
					}
				}
				if($flag==0){
					echo "<script>document.location.href='ims.php?msgProd=:::Product Successfully updated.#page=addproitem'</script>";
				}
				else{
					mysql_query("UPDATE inventory SET qtyleft='$oldQty' WHERE id='$proid'") or die(mysql_error());
					for($i=0;$i<$itemnumber;$i++){
						$cId=$codes[$i];
						mysql_query("DELETE FROM product_id WHERE code='$cId'") or die(mysql_error());
					}
					echo "<script>document.location.href='ims.php?msgProd=:::Unable to update product.#page=addproitem'</script>";
				}
			}
		}
		else{
			echo "<script>document.location.href='ims.php?msgProd=:::Product does not exist.#page=addproitem'</script>";
		}
	}
?>