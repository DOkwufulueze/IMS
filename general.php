<?php
include('db.php');
$rtrt=0;

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>General Inventory</title>

<style>
body
{
font-family:Arial, Helvetica, sans-serif;
font-size:14px;
}
.editbox
{
display:none
}
td
{
padding:7px;
border-left:1px solid #fff;
border-bottom:1px solid #fff;
}
table{
border-right:1px solid #fff;
}
.edit_tr:hover
{
}
.edit_tr
{
background: none repeat scroll 0 0 #D5EAF0;
}
th
{
font-weight:bold;
text-align:left;
padding:7px;
border:1px solid #fff;
border-right-width: 0px;
}
.head
{
background: none repeat scroll 0 0 #91C5D4;
color:#00000;

}

</style>
<link rel="stylesheet" href="css/reset.css" type="text/css" media="screen" />

<link rel="stylesheet" href="css/tab.css" type="text/css" media="screen" />
</head>

<body bgcolor="#dedede" style="width: 939px;">
 
<h1>General Inventory</h1>
<div id="box1">
<ul id="boxes">
<li id="inventory" class="box">
<table width="912px">
<tr class="head">
<th>Date</th>
<th>Item</th>
<th>Qty Sold </th>
<th>Quantity Start</th>
<th>Price</th>
<th>Sales</th>
<th>Quantity End</th>
</tr>
<?php
$da=date("Y-m-d");

$sql=mysql_query("select * from inventory");
$i=1;
while($row=mysql_fetch_array($sql))
{
$rtrt=0;
$id=$row['id'];
$item=$row['item'];
$qtyleft=$row['qtyleft'];
$qty_sold=$row['qty_sold'];
$price=$row['price'];
$sales=$row['sales'];
if($i%2)
{
?>
<tr id="<?php echo $id; ?>" class="edit_tr">
<?php } else { ?>
<tr id="<?php echo $id; ?>" bgcolor="#f2f2f2" class="edit_tr">
<?php } ?>
<td class="edit_td">
<span class="text"><?php echo $da; ?></span> 
</td>
<td>
<span class="text"><?php echo $item; ?></span> 
</td>
<td>
<span id="last_<?php echo $id; ?>" class="text">
<?php
$sqls=mysql_query("select * from sales where product_id='$id'");
while($rows=mysql_fetch_array($sqls))
{
$rtrt+=$rows['qty'];
}
echo $rtrt;
?>
</span> 
<input type="text" value="<?php echo $rtrt; ?>"  class="editbox" id="last_input_<?php echo $id; ?>"/>
</td>
<td>
<?php $begbal=$rtrt+$qtyleft;?>
<span class="text"><?php echo $begbal; ?></span>
</td>
<td>
<span id="first_<?php echo $id; ?>" class="text"><?php echo "=N= ".formatNaira($price, true); ?></span>
<input type="text" value="<?php echo $price; ?>" class="editbox" id="first_input_<?php echo $id; ?>" />
</td>
<td>
<?php $dailysales=$rtrt*$price;?>
<span class="text"><?php echo "=N= ".formatNaira($dailysales, true); ?></span> 
</td>
<td>
<span class="text"><?php echo $qtyleft; ?></span>
</td>
</tr>

<?php
$i++;
}
?>

</table>
<br />
<div style="float:left;">
Total Sales:
 <b>=N= <?php
	$result1 = mysql_query("SELECT sales FROM sales");
	$sls=0;
	while($row = mysql_fetch_array($result1))
	{
		$rrr=$row['sales'];
		$sls+=$rrr;
		
	}
	echo formatNaira($sls, true);
?></b>
</div><br /><br />
<div style="float:left;">
Total Expired and Disposed Products Worth:
 <b>=N= <?php
	$result1 = mysql_query("SELECT inventory.price from inventory LEFT JOIN product_codes ON(inventory.id=product_codes.product_id) where product_codes.disposed_of='1'");
	$pr=0;
	while($row = mysql_fetch_array($result1))
	{
		$rrr=$row['price'];
		$pr+=$rrr;
	}
	echo formatNaira($pr, true);
?></b>
</div><br /><br />
<input name="" type="button" value="Print Inventory" onclick="javascript:window.print()" style="cursor:pointer; float:left;" /><input name="" type="button" value="Save Inventory" onclick="document.location.href='report.php'" style="cursor:pointer; float:left;" />&nbsp;&nbsp;
<a href="printform.php">Back to Today's Inventory</a>
</li>
</ul>
</div>

</body>
</html>
