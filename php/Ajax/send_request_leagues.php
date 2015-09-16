<?php


include "../../db.inc";

include "../Function/Tool_leghe.php";

include "../JWT.php";

$id_utente=$_GET['name'];
$id_lega=$_GET['id'];


$Leagues=Send_request($id_lega,$id_utente);
$json_o=json_decode($Leagues,true); /* decodifico json */
$i=0;
foreach($json_o as $r){
	for (;$i< sizeof($r[Result]);$i++)
		 print '<p>'.$r[Result][$i][Status].'</p>';
}

?>