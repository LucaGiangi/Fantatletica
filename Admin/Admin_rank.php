<?php
$page_name = "Rank";
//versione 4.1 responsitive

//($_SESSION['id_competizione']!=-1)  usato per verificare la possibilità di modificare la squadra
session_start();

/*$data = date ("Y-m-d");*/
$data = date("Y/m/d G:i:s");
$data_1 = date("Y/m/d");

include "../db.inc";

include '../php/Gestione_token.php';
include '../php/verifica_accesso_g.php';
include "../php/logout.php";

include '../php/check_admin.php'; // verifica admin
global $g_nome;


/*
fai il conto dei punti

*/
if (false){
	//update Giocatore set Punti="", Stringa=""
	//include "db.inc";
	print "V1.0<br/>";
	$Giocatori = array();
	$i=0;
	
	$q="SELECT * FROM Giocatore where Status=1";
	$t=mysql_query($q,$connessione); 	
	while($r=mysql_fetch_object($t)){
		$Giocatori[$i]=$r->Id_giocatore;
		$i++;
	}
	
	for ($i=0;$i< count($Giocatori);$i++){
			/* conto punti per atleta */
			$Punti=0;
			$Entrato= false;
			$q="SELECT * from Team JOIN Iscritti on Iscritti.Id_iscritti= Team.Iscritti_Id_iscritti where Iscritti.Competizione_Id_competizione=17 and Team.Giocatore_Id_giocatore = '".$Giocatori[$i]."'";
			$t=mysql_query($q,$connessione); 	
			while($r=mysql_fetch_object($t)){
				$Entrato= true;
				
				if ($r->Prima_gara==$r->Gara_Gara1) {
					if($r->Capitano==0)$Punti+=$r->Risultato_punti; /* somma due volte per il capitano */
					$Punti+=$r->Risultato_punti;}
				
				if ($r->Prima_gara==$r->Gara_Gara2) {
					if($r->Capitano==0) $Punti+=$r->Risultato_classifica; /* somma due volte per il capitano */
					$Punti+=$r->Risultato_classifica;	}
			}
			//UPDATE Team set `Prima_gara`='Salto con lâ€™asta Juniores Donne' where `Prima_gara`='Salto con lâ€™asta/PV Juniores'
			/* carico dati */
			if ($Entrato){
			//$q="UPDATE Giocatore SET Punti='".$Punti."', Punti_anno=Punti_anno+".$Punti.", Partite_giocate=Partite_giocate+1 where Id_giocatore='".$Giocatori[$i]."'";
			$q="UPDATE Giocatore SET Punti_anno=Punti_anno-Punti,Punti='".$Punti."',  Partite_giocate=Partite_giocate+0 where Id_giocatore='".$Giocatori[$i]."'";
			
			//$q="UPDATE Giocatore SET Punti='".$Punti."', Punti_anno=".$Punti.", Partite_giocate=1 where Id_giocatore='".$Giocatori[$i]."'";
			if(!mysql_query($q,$connessione)) 
			print "Errore di inserimento/modifica";
			}
			print "id-> ".$Giocatori[$i]." punti-> ".$Punti."<br>";
	}
}else{
	print "Pagina riservata e bloccata!";
}

?>