<?php
$mysql_hostname = "localhost";
$mysql_user = "root";
$mysql_password = "";
$mysql_database = "ims";
$db = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) 
or die(":::Unable to connect to the DBMS");
mysql_select_db($mysql_database, $db) or die(":::Unable to connect to the database");

function updateExpiry(){
	$da=date("Y-m-d");
	mysql_query("UPDATE product_codes SET expired='1' WHERE expiry_date<='$da' AND product_codes.expired='0' AND sold='0' ") or die(mysql_error());
}

function codeId(){
	$pin="";
	$alphabet = "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ" ;
	$length = 20 ;
	$i=0;
	while($i==0){
		$pin="";
		for($j = 0 ; $j < $length ; $j++){
			$pin.= $alphabet[mt_rand(0, (strlen($alphabet)-1))] ;
		}
		$q=mysql_query("SELECT * FROM product_codes WHERE code='$pin'")or die (mysql_error());
		$num=mysql_num_rows($q);
		if($num==0){
			$i=1;
		}
	}
	return $pin;
}

function formatNaira($number, $fractional=false) {
    if ($fractional) {
        $number = sprintf('%.2f', $number);
    }
    while (true) {
        $replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number);
        if ($replaced != $number) {
            $number = $replaced;
        } else {
            break;
        }
    }
    return $number;
}		
?>