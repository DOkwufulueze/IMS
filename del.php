<?php
	include("db.php");
	$proId=mysql_escape_String(!isset($_GET['proId'])?"":$_GET['proId']);
	$id=mysql_escape_String(!isset($_GET['id'])?"":$_GET['id']);
	if(mysql_query("UPDATE product_codes SET disposed_of='1' WHERE id='$id'")){
		if(mysql_query("UPDATE inventory SET qtyleft=qtyleft-1 WHERE id='$proId'")){
			echo "<script>document.location.href='ims.php?msgExpired=:::Expired Product Disposed of Successfully.#page=expired'</script>";
		}
		else{
			mysql_query("UPDATE product_codes SET expired='0' WHERE id='$id'");
			echo "<script>document.location.href='ims.php?msgExpired=:::Expired Product could not be Disposed of for now.#page=expired'</script>";
		}
	}
?>