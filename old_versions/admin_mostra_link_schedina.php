<?php
$page_name = "admin_mostra_link_schedina";
include "db.inc";
include "php/invio_mail.php";
session_start();
//versione 3.0
$Errore ="";
// esci dalla sezione admin
if ($_GET['cod']=="esci"){
	session_destroy();
	header('Location:index.php');	
}

include 'php/verifica_accesso.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Link risultati schedina</title>
</head>

<body>


<?php
		$q="SELECT Mail,E_Mail,Id_giocatore from Giocate left join Giocatore on Giocatore.Id_giocatore=Giocate.Giocatore_Id_giocatore where Competizione_Id_competizione='".$_GET['id']."'";	
		$t=mysql_query($q,$connessione); 	
			while($r=mysql_fetch_object($t)){	
			print"<a href='http://sunsetbeach-club.it/Riservato_Fede_Luca_001/VERSIONE2/RSchedina.php?Id=".$_GET['id']."&cod=".$r->Mail."&Idg=".$r->Id_giocatore."' target='new'>";
			print $r->Mail.$r->E_mail;
			
			"</a><br/>
			";
			}


?>


</body>
</html>