<?php
	include("top.php");
?>

	<div class='head' style="width:100%;height:250px ;overflow:hidden;">
		<div class='headItem' style="clear:none;float:left;"><img style="width:auto;height:250px;" src="images/1.jpg" alt="" /></div>
		<div class='headItem' style="clear:none;float:left;"><img style="width:auto;height:250px;" src="images/2.jpg" alt="" /></div>
		<div class='headItem' style="clear:none;float:left;"><img style="width:auto;height:250px;" src="images/3.jpg" alt="" /></div>
	</div>
	<ol id="toc">
		<li><a href="#inventory"><span>Inventory</span></a></li>
		<li><a href="#sales"><span>Sales</span></a></li>
		<li><a href="#alert"><span>Order</span></a></li>
		<li><a href="#sell"><span>Sell Product</span></a></li>
		<li><a href="#addproitem"><span>Add Item</span></a></li>
		<li><a href="#addpro"><span>Add Product</span></a></li>
		<li><a href="#editprice"><span>Edit Price</span></a></li>
		<li><a href="#expired"><span>Expired Products</span></a></li>
		<li><a href="index.php"><span>Logout</span></a></li>
	</ol>
	
	<div class="content" id="inventory">
	Click the a record to enter sales<br><br>
	<table width="100%">
	<tr class="head">
	<th>Date</th>
	<th>Item</th>
	<th>Quantity Left</th>
	<th>Qty Sold </th>
	<th>Price</th>
	<th>Alltime Sales</th>
	<th>Today's Sales</th>
	</tr>
	<?php
	$da=date("Y-m-d");

	$sql=mysql_query("select * from inventory");
	$i=1;
	while($row=mysql_fetch_array($sql))
	{
		$id=$row['id'];
		$date=$row['date'];
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
		<td style="background:<?php echo $qtyleft>=10?"#55ba55;":"#ba3333"; ?>" id="lft<?php echo $id; ?>">
		<span class="text" id="qtyL<?php echo $id; ?>" ><?php echo $qtyleft; ?></span>
		</td>
		<td>

		<span id="last_<?php echo $id; ?>" class="text">
		<?php
		$sqls=mysql_query("select * from sales where date='$da' and product_id='$id'");
		$rtrt="";
		while($rows=mysql_fetch_array($sqls))
		{
		echo $rows['qty'];//quantity sold
		//$rtrt=$rows['qty'];
		}
		?>
		</span> 
		<input type="text" value="<?php echo $qty_sold; ?>"  class="editbox" id="last_input_<?php echo $id; ?>" />
		<input type="button" class="editbox" id="last_btn_<?php echo $id; ?>" value="Validate Product" data-toggle="modal" data-target="#codeModal<?php echo $id; ?>" style="display:none;height:20px !important; width:120px !important;font-size:12px !important;background:#bababa;border-radius:8px;" />
			<div class="modal fade" id="codeModal<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title" id="modalHead<?php echo $id; ?>"> Product Validation </h4>
						</div>
						<div class="modal-body" style="clear:none;min-height:110px !important; height:auto !important;">
							<div style="float:left;clear:none;">
								<div style="clear:both;">
									Fill in the code(s) for the purchased product(s) separated by comma(s) if more than one.
								</div>
								<div style="clear:both;margin-bottom:30px;">
									<div style="font-size:11px;color:#ba7878;margin-right:10px;clear:none;float:left;width:100px;">Product Code(s)</div>
									<div style="font-size:11px;color:#7878ba;margin-right:10px;clear:none;float:left;width:auto;" ><textarea cols="60" rows="3" id="prdCode<?php echo $id; ?>" name="prdCode<?php echo $id; ?>" ></textarea> </div>
								</div>
							</div>
						</div>
						<div class="modal-footer" style="clear:none;height:50px !important;">
							<button type="button" class="btn btn-default" data-dismiss="modal" id="sbmCode" onclick="submitSales('<?php echo $id; ?>')" >Submit</button>&nbsp;&nbsp;<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div>
		</td>
		<td>
		<span id="first_<?php echo $id; ?>" class="text"><?php echo "=N= ".$price; ?></span><!--Price-->
		<input type="text" value="<?php echo $price; ?>" class="editbox" id="first_input_<?php echo $id; ?>" />
		</td>
		<td>

		<span class="text" id="sl2<?php echo $id; ?>"><?php echo "=N= ".$sales; ?></span>
		</td>
		<td>
		<span class="text" id="sl3<?php echo $id; ?>">
		<?php
		$sqls=mysql_query("select * from sales where date='$da' and product_id='$id'");
		while($rows=mysql_fetch_array($sqls))
		{
		$rtyrty=$rows['qty'];
		$rrrrr=$rtyrty*$price;
		echo "=N= ".$rrrrr;
		}

		?>
		</span> 
		</td>
		</tr>

		<?php
		$i++;
	}
	?>

	</table>
	<br />
	Total Sales of this day:
	<b>=N= <span id="sl2"> <?php		
		$result1 = mysql_query("SELECT sum(sales) FROM sales where date='$da'");
		while($row = mysql_fetch_array($result1))
		{
			$rrr=$row['sum(sales)'];
			echo formatNaira($rrr,true);
		 }
	?></span></b><br /><br />
	<input name="" type="button" value="Go To Print Page" onclick="javascript:child_open()" style="cursor:pointer;" />
	</div>
	<div class="content" id="alert">
		<ul>
		<?php
		$CRITICAL=10;
		$sql2=mysql_query("select * from inventory where qtyleft<'$CRITICAL'");
		while($row2=mysql_fetch_array($sql2))
		{
		echo '<li>'.$row2['item'].'</li>';
		}
		?>
		</ul>
	</div>
	<div class="content" id="sell">
		<div style="clear:both;"><?php echo !isset($_GET['msgSell'])?"":$_GET['msgSell'] ; ?></div>
		<form method="post" action="sell.php">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="modalHead<?php echo $id; ?>"> Sell Product </h4>
					</div>
					<div class="modal-body" style="clear:none;min-height:110px !important; height:auto !important;">
						<div style="float:left;clear:none;">
							<div style="clear:both;">
								Fill in the code(s) for the purchased product(s) separated by comma(s) if more than one.
							</div>
							<div style="clear:both;margin-bottom:30px;">
								<div style="font-size:11px;color:#ba7878;margin-right:10px;clear:none;float:left;width:100px;">Product Code(s)</div>
								<div style="font-size:11px;color:#7878ba;margin-right:10px;clear:none;float:left;width:auto;" ><textarea cols="60" rows="3" id="prdCode" name="prdCode" ></textarea> </div>
							</div>
						</div>
					</div>
					<div class="modal-footer" style="clear:none;height:50px !important;">
						<input type="submit" class="btn btn-default" value="Submit" onmousedown="valSell()" />
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="content" id="sales">
		<div style="clear:both;"><?php echo !isset($_GET['msgSales'])?"":$_GET['msgSales'] ; ?></div>
		<form action="ims.php#sales" method="post">
		From: <input name="from" type="text" class="tcal"/>
		To: <input name="to" type="text" class="tcal"/>
		  <input name="" type="submit" value="Search" />
		  </form><br />
		 Total Sales:  
		  <?php
		  $a=!isset($_POST['from'])?"":$_POST['from'];
		  $b=!isset($_POST['to'])?"":$_POST['to'];
			$result1 = mysql_query("SELECT sum(sales) FROM sales where date BETWEEN '$a' AND '$b'");
			while($row = mysql_fetch_array($result1))
			{
				$rrr=$row['sum(sales)'];
				echo sprintf("=N= %.2f",$rrr);
			 }
			
			?>
	</div>
	<div class="content" id="addproitem">
	<div style="clear:both;"><?php echo !isset($_GET['msgProd'])?"":$_GET['msgProd'] ; ?></div>
	<form action="updateproduct.php" method="post">
		<div style="margin-left: 48px;">
		Product name:<?php
		$name= mysql_query("select * from inventory");
		
		echo '<select name="ITEM" id="user" class="textfield1">';
		$num=mysql_num_rows($name);
		if($num==0){
			echo '<option value="">';
			echo "No Products yet";
			echo'</option>';
		}
		else{
			while($res= mysql_fetch_assoc($name))
			{
				echo '<option value="'.$res['id'].'">';
				echo $res['item'];
				echo'</option>';
			}
		}
		echo'</select>';
		?>
		</div>
		<br />
		Number of Item To Add:<input name="itemnumber" type="text" /><br />
		<br />
		Expiry Date:<input name="exp" type="text" class="tcal" /><br />
		<div style="margin-left: 127px; margin-top: 14px;"><input name="" type="submit" value="Add" /></div>
	</form>
	</div>
	<div class="content" id="addpro">
	<div style="clear:both;"><?php echo !isset($_GET['msgSave'])?"":$_GET['msgSave'] ; ?></div>
	<form action="saveproduct.php" method="post">
		<div style="margin-left: 48px;">
		Product name:<input name="proname" type="text" />
		</div>
		<br />
		<!--div style="margin-left: 48px;"><?php //$code=codeId(); ?>
		Product Code (Randomly Generated):<input name="procodeMock" type="text" disabled value="<?php //echo $code; ?>" size="30" /><input name="procode" type="hidden" value="<?php //echo $code; ?>" />
		</div>
		<br /-->
		<div style="margin-left: 97px;">
		Price:<input name="price" type="text" />
		</div>
		<br />
		<div style="margin-left: 80px;">
		Quantity:<input name="qty" type="text" />
		</div>
		<br />
		Expiry Date:<input name="exp2" type="text" class="tcal" /><br />
		<div style="margin-left: 127px; margin-top: 14px;"><input name="" type="submit" value="Add" /></div>
	</form>
	</div>
	<div class="content" id="editprice">
	<div style="clear:both;"><?php echo !isset($_GET['msgPrice'])?"":$_GET['msgPrice'] ; ?></div>
	<form action="updateprice.php" method="post">
		<div style="margin-left: 48px;">
		Product name:<?php
		$name= mysql_query("select * from inventory");
		
		echo '<select name="ITEM" id="user" class="textfield1">';
		 while($res= mysql_fetch_assoc($name))
		{
		echo '<option value="'.$res['id'].'">';
		echo $res['item'];
		echo'</option>';
		}
		echo'</select>';
		?>
		</div>
		<br />
		<div style="margin-left: 97px;">Price:<input name="itemprice" type="text" /></div>
		<div style="margin-left: 127px; margin-top: 14px;"><input name="" type="submit" value="Update" /></div>
	</form>
	</div>
	<div class="content" id="expired">
	<div style="clear:both;"><?php echo !isset($_GET['msgExpired'])?"":$_GET['msgExpired'] ; ?></div>
	<table width="100%">
	<tr class="head">
	<th>Date Entered</th>
	<th>Item</th>
	<th>Identifier Code</th>
	<th>Expiry Date </th>
	<th>Price</th>
	<th>Dispose Of</th>
	</tr>
	<?php
	$da=date("Y-m-d");
	$pr=0;
	$sql=mysql_query("select product_codes.product_id AS product_id, product_codes.id AS id, product_codes.date AS date, inventory.item AS item, product_codes.code as code, product_codes.expiry_date as expiry_date, inventory.price AS price from product_codes LEFT JOIN inventory ON (product_codes.product_id=inventory.id) WHERE  product_codes.sold='0' AND product_codes.expiry_date<='$da' AND product_codes.expired='1' AND product_codes.disposed_of='0'");
	$i=1;
	if(mysql_num_rows($sql)>0){
		while($row=mysql_fetch_array($sql))
		{
			$id=$row['id'];
			$proId=$row['product_id'];
			$date=$row['date'];
			$item=$row['item'];
			$code=$row['code'];
			$exp=$row['expiry_date'];
			$price=$row['price'];

			if($i%2)
			{
			?>
			<tr id="<?php echo $id; ?>">
			<?php } else { ?>
			<tr id="<?php echo $id; ?>" bgcolor="#f2f2f2">
			<?php } ?>
			<td class="edit_td">
			<span class="text"><?php echo $date; ?></span> 
			</td>
			<td>
			<span class="text"><?php echo $item; ?></span> 
			</td>
			<td >
				<span class="text" id="code<?php echo $id; ?>" ><?php echo $code; ?></span>
			</td>
			<td>
				<span id="exp<?php echo $id; ?>" class="text">
					<?php
					echo $exp;
					?>
				</span>
			</td>
			<td>
				<span id="price<?php echo $id; ?>"><?php $pr+=$price; echo "=N= ".$price; ?></span>
			</td>
			<td>
				<span ><a href="del.php?proId=<?php echo $proId; ?>&id=<?php echo $id; ?>"><img src="images/bin.jpg" style="width:40x;height:30px;" /></a></span>
			</td>
			</tr>

			<?php
			$i++;
		}
	}
	else{
		echo "<td colspan='6'>No Expired Product in Stock</td>";
	}
	?>
	
	</table>
	<span class='text'>
		Total Amount of Expired Products: <?php echo "=N= ".formatNaira($pr,true); ?>
	</span>
	</div>
	<script src="js/activatables.js" type="text/javascript"> </script>
	<script type="text/javascript">
		activatables('page', ['inventory', 'alert', 'sales', 'sell', 'addproitem', 'addpro', 'editprice','expired']);
	</script>
	
<?php
	include("foot.php");
?>
