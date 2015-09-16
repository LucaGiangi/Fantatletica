<?php
$root='../../';

include $root.'php/JWT.php';
include $root.'db.inc';

$dati = array();

$q="SELECT * FROM Lega";
$t=mysql_query($q,$connessione); 	
while($r=mysql_fetch_object($t)){
	$dati[$r->Id_lega]= $r->Nome;
}
$json=json_encode($dati,true);
print $json_o;
?>