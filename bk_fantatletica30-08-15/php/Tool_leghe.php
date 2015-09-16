<?php


include "JWT.php";
include "../db.inc";
	
function ret_idBYName($name){
	global $connessione;
	$q="SELECT * from Lega where Nome='".$name."'";
	$t=mysql_query($q,$connessione);
	while($r=mysql_fetch_object($t)){	
		return $r->Id_lega;
	}
	return -1;
}

function Read_leghe($Id){
	global $connessione;
	
	// restituisci le leghe a cui l'utente Id è iscirtto
	$Array_Leghe=array();
	
	$q="select * from Lega_memb JOIN Lega on Lega.Id_lega=Lega_memb.Lega_Id_lega where Id_giocatore='".$Id."'";
	$t=mysql_query($q,$connessione);
	while($r=mysql_fetch_object($t)){	
		$Array_Leghe[]= array('Id' => $r->Id_lega , 'Nome' => $r->Nome, 'Status'=>$r->Status, 'Admin' => $r->Id_admin);	
	}	
	
	$Array_Leghe =array('Leghe' => $Array_Leghe );	
	$json=json_encode($Array_Leghe,true);

	return $json;
}

function Add_leghe($Id_admin,$Nome){
	// inserissce una nuova lega
	global $connessione;

	$trovato= false;
	if (ret_idBYName($Nome)!=-1) $trovato=true;
	
	if (!$trovato){
		$id_new_lega;
		// inserisci lega
		$q="INSERT into Lega values(NULL,'".$Nome."','1','".$Id_admin."')";
		if(!mysql_query($q,$connessione))
			return json_encode(array('Status' => "Error db","Cod" => "-1" ),true);	
		// aggiungi admin come giocatore
		$id_new_lega=ret_idBYName($Nome);
		$q="INSERT into Lega_memb values('".$Id_admin."','".$id_new_lega."','1')";
		if(!mysql_query($q,$connessione))
			return json_encode(array('Status' => "Error db","Cod" => "-1" ),true);
			
	}else
		return json_encode(array('Status' => "Nome non disponibile","Cod" => "-1" ),true);
	
	return json_encode(array('Status' => "ok","Cod" => "0" ),true);
}


function Send_request ($Id_lega,$Id){
	//invia richiest di unirsi alla lega
	global $connessione;
	// verifica di non aver gia mandato una richiesta o di non essere gia iscritto
	$Stato=-1;
	
	$q="SELECT * from Lega_memb where Id_giocatore='".$Id."' and Lega_Id_lega='".$Id_lega."'";
	$t=mysql_query($q,$connessione);
	while($r=mysql_fetch_object($t)){	
		$Stato=$r->Status;
	}
	
	if ($Stato==-1){
	// invia richiesta	
		$q="INSERT into Lega_memb values('".$Id."','".$Id_lega."','0')";
		if(!mysql_query($q,$connessione))
			return json_encode(array('Status' => "Error db","Cod" => "-1" ),true);	
		else
			return json_encode(array('Status' => "Richiesta Inviata","Cod" => "0" ),true);
	}else{ 
	
		if ($Stato==1) return json_encode(array('Status' => "Sei già membro della lega","Cod" => "-1" ),true);
		if ($Stato==0) return json_encode(array('Status' => "Hai gi&aacute; inviato una richiesta","Cod" => "-1" ),true);
		if ($Stato==2) return json_encode(array('Status' => "Utente bloccato","Cod" => "-1" ),true);
	}
}


function Conform_request ($Id_lega,$Id){
	//abilita giocaore in attesa di entrare nella lega
	global $connessione;
	$q="UPDATE  Lega_memb  set Status=1 where where Id_giocatore='".$Id."' and Lega_Id_lega='".$Id_lega."'";
	if(!mysql_query($q,$connessione))
		return json_encode(array('Status' => "Error db","Cod" => "-1" ),true);	
	else
		return json_encode(array('Status' => "Utente attivo","Cod" => "0" ),true);	
}

print Read_leghe(257);
print '<br>';

print  Add_leghe(257,"Prova_admin");

print Send_request(1,18);
?>