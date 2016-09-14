<?php
	include("db.php");
	$date=date("Y-m-d");
	$flag=0;
	$proname=$_POST['proname'];
	$price=$_POST['price'];
	$qty=$_POST['qty'];
	$exp=$_POST['exp2']==""?"N/A":$_POST['exp2'];
	$date=date("Y-m-d");
	$future=strtotime($date)+(60*60*24*14);
	if($exp!="N/A"&&strtotime($date)==strtotime($exp)){
		echo "<script>document.location.href='ims.php?msgSave=:::Product Expires today.#page=addpro'</script>";
	}
	else if($exp!="N/A"&&strtotime($date)>strtotime($exp)){
		echo "<script>document.location.href='ims.php?msgSave=:::Product Already Expired.#page=addpro'</script>";
	}
	else if($exp!="N/A"&&$future>=strtotime($exp)&&strtotime($exp)>strtotime($date)){
		echo "<script>document.location.href='ims.php?msgSave=:::Product Expires within 2 weeks time.#page=addpro'</script>";
	}
	else{
		$q=mysql_query("SELECT * FROM inventory WHERE item='$proname' ")or die(mysql_error());
		$n=mysql_num_rows($q);
		if($n==0){
			if(mysql_query("INSERT INTO inventory (item, price, qtyleft, date) VALUES ('$proname','$price','$qty','$date')")){
				$q=mysql_query("SELECT * FROM inventory WHERE item='$proname' ")or die(mysql_error());
				$n=mysql_num_rows($q);
				if($n>0){
					$r=mysql_fetch_assoc($q);
					$id=$r['id'];
					for($i=0;$i<$qty;$i++){
						$code=codeId();
						if(!mysql_query("INSERT INTO product_codes(product_id, code, expiry_date, sold, expired, disposed_of, date) VALUES ('$id','$code','$exp','0','0','0','$date')")){
							$flag=1;
						}
					}
					if($flag==0){
						header("location: ims.php?msgSave=$proname Successfully updloaded.#page=addpro");
					}
					else{
						mysql_query("DELETE FROM inventory WHERE id='$id'") or die(mysql_error());
						mysql_query("DELETE FROM product_codes WHERE product_id='$id'") or die(mysql_error());
						echo "<script>document.location.href='ims.php?msgSave=:::Unable to upload product.#page=addpro'</script>";
					}
				}
				
			}
			else{
				header("location: ims.php?msgSave=:::Unable to upload product.#page=addpro");
			}
		}
		else{
			header("location: ims.php?msgSave=:::Product already exists in stock.#page=addpro");
		}
	}
?>