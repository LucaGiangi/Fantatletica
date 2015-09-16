<?php

// verifica disponibilità gara
$data = date("Y/m/d G:i:s");
$_SESSION['id_competizione']=-1;  
$_SESSION['Id_competizione_select']=-1;  /* id usato nella select identifica l'ultima gara giocata */

	 $q="SELECT * FROM Competizione where Inizio_formazione<='".$data."' and Termine_formazione>='".$data."' and Type!='1' and Type!=3";
	 $t=mysql_query($q,$connessione); 	
	 while($r=mysql_fetch_object($t)){
		$_SESSION['id_competizione']=$r->Id_competizione;
		$_SESSION['nome']=$r->Nome;
		$_SESSION['sede']=$r->Sede;
		$_SESSION['id_budget']=$r->Budget;
		$_SESSION['data']=$r->Data_inizio;
		$_SESSION['fine_formazione']=$r->Termine_formazione;
		$_SESSION['Schedina']=$r->Type;
		$_SESSION['Header']=$r->Header_link;
	 }
/****/

/* cerca ultimo team giocato  info usate nella pagina team per visualizzare l'ultmo team creato */
if ($_SESSION['id_competizione']==-1){
	
	 $q="SELECT * FROM Competizione where Termine_formazione<='".$data."' order by Termine_formazione and Type!='1'";
	 $t=mysql_query($q,$connessione); 	
	 while($r=mysql_fetch_object($t)){
		$_SESSION['Id_competizione_select']=$r->Id_competizione;
		$_SESSION['nome']=$r->Nome;

	 }
}else $_SESSION['Id_competizione_select']= $_SESSION['id_competizione']; /* ho una gara attiva e quindi mostro quella */
/****/

?>