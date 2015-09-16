<?php
$page_name = "Track_schedina";
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



<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
      var data = new google.visualization.DataTable();
        data.addColumn('date', 'Data');
        data.addColumn('number', 'Ora');

       // data.addRows([
          //[0, 67], [1, 88], [2, 77]
		 data.addRows([
		  <?php
		    $q="SELECT Time from Giocate where Time!=''";
				$t=mysql_query($q,$connessione); 	
				$Dati="";
				$time="";
				$date="";
				while($r=mysql_fetch_object($t)){	
					if ($Dati!= "") $Dati=$Dati.",";
					list ($date,$time)=explode(" ",$r->Time);

					list($anno,$mese,$giorno) = explode('-',$date);
					list($ora,$min,$sec)= explode(':',$time);
					
					$Dati=$Dati."[new Date(".$anno.",".$mese.",".$giorno."),".$ora."]";				
				}
				echo $Dati;
			?>
        //  [ new Date(2314, 2, 15),      12],
        //  [ new Date(2314, 4, 15),      5.5],
        //  [ new Date(2314, 5, 15),     14],
        //  [ new Date(2314, 3, 15),      5]
         
        ]);

        var options = {
          title: 'Invio schedina',
          legend: 'none'
        };

        var chart = new google.visualization.ScatterChart(document.getElementById('chart_div'));

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
       
        <h1>Data e ora invio schedine</h1>
        <br/>

		<div id="chart_div" style="width: 100%; height: 350px; z-index:1000;"></div>
        
       <br/>
        <br/>
        <br/>
	</div>
</body>
</html>

 
    