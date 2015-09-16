<?php


//include "JWT.php";
//include "../db.inc";
	
function ret_idBYName($name){
	// restituisci id lega
	global $connessione;
	$q="SELECT * from Lega where Nome='".$name."'";
	$t=mysql_query($q,$connessione);
	while($r=mysql_fetch_object($t)){	
		return $r->Id_lega;
	}
	return -1;
}
function view_request($id){
	// mostra richieste di amicizia delle leghe il cui amministratore è id	
	global $connessione;
	$utenti_in_attesa= array();
	$q="SELECT * FROM Lega_memb join Lega on Lega.Id_lega=Lega_memb.Lega_Id_lega where (Lega.Id_admin='".$id."' and Id_giocatore!='".$id."' and Lega_memb.Status='0')";
	$t=mysql_query($q,$connessione);
	while($r=mysql_fetch_object($t)){	
		$utenti_in_attesa[]= array('Id_utente' => $r->Id_giocatore , 'Id_lega' => $r->Id_lega, 'Nome_lega'=>$r->Nome);	
	}		
	$array_send[]=array('Utenti' => $utenti_in_attesa);
	return (json_encode($array_send,true));
}
function UtentiAttivi($Id){
	// conta il numero di utenti attivi per la lega
	global $connessione;
	$Utenti=0;	
	$q="SELECT count(*) as Utenti from Lega_memb where Lega_Id_lega='".$Id."' and Status=1";
	$t=mysql_query($q,$connessione);
	while($r=mysql_fetch_object($t)){	
		return $r->Utenti;
	}
	return -1;	
}
function UtentiInAttesa($Id){
	// conta il numero di utenti attivi per la lega
	global $connessione;
	$Utenti=0;	
	$q="SELECT count(*) as Utenti from Lega_memb where Lega_Id_lega='".$Id."' and Status=-1";
	$t=mysql_query($q,$connessione);
	while($r=mysql_fetch_object($t)){	
		return $r->Utenti;
	}
	return -1;	
}

function Read_leghe($Id){
	global $connessione;
	
	// restituisci le leghe a cui l'utente Id è iscritto
	$Array_Leghe=array();
	
	$q="select * from Lega_memb JOIN Lega on Lega.Id_lega=Lega_memb.Lega_Id_lega where (Id_giocatore='".$Id."' and Lega_memb.Status='1')";
	$t=mysql_query($q,$connessione);
	while($r=mysql_fetch_object($t)){	
		$Array_Leghe[]= array('Id' => $r->Id_lega , 'Nome' => $r->Nome, 'Status'=>$r->Status, 'Admin' => $r->Id_admin);	
	}	
	
	$Array_Leghe[] =array('Leghe' => $Array_Leghe );	
	$json=json_encode($Array_Leghe,true);

	return $json;
}

function Add_leghe($Id_admin,$Nome,$File){
	
	// Se il nome del file 
	
	// inserisce una nuova lega
	global $connessione;

	$array_status= array();
	
	$trovato= false;
	if (ret_idBYName($Nome)!=-1) $trovato=true;
	
	if (!$trovato){
		$id_new_lega;
		// inserisci lega
		$q="INSERT into Lega values(NULL,'".$Nome."','1','".$Id_admin."','".$File."')";
		if(!mysql_query($q,$connessione))
			return json_encode(array('Status' => "Error db","Cod" => "-1" ),true);	
		// aggiungi admin come giocatore
		$id_new_lega=ret_idBYName($Nome);
		// l'amministratore fa parte della lega
		$q="INSERT into Lega_memb values('".$Id_admin."','".$id_new_lega."','1')";
		if(!mysql_query($q,$connessione)){
			$array_status[]=array('Result' =>(array('Status' => "Error db","Cod" => "-1")));
			$array_send[]=array('Result' => $array_status);
			$json=json_encode($array_send,true);
			return $json;
		}
	}else{
		$array_status[]=array('Status' => "Error db","Cod" => "-2");
			$array_send[]=array('Result' => $array_status);
			$json=json_encode($array_send,true);
			return $json;
	}
	$array_status[]=array('Status' => "Error db","Cod" => "0");
			$array_send[]=array('Result' => $array_status);
			$json=json_encode($array_send,true);
			return $json;
}


