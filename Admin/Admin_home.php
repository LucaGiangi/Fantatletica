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

/*include '../php/check_admin.php'; // verifica admin (senza diritti)*/

$Privilegi_richiesti="All,";
include '../php/Check_privilegi_admin.php'; // verifica se si dispone dell'autorizzazione a vedere la pagina
$Check=Check_privilegi_admin($g_id,$Privilegi_richiesti);


if (!$Check) header('Location:Error.php');


global $g_nome;

$S_tot_utenti=0;
$S_tot_Giocatori=0;
$S_per_max=0;
$S_per_min=100;

$F_tot_utenti=0;
$F_tot_Giocatori=0;
$F_per_max=0;
$F_per_min=100;
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
		
		$q="SELECT SUM( STATUS ) AS Utenti_attivi, COUNT( * ) AS Utenti_loggati FROM Giocatore";
		$t=mysql_query($q,$connessione); 		
		while($r=mysql_fetch_object($t)){	
			$n_utenti=$r->Utenti_loggati;  
			$n_utenti_abilitati=$r->Utenti_attivi;
		}
		
		$q="SELECT COUNT( * ) AS Partite FROM Competizione where Type=0";
		$t=mysql_query($q,$connessione); 			
		while($r=mysql_fetch_object($t)){	
			$partite_fanta=$r->Partite;  	
		}
		$q="SELECT COUNT( * ) AS Partite FROM Competizione where Type=1";
		$t=mysql_query($q,$connessione); 		
		while($r=mysql_fetch_object($t)){	
			$partite_schedina=$r->Partite;  	
		}
		?>

        <div onclick="Espandi('uno')"><h3>Dati<img class="espandi" style="top:0px;" src="../images/freccia_1.png"></h3></div>
        <div class="nascondi_testo" id="uno">
            <table class="tab_el" width="50%"> <th></th><th>Numero</th><th>%</th>
                <tr class="pari"><td>Utenti loggati</td><td><?php print $n_utenti; ?></td><td><?php  ?></td></tr>
                
                <tr class="dispari"><td>Utenti Abilitati</td><td><?php print $n_utenti_abilitati; ?></td><td><?php print round(($n_utenti_abilitati/$n_utenti)*100,2);  ?>%</td></tr>
                <th></th><th>Fantatletica</th><th>Schedina</th>
                <tr class="pari"><td>Partite giocate</td><td><?php print $partite_fanta; ?></td><td><?php print $partite_schedina; ?></td></tr>
            </table>
        </div>
        <h3>Abilita utenti</h3>
        <input type="text" id="utente" name="utente" value="" placeholder="Nickname"> <input type="button" onClick="Cerca_utenti();" name="Cerca" value="Cerca" />
        
        <div id="modulo_dati">
        </div>
        
        <br/>
        <br/>
	</div>
