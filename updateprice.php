<?php
include("db.php");
$proid=$_POST['ITEM'];
$itemprice=$_POST['itemprice'];
if(mysql_query("UPDATE inventory SET price='$itemprice' WHERE id='$proid'")){
	header("location: ims.php?msgPrice=Price Successfully updated#page=editprice");
}
else{
	header("location: ims.php?msgPrice=:::Unable to update price.#page=editprice");
}
?>