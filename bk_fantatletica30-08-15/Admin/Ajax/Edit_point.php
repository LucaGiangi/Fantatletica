<?php
$page_name = "Read_iscritti_punti_fanta";
//versione 4.1 responsitive

//($_SESSION['id_competizione']!=-1)  usato per verificare la possibilità di modificare la squadra
session_start();

/*$data = date ("Y-m-d");*/
$data = date("Y/m/d G:i:s");
$data_1 = date("Y/m/d");

include "../../db.inc";
include "../../php/formatta_data.php"; 

include '../../php/Gestione_token.php';
include '../../php/verifica_accesso_g.php';
include "../../php/logout.php";

include '../../php/check_admin.php';

// $_GET['gara']=1 -> gara 1
// $_GET['gara']=2 -> gara 2

if ($_GET['gara']==1){
	$q="UPDATE Iscritti set Risultato_punti='".$_GET['punti']."' where Id_iscritti='".$_GET['id']."'";

}else{
	$q="UPDATE Iscritti set Risultato_classifica='".$_GET['punti']."' where Id_iscritti='".$_GET['id']."'";
}

if (!mysql_query($q,$connessione))
	print "Errore";
else
	print "Inserimento avvenuto";
//print $_GET['gara']." ".$_GET['id']." ".$_GET['punti'];


?>