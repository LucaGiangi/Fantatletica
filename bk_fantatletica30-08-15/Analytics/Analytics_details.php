<?php
$page_name = "Analytics_details";
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
	<title>Statistiche - Fantatletica</title>
	<link type="text/css" media="all" href="../css/new_mobile.css" rel="stylesheet" />
    <link type="text/css" media="all" href="../css/style.css" rel="stylesheet" />
    <link type="text/css" media="all" href="../css/tabelle.css" rel="stylesheet" />
    
    <link rel="stylesheet" href="menu.css">
    
    <META HTTP-EQUIV="refresh" CONTENT="300" URL="http://www.fantatletica.it/Analytics/Analytics_V1.php">
    <!-- menu -->
    <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
    <script src="script.js"></script>
    <!-- -->
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script type="text/javascript" src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1','packages':['annotationchart']}]}"></script>
    <script type='text/javascript'>
      google.load('visualization', '1', {'packages':['annotationchart']});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('date', 'Date');
        data.addColumn('number', '%');
        data.addColumn('string', 'Sede');
       
        data.addRows([
         /* [new Date(2314, 2, 15), 12400,'aa'],
          [new Date(2314, 2, 16), 24045,'aa'],
          [new Date(2314, 2, 17), 35022,'aa'],
          [new Date(2314, 2, 18), 12284,'aa'],
          [new Date(2314, 2, 19), 8476,'aa'],
          [new Date(2314, 2, 20), 0, 'Lalibertines']*/
		   <?php
		  $q="SELECT Data_inizio,Nome,Utenti_attivi,count(Giocate.Puntata) as Giocanti,Sede from Competizione join Giocate on Giocate.Competizione_Id_competizione=Competizione.Id_competizione where Competizione.Inizio_formazione<'$data' group by Competizione.Id_competizione order by Competizione.Inizio_formazione";
				$t=mysql_query($q,$connessione); 	
				$Dati="";
				while($r=mysql_fetch_object($t)){	
					if ($Dati!= "") $Dati=$Dati.",";
					
					$val=round(($r->Giocanti/$r->Utenti_attivi)*100,2);
					list($anno,$mese,$giorno) = explode('-',$r->Data_inizio);
					
					$Dati=$Dati."[new Date('".$anno.",".$mese.",".$giorno."'),".$val.",'".$r->Sede."']";				
				}
				echo $Dati;
			?>
        ]);

        var chart = new google.visualization.AnnotationChart(document.getElementById('det_schedina'));

        var options = {
          displayAnnotations: true
        };

        chart.draw(data, options);
      }
    </script>

    <script>
function Espandi(div){	
	if (document.getElementById(div).style.display=='block'){
		document.getElementById(div).style.display='none';	}
	else{
		document.getElementById(div).style.display='block';}
}
</script>



<script type="text/javascript" src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1','packages':['annotationchart']}]}"></script>
    <script type='text/javascript'>
      google.load('visualization', '1', {'packages':['annotationchart']});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('date', 'Date');
        data.addColumn('number', '%');
        data.addColumn('string', 'Sede');
       
        data.addRows([
         /* [new Date(2314, 2, 15), 12400,'aa'],
          [new Date(2314, 2, 16), 24045,'aa'],
          [new Date(2314, 2, 17), 35022,'aa'],
          [new Date(2314, 2, 18), 12284,'aa'],
          [new Date(2314, 2, 19), 8476,'aa'],
          [new Date(2314, 2, 20), 0, 'Lalibertines']*/
		   <?php
		    $q="SELECT Data_inizio,Nome,Utenti_attivi,count(DISTINCT Team.Giocatore_id_giocatore) as Giocanti,Sede from Competizione 
join Iscritti on Iscritti.Competizione_Id_competizione=Competizione.Id_competizione 
join Team on Iscritti.Id_iscritti=Team.Iscritti_id_iscritti
where Competizione.Inizio_formazione<'$data' group by Competizione.Id_competizione order by Competizione.Inizio_formazione";
				$t=mysql_query($q,$connessione); 	
				$Dati="";
				while($r=mysql_fetch_object($t)){	
					if ($Dati!= "") $Dati=$Dati.",";
					
					$giocanti=$r->Giocanti;
					if ($r->Nome=="Brixia Meeting")
						$giocanti=48;
					if ($r->Nome=="Campionati Italiani Junior/Promesse")
						$giocanti+=9;
						
					$val=round(($giocanti/$r->Utenti_attivi)*100,2);
					list($anno,$mese,$giorno) = explode('-',$r->Data_inizio);
					
					$Dati=$Dati."[new Date('".$anno.",".$mese.",".$giorno."'),".$val.",'".$r->Sede."']";				
				}
				echo $Dati;
			?>
        ]);

        var chart = new google.visualization.AnnotationChart(document.getElementById('det_fanta'));

        var options = {
          displayAnnotations: true
        };

        chart.draw(data, options);
      }
    </script>

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
       
        <h1>Dettagli percentuali</h1>
        <br/>
        <h3>Dettagli andamento schedina</h3>
        
		<div id='det_schedina' style="width: 100%; height: 350px; z-index:1000;"></div>
        <h3>Dettagli andamento Fantatletica</h3>
        <div id='det_fanta' style="width: 100%; height: 350px; z-index:1000;"></div>
        
       <br/>
        <br/>
        <br/>
	</div>
</body>
</html>

 
    