<?php

function Read_leghe($Id){
	include "../db.inc";
	include "JWT.php";
	
	$Array_Leghe=array();
	
	$q="select * from Lega_memb JOIN Lega on Lega.Id_lega=Lega_memb.Lega_Id_lega where Id_giocatore='".$Id."'";
	$t=mysql_query($q,$connessione);
	while($r=mysql_fetch_object($t)){	
		$Array_Leghe[]= array('Id' => $r->Id_lega , 'Nome' => $r->Nome, 'Status'=>$r->Status, 'Admin' => $r->Id_admin);	
	}	
	
	$Array_Leghe =array('Leghe' => $Array_Leghe );	
	$json=json_encode($Array_Leghe,true);

	print $json;
}

Read_leghe(257);
?>