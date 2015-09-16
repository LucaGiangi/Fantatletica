<?php


function Read_futureRace($data){

	global $connessione;
	$Array_Race=array();
	
	$q="SELECT * FROM Competizione where Data_fine>='".$data."' and Type<2 order by Data_inizio LIMIT 0,3";
	$t=mysql_query($q,$connessione); 		
	while($r=mysql_fetch_object($t)){
		
		$attivo=false;
		if ((strtotime($r->Inizio_formazione)<strtotime($data)) && (strtotime($r->Termine_formazione)>strtotime($data)) )//verifico se la gara è attiva
			$attivo= true;
		$Array_Race[]=array('Id' => $r->Id_competizione, 'Nome' => $r->Nome, 'Sede'=>$r->Sede, 'Inizio_formazione' => $r->Inizio_formazione, 'Termine_formazione' => $r->Termine_formazione, 'Header_link' => $r->Header_link, 'Cover_link' => $r->Cover_link,'Budget' => $r->Budget,'Type' => $r->Type,'Stato_classifica' => $r->Stato_classifica,'Attiva'=>$attivo);		
	}     
	$Array_send[] =array('Races' => $Array_Race);	
	$json=json_encode($Array_send,true);
	return $json;	
}

function Read_race($id){
	global $connessione;
	$Array_Race=array();
	
	$q="SELECT * FROM Competizione where  Id_competizione='".$id."' order by Data_inizio LIMIT 0,3";
	$t=mysql_query($q,$connessione); 		
	while($r=mysql_fetch_object($t)){
		
		$attivo=false;
		if ((strtotime($r->Inizio_formazione)<strtotime($data)) && (strtotime($r->Termine_formazione)>strtotime($data)) )
			$attivo= true;
		$Array_Race[]=array('Id' => $r->Id_competizione, 'Nome' => $r->Nome, 'Sede'=>$r->Sede, 'Inizio_formazione' => $r->Inizio_formazione, 'Termine_formazione' => $r->Termine_formazione, 'Header_link' => $r->Header_link, 'Cover_link' => $r->Cover_link,'Budget' => $r->Budget,'Type' => $r->Type,'Stato_classifica' => $r->Stato_classifica,'Attiva'=>$attivo);		
	}     
	$Array_send[] =array('Races' => $Array_Race);	
	$json=json_encode($Array_send,true);
	return $json;
	
}

function Read_pastRace($data){

	global $connessione;
	$Array_Race=array();
	
	$q="SELECT * FROM Competizione WHERE Data_fine<'".$data."' =  'Ufficiale' ORDER BY Data_inizio DESC LIMIT 0 , 5";
	$t=mysql_query($q,$connessione); 		
	while($r=mysql_fetch_object($t)){	
		$Array_Race[]=array('Id' => $r->Id_competizione, 'Nome' => $r->Nome, 'Sede'=>$r->Sede, 'Inizio_formazione' => $r->Inizio_formazione, 'Termine_formazione' => $r->Termine_formazione, 'Header_link' => $r->Header_link, 'Cover_link' => $r->Cover_link,'Budget' => $r->Budget,'Type' => $r->Type,'Stato_classifica' => $r->Stato_classifica);		
	}     
	$Array_send[] =array('Races' => $Array_Race);	
	$json=json_encode($Array_send,true);
	return $json;	
}

function Read_pastRace_fanta($data){

	global $connessione;
	$Array_Race=array();
	
	$q="SELECT * FROM Competizione WHERE (Stato_classifica =  'Ufficiale' and Type='0') ORDER BY Data_inizio DESC LIMIT 0 , 5";
	$t=mysql_query($q,$connessione); 		
	while($r=mysql_fetch_object($t)){	
		$Array_Race[]=array('Id' => $r->Id_competizione, 'Nome' => $r->Nome, 'Sede'=>$r->Sede, 'Inizio_formazione' => $r->Inizio_formazione, 'Termine_formazione' => $r->Termine_formazione, 'Header_link' => $r->Header_link, 'Cover_link' => $r->Cover_link,'Budget' => $r->Budget,'Type' => $r->Type,'Stato_classifica' => $r->Stato_classifica);		
	}     
	$Array_send[] =array('Races' => $Array_Race);	
	$json=json_encode($Array_send,true);
	return $json;	
}
?>