function Send_request ($Id_lega,$Id){
	//invia richiest di unirsi alla lega
	
	/* codici su bd
		0 utente da abilitare
		1 utente attivo
		2 utente bloccato
	*/
	global $connessione;
	// verifica di non aver gia mandato una richiesta o di non essere gia iscritto
	$Stato=-1;
	$array_status= array();
	
	$q="SELECT * from Lega_memb where Id_giocatore='".$Id."' and Lega_Id_lega='".$Id_lega."'";
	$t=mysql_query($q,$connessione);
	while($r=mysql_fetch_object($t)){	
		$Stato=$r->Status;
	}
	
	if ($Stato==-1){ /* nessuna richiesta precedentemente inviata */
	// invia richiesta	
		$q="INSERT into Lega_memb values('".$Id."','".$Id_lega."','0')";
		if(!mysql_query($q,$connessione)){
			$array_status[]=array('Status' => "Errore","Cod" => "-1" );
			$array_send[]=array('Result' => $array_status);
			return (json_encode($array_send,true));	
		}else{
			$array_status[]=array('Status' => "Richiesta inviata","Cod" => "1" );
			$array_send[]=array('Result' => $array_status);
			return (json_encode($array_send,true));	
		}
	}else{ 
	
		if ($Stato==1){
			$array_status[]=array('Status' => "Sei già membro della lega","Cod" => "-1" );
			$array_send[]=array('Result' => $array_status);
			return (json_encode($array_send,true));
		}
		if ($Stato==0){
			$array_status[]=array('Status' => "Richiesta già inviata","Cod" => "-1" );
			$array_send[]=array('Result' => $array_status);
			return (json_encode($array_send,true));
		}
		if ($Stato==2){
			$array_status[]=array('Status' => "Sei stato bloccato dall'amministratore","Cod" => "-1" );
			$array_send[]=array('Result' => $array_status);
			return (json_encode($array_send,true));	
		}
	}
}


function Conform_request ($Id_lega,$Id,$Val){
	//abilita giocaore in attesa di entrare nella lega
	global $connessione;
	$array_status= array();
	$q="UPDATE  Lega_memb  set Status='".$Val."' where Id_giocatore='".$Id."' and Lega_Id_lega='".$Id_lega."'";
	//return $q;
	if(!mysql_query($q,$connessione)){
			$array_status[]=array('Status' => "Errore","Cod" => "-1" );
			$array_send[]=array('Result' => $array_status);
			return (json_encode($array_send,true));	
	}else{
		if ($Val==1)
			$array_status[]=array('Status' => "Utente attivo","Cod" => "1" );
		else
			$array_status[]=array('Status' => "Utente bloccato","Cod" => "1" );
		$array_send[]=array('Result' => $array_status);
		return (json_encode($array_send,true));
	}
}

function search($nome){
	// cerca leghe che contengono $nome
	global $connessione;
	$Array_Leghe=array();
	
	if ($nome!=""){
		$q="SELECT * FROM Lega WHERE Nome LIKE  '%".$nome."%' ";
		$t=mysql_query($q,$connessione);
		while($r=mysql_fetch_object($t)){	
			$Array_Leghe[]= array('Id' => $r->Id_lega , 'Nome' => $r->Nome, 'Status'=>$r->Status, 'Admin' => $r->Id_admin);	
		}	
		
		$Array_Leghe[] =array('Leghe' => $Array_Leghe );	
		$json=json_encode($Array_Leghe,true);
	
		return $json;
	}
}
//print Read_leghe(257);
//print '<br>';

//print  Add_leghe(257,"Prova_admin");

//print Send_request(1,18);
?>