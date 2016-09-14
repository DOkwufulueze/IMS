<?php
	require_once('auth.php');
	include('db.php');
	updateExpiry();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<link rel="stylesheet" href="css/styles.css" type="text/css" />
		<link rel='stylesheet' type='text/css' href='plug/docs/dist/css/bootstrap.min.css' />
		<title>AEIMS (Andrew Eohoi IMS)</title>
		<script type="text/javascript" src="js/jq.js"></script>
		<script type="text/javascript" src="js/functions.js"></script>
		<script type="text/javascript" src="plug/docs/dist/js/bootstrap.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function()
			{
			$(".edit_tr").click(function()
			{
				var ID=$(this).attr('id');
				$("#first_"+ID).show();
				$("#last_"+ID).hide();
				$("#last_input_"+ID).show();
				$("#last_btn_"+ID).show();
				$("#valCode").show();
			});

			$(".editbox").mouseup(function() 
			{
			return false
			});

			$(document).mouseup(function()
			{
			$(".editbox").hide();
			$(".text").show();
			});

			});
		</script>
		<style>
		body
		{
		font-family:Arial, Helvetica, sans-serif;
		font-size:14px;
		padding:10px;
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
		.editbox
		{
		font-size:14px;
		width:29px;
		background-color:#ffffcc;

		border:solid 1px #000;
		padding:0 4px;
		}
		.edit_tr:hover
		{
		background:url(edit.png) right no-repeat #80C8E5;
		cursor:pointer;
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
		<link rel="stylesheet" type="text/css" href="css/tcal.css" />
		<script type="text/javascript" src="js/tcal.js"></script> 
		<link href="css/tabs.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript">

		var popupWindow=null;

		function child_open()
		{ 

		popupWindow =window.open('printform.php',"_blank","directories=no, status=no, menubar=no, scrollbars=yes, resizable=no,width=950, height=400,top=200,left=200");

		}
		</script>
	</head>
	<body bgcolor="#dedede">
 