</body>
</html>
<script language="JavaScript" type="text/javascript">
function Cerca_utenti(){
var xmlhttp;
var id=document.getElementById("utente").value;
if (window.XMLHttpRequest)
{xmlhttp=new XMLHttpRequest();}
else if (window.ActiveXObject){xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
else{alert("Il browser non supporta XMLHTTP");}
xmlhttp.onreadystatechange=function(){
if(xmlhttp.readyState==4){document.getElementById("modulo_dati").innerHTML=xmlhttp.responseText;}
}
xmlhttp.open("GET","Ajax/Read_utenti.php?id="+id,true);
xmlhttp.send(null);
}
</script>
<!--

	quante squadre avevano x giocatori con 0<x<11
Select Numero_giocatori_schierati,count(Numero_giocatori_schierati) as  Numero_team FROM
(SELECT count(`Iscritti_Id_iscritti`) as Numero_giocatori_schierati FROM `Team` join Iscritti on `Iscritti_Id_iscritti`=Iscritti.Id_iscritti where Iscritti.Competizione_Id_competizione = 6 group by `Giocatore_Id_Giocatore`) Tab_sup group by Numero_giocatori_schierati order by Numero_team desc

	lista atleti piu giocati
SELECT Cognome,Nome,count(`Iscritti_Id_iscritti`) as Giocato_n_volte 
FROM `Team` JOIN Iscritti on `Iscritti_Id_iscritti`=Iscritti.Id_iscritti
JOIN Atleti on Iscritti.Atleti_id_atleti=Atleti.Id_atleta where Iscritti.Competizione_id_competizione =7 group by `Iscritti_Id_iscritti` order by Giocato_n_volte desc

	mostra team 
SELECT * from Team JOIN Iscritti on Iscritti.Id_iscritti= Team.Iscritti_Id_iscritti join Atleti on Atleti.Id_atleta=Iscritti.Atleti_Id_atleti where Iscritti.Competizione_Id_competizione=1 and Team.Giocatore_Id_giocatore = 257

	conta punti giocatore
 SELECT IF(gara1!='NULL',gara1,0)+IF(gara2!='NULL',gara2,0) as Punti_giocatore FROM

(SELECT (sum(Risultato_punti+ IF(Prima_gara=Gara_Gara1,(IF(Capitano=0,Risultato_punti,0)),0))) as gara1 FROM Team JOIN Iscritti on Iscritti.Id_iscritti= Team.Iscritti_Id_iscritti where Prima_gara=Gara_Gara1 and Iscritti.Competizione_Id_competizione=16 and Team.Giocatore_Id_giocatore=257) as g1,

(SELECT (sum(Risultato_classifica+ IF(Prima_gara=Gara_Gara2,(IF(Capitano=0,Risultato_classifica,0)),0))) as gara2 FROM Team JOIN Iscritti on Iscritti.Id_iscritti= Team.Iscritti_Id_iscritti where Prima_gara=Gara_Gara2 and Iscritti.Competizione_Id_competizione=16 and Team.Giocatore_Id_giocatore=257) as g2


	conta punti giocatore, costo team e numero atleti
SELECT IF(gara1!='NULL',gara1,0)+IF(gara2!='NULL',gara2,0) as Punti_giocatore,costo1+costo2 as Costo_team,numero1+numero2 as Numero_atleti FROM
(SELECT (sum(Risultato_punti+ IF(Prima_gara=Gara_Gara1,(IF(Capitano=0,Risultato_punti,0)),0))) as gara1,sum(Costo_gara1) as costo1,sum(1) as numero1 FROM Team JOIN Iscritti on Iscritti.Id_iscritti= Team.Iscritti_Id_iscritti where Prima_gara=Gara_Gara1 and Iscritti.Competizione_Id_competizione=6 and Team.Giocatore_Id_giocatore=257) as g1,

(SELECT (sum(Risultato_classifica+ IF(Prima_gara=Gara_Gara2,(IF(Capitano=0,Risultato_classifica,0)),0))) as gara2,sum(Costo_gara2) as costo2,sum(1) as numero2 FROM Team JOIN Iscritti on Iscritti.Id_iscritti= Team.Iscritti_Id_iscritti where Prima_gara=Gara_Gara2 and Iscritti.Competizione_Id_competizione=6 and Team.Giocatore_Id_giocatore=257) as g2

	mostra giocatori per gara
 SELECT DISTINCT(Nome_team) FROM `Team` JOIN Giocatore on Team.`Giocatore_Id_Giocatore`=Giocatore.Id_giocatore JOIN Iscritti on Team.Iscritti_Id_iscritti=Iscritti.Id_iscritti where Iscritti.Competizione_Id_competizione='16'
    
    mostra atleti giocati e chi gli ha giocati
 SELECT Nome,Cognome,Gara_Gara1,Gara_Gara2,Nome_team,Id_giocatore FROM `Team` JOIN Giocatore on Team.`Giocatore_Id_Giocatore`=Giocatore.Id_giocatore JOIN Iscritti on Team.Iscritti_Id_iscritti=Iscritti.Id_iscritti 
JOIN Atleti on Atleti.Id_Atleta = Iscritti.Atleti_Id_atleti
where Iscritti.Competizione_Id_competizione='16'
-->
 
 
 select Nome_team, Punti_giocatore,Costo_team1,Numero_atleti from Giocatore,

(SELECT gara1+gara2 as Punti_giocatore,costo1+costo2 as Costo_team1,numero1+numero2 as Numero_atleti FROM
(SELECT (sum(Risultato_punti+ IF(Prima_gara=Gara_Gara1,(IF(Capitano=0,Risultato_punti,0)),0))) as gara1,sum(Costo_gara1) as costo1,sum(1) as numero1 FROM Team JOIN Iscritti on Iscritti.Id_iscritti= Team.Iscritti_Id_iscritti where Prima_gara=Gara_Gara1 and Iscritti.Competizione_Id_competizione=6 group by Giocatore_Id_giocatore) as g1,

(SELECT (sum(Risultato_classifica+ IF(Prima_gara=Gara_Gara2,(IF(Capitano=0,Risultato_classifica,0)),0))) as gara2,sum(Costo_gara2) as costo2,sum(1) as numero2 FROM Team JOIN Iscritti on Iscritti.Id_iscritti= Team.Iscritti_Id_iscritti where Prima_gara=Gara_Gara2 and Iscritti.Competizione_Id_competizione=6 group by Giocatore_Id_giocatore) as g2) as g3 where Status=1

<!--
	crea una funzione che restituisce i punti
DROP FUNCTION IF EXISTS  Count_point
CREATE FUNCTION Count_point(Id INT) RETURNS INT
RETURN (SELECT gara1+gara2 as Punti_giocatore FROM

(SELECT (sum(Risultato_punti+ IF(Prima_gara=Gara_Gara1,(IF(Capitano=0,Risultato_punti,0)),0))) as gara1 FROM Team JOIN Iscritti on Iscritti.Id_iscritti= Team.Iscritti_Id_iscritti where Prima_gara=Gara_Gara1 and Iscritti.Competizione_Id_competizione=6 and Team.Giocatore_Id_giocatore=Id) as g1,

(SELECT (sum(Risultato_classifica+ IF(Prima_gara=Gara_Gara2,(IF(Capitano=0,Risultato_classifica,0)),0))) as gara2 FROM Team JOIN Iscritti on Iscritti.Id_iscritti= Team.Iscritti_Id_iscritti where Prima_gara=Gara_Gara2 and Iscritti.Competizione_Id_competizione=6 and Team.Giocatore_Id_giocatore=Id) as g2);


	crea una procedura conta punti giocatore, costo team e numero atleti
DROP PROCEDURE Count_PointForPlayer

CALL Count_PointForPlayer (257,6,@Punti,@N_team,@Costo_team,@Nome);
    SELECT @Punti as Punti,@N_team as Numero,@Costo_team as Costo,@Nome as Nome
CREATE PROCEDURE Count_PointForPlayer (IN Id INT,IN Id_gara INT, OUT Punti INT, OUT N_team INT, OUT Costo_team INT, OUT Nome Varchar(100))

SELECT IF(gara1!='NULL',gara1,0)+IF(gara2!='NULL',gara2,0) as Punti_giocatore,IF(costo1!='NULL',costo1,0)+IF(costo2!='NULL',costo2,0) as Costo_team,IF(numero1!='NULL',numero1,0)+IF(numero2!='NULL',numero2,0) as Numero_atleti,Nome_team  INTO Punti,Costo_team,N_team,Nome FROM
(SELECT Nome_team  from Giocatore where Id_giocatore=Id) as Nome,
(SELECT (sum(Risultato_punti+ IF(Prima_gara=Gara_Gara1,(IF(Capitano=0,Risultato_punti,0)),0))) as gara1,sum(Costo_gara1) as costo1,sum(1) as numero1 FROM Team JOIN Iscritti on Iscritti.Id_iscritti= Team.Iscritti_Id_iscritti where Prima_gara=Gara_Gara1 and Iscritti.Competizione_Id_competizione=Id_gara and Team.Giocatore_Id_giocatore=Id) as g1,

(SELECT (sum(Risultato_classifica+ IF(Prima_gara=Gara_Gara2,(IF(Capitano=0,Risultato_classifica,0)),0))) as gara2,sum(Costo_gara2) as costo2,sum(1) as numero2 FROM Team JOIN Iscritti on Iscritti.Id_iscritti= Team.Iscritti_Id_iscritti where Prima_gara=Gara_Gara2 and Iscritti.Competizione_Id_competizione=Id_gara and Team.Giocatore_Id_giocatore=Id) as g2;



	verifica quanto giocatori hanno giocato due schedine con la stessa mail
SELECT Mail,count(Mail) AS totale
FROM Giocate
where `Competizione_Id_competizione`='22' or `Competizione_Id_competizione`='18'
GROUP BY Mail
HAVING totale > 1
ORDER BY totale
-->