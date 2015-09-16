<?php


include "../../db.inc";

include "../Function/Tool_leghe.php";

include "../JWT.php";

$id_utente=$_GET['id'];
$id_lega=$_GET['lega'];
$val=$_GET['val'];

if ($val==1 or $val==2){
	$Leagues=Conform_request($id_lega,$id_utente,$val);
	$json_o=json_decode($Leagues,true); 
	$i=0;
	foreach($json_o as $r){
		for (;$i< sizeof($r[Result]);$i++)
			 print '<div class="confirm_request">'.$r[Result][$i][Status].'</div>';
	}
}
?>