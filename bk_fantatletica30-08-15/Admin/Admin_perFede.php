<?php
$page_name = "Admin_home";
//versione 4.1 responsitive

//($_SESSION['id_competizione']!=-1)  usato per verificare la possibilità di modificare la squadra
session_start();

/*$data = date ("Y-m-d");*/
$data = date("Y/m/d G:i:s");
$data_1 = date("Y/m/d");

include "../db.inc";
include "../php/formatta_data.php"; 

include '../php/Gestione_token.php';
include '../php/verifica_accesso_g.php';
include "../php/logout.php";

include '../php/check_admin.php'; // verifica admin
global $g_nome;


?>

<!doctype html>
<html lang="it-IT">
<head>
	<meta charset="utf-8">

    <meta http-equiv="x-ua-compatible" content="IE=edge" />
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=10.0, minimum-scale=1.0, user-scalable=yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">

	<link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon"/>
	<link rel="icon" href="../images/favicon.ico" type="image/x-icon"/>
	<title>Admin - Fantatletica</title>
	<link type="text/css" media="all" href="../css/new_mobile.css" rel="stylesheet" />
    <link type="text/css" media="all" href="../css/style.css" rel="stylesheet" />
    <link type="text/css" media="all" href="../css/tabelle.css" rel="stylesheet" />
    <link type="text/css" media="all" href="Acss.css" rel="stylesheet" />
    <link rel="stylesheet" href="../Analytics/menu.css">
    
	<meta name="robots" content="noindex">
	<meta name="googlebot" content="noindex">
    <!-- menu -->
    <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
    <script src="../Analytics/script.js"></script>
    <!-- -->
	
    <script>
function Espandi(div){	
	if (document.getElementById(div).style.display=='block'){
		document.getElementById(div).style.display='none';	}
	else{
		document.getElementById(div).style.display='block';}
}
</script>

</head>



    	<?php include 'Header.php'; ?>
        
        <h1>Admin</h1> 
        <?php  
		$n_utenti =0;
		$n_utenti_abilitati =0;
		$partite_fanta=0;
		$partite_schedina =0;
		
		
		print '<h3>Giocaori per Pechino</h3>';
		$q="SELECT Nome_team from Competizione 
join Iscritti on Iscritti.Competizione_Id_competizione=Competizione.Id_competizione 
join Team on Iscritti.Id_iscritti=Team.Iscritti_id_iscritti
join Giocatore on Giocatore.Id_giocatore=Team.Giocatore_Id_giocatore
where Competizione.Id_competizione='21' group by Team.Giocatore_Id_giocatore order by Nome_team";
		$t=mysql_query($q,$connessione); 			
		while($r=mysql_fetch_object($t)){	
			print $r->Nome_team.'<br/>';	
		}
		print '<p>&nbsp;</p><p>&nbsp;</p>';
		
		
		print '<h3>Giocaori per Torino</h3>';
		$q="SELECT Nome_team from Competizione 
join Iscritti on Iscritti.Competizione_Id_competizione=Competizione.Id_competizione 
join Team on Iscritti.Id_iscritti=Team.Iscritti_id_iscritti
join Giocatore on Giocatore.Id_giocatore=Team.Giocatore_Id_giocatore
where Competizione.Id_competizione='13' group by Team.Giocatore_Id_giocatore order by Nome_team";
		$t=mysql_query($q,$connessione); 			
		while($r=mysql_fetch_object($t)){	
			print $r->Nome_team.'<br/>';	
		}
		print '<p>&nbsp;</p><p>&nbsp;</p>';
		
		
		
		print '<h3>Lista utenti abilitati</h3>';
		$q="SELECT * FROM Giocatore where Status=1 order by Nome_team";
		$t=mysql_query($q,$connessione); 		
		while($r=mysql_fetch_object($t)){	
			print $r->Nome_team.'<br/>';
		}
		print '<p>&nbsp;</p><p>&nbsp;</p>';
		
		
		
		
		print '<h3>Giocaori per Milano</h3>';
		$q="SELECT Nome_team from Competizione 
join Iscritti on Iscritti.Competizione_Id_competizione=Competizione.Id_competizione 
join Team on Iscritti.Id_iscritti=Team.Iscritti_id_iscritti
join Giocatore on Giocatore.Id_giocatore=Team.Giocatore_Id_giocatore
where Competizione.Id_competizione='6' group by Team.Giocatore_Id_giocatore order by Nome_team";
		$t=mysql_query($q,$connessione); 			
		while($r=mysql_fetch_object($t)){	
			print $r->Nome_team.'<br/>';	
		}
		print '<p>&nbsp;</p><p>&nbsp;</p>';
		
		print '<h3>Giocaori per Oslo</h3>';
		$q="SELECT Nome_team from Competizione join Giocate on Giocate.Competizione_Id_competizione=Competizione.Id_competizione 
join Giocatore on Giocatore.Id_giocatore=Giocate.Giocatore_Id_giocatore
where Competizione.Id_competizione='8' group by Giocate.Giocatore_Id_giocatore order by Nome_team";
		$t=mysql_query($q,$connessione); 			
		while($r=mysql_fetch_object($t)){	
			print $r->Nome_team.'<br/>';	
		}
		
		
			print '<h3>Giocaori per Tallin</h3>';
		$q=" SELECT DISTINCT(Nome_team) FROM `Team` JOIN Giocatore on Team.`Giocatore_Id_Giocatore`=Giocatore.Id_giocatore JOIN Iscritti on Team.Iscritti_Id_iscritti=Iscritti.Id_iscritti where Iscritti.Competizione_Id_competizione='16'";
		$t=mysql_query($q,$connessione); 			
		while($r=mysql_fetch_object($t)){	
			print $r->Nome_team.'<br/>';	
		}
		
		print '<h3>Giocaori per U20</h3>';
		$q=" SELECT DISTINCT(Nome_team) FROM `Team` JOIN Giocatore on Team.`Giocatore_Id_Giocatore`=Giocatore.Id_giocatore JOIN Iscritti on Team.Iscritti_Id_iscritti=Iscritti.Id_iscritti where Iscritti.Competizione_Id_competizione='17'";
		$t=mysql_query($q,$connessione); 			
		while($r=mysql_fetch_object($t)){	
			print $r->Nome_team.'<br/>';	
		}
		?>      
</body>
</html>

 
    