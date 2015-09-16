<?php

$page_name = "create_select_forMail";
//versione 1.0

/*$data = date ("Y-m-d");*/
$data = date("Y/m/d G:i:s");
$data_1 = date("Y/m/d");

include "../db.inc";
include "../php/formatta_data.php"; 

include '../php/Gestione_token.php';
include '../php/verifica_accesso_g.php';
include "../php/logout.php";

/*include '../php/check_admin.php'; // verifica admin (senza diritti)*/

$Privilegi_richiesti="All,";
include '../php/Check_privilegi_admin.php'; // verifica se si dispone dell'autorizzazione a vedere la pagina
$Check=Check_privilegi_admin($g_id,$Privilegi_richiesti);


if (!$Check) header('Location:Error.php');


$stringa="select user_email from wp_users WHERE ";

$q="SELECT Id_giocatore from Giocatore where Status=1";
$t=mysql_query($q,$connessione); 		
while($r=mysql_fetch_object($t)){
	$stringa=$stringa."ID ='".$r->Id_giocatore."' or ";

}
print $stringa;

?>
