<?php
$page_name = "Analytics_v1";
//versione 4.1 responsitive

//($_SESSION['id_competizione']!=-1)  usato per verificare la possibilità di modificare la squadra
session_start();

/*$data = date ("Y-m-d");*/
$data = date("Y/m/d G:i:s");
$data_1 = date("Y/m/d");
include "../db.inc";
include "../php/formatta_data.php"; 

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
      google.load('visualization', '1.1', {'packages':['annotationchart']});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('date', 'Date');
        data.addColumn('number', '%');
        data.addColumn('string', 'Competizione');
        data.addRows([
        /*  [new Date(2314, 2, 15), 12400, undefined, undefined,
                                  10645, undefined, undefined],
          [new Date(2314, 2, 16), 24045, 'Lalibertines', 'First encounter',
                                  12374, undefined, undefined],
          [new Date(2314, 2, 17), 35022, 'Lalibertines', 'They are very tall',
                                  15766, 'Gallantors', 'First Encounter'],
          [new Date(2314, 2, 18), 12284, 'Lalibertines', 'Attack on our crew!',
                                  34334, 'Gallantors', 'Statement of shared principles'],
          [new Date(2314, 2, 19), 8476, 'Lalibertines', 'Heavy casualties',
                                  66467, 'Gallantors', 'Mysteries revealed'],
          [new Date(2314, 2, 20), 0, 'Lalibertines', 'All crew lost',
                                  79463, 'Gallantors', 'Omniscience achieved']*/
								  <?php
		  $q="SELECT Data_inizio,Nome,Utenti_attivi,count(Giocate.Puntata) as Giocanti from Competizione join Giocate on Giocate.Competizione_Id_competizione=Competizione.Id_competizione where Competizione.Termine_formazione<'$data_1' group by Competizione.Id_competizione order by Competizione.Inizio_formazione";
				$t=mysql_query($q,$connessione); 	
				$Dati="";
				while($r=mysql_fetch_object($t)){	
					if ($Dati!= "") $Dati=$Dati.",";
					
					$val=round(($r->Giocanti/$r->Utenti_attivi)*100,2);
					$Dati=$Dati."['".$r->Data_inizio."',".$val.",'".$r->Sede."']";				
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

</head>

<body style="background-color:#FFF;">

    <div id="head" style="left:0px;">
        <a href="index.php"><h1><img alt="menu_dx" id="logo_img" src="../images/logo_m.png"></h1></a> 
    </div>
    
    <div style="height:70px; width:100%;"></div>
    
    <div style="margin:0 auto; width:95%;">
    
        <div id='cssmenu'>
            <ul>
               <li><a href='Analytics.php'>Giocatori</a></li>        
               <li><a href='Analytics_TrackActionF.php'>Composizione team</a></li>
               <li><a href='Analytics_TrackActionS.php'>Composizione schedina</a></li>
            </ul>
        </div>
        <br/>
        <h1>Statistiche gicatori</h1>
        <br/>
        <h2>Dettagli andamento schedina</h2>
        
		<div id='det_schedina' style="width: 700px; height: 240px; z-index:1000;"></div>
        <h3>Dettagli andamento Fantatletica</h3>
        <div id='det_fanta' style="width: 700px; height: 240px; z-index:1000;"></div>
        
       <br/>
        <div onclick="Espandi('uno')"><h2>Dettagli<img class="espandi" style="top:0px;" src="../images/freccia_1.png"></h2></div>
        <div class="nascondi_testo" id="uno">
            <table class="tab_el" width="50%"> <th></th><th>Fantatletica</th><th>Schedina</th>
                <tr class="pari"><td>Percentuale sul totale</td><td><?php print round(($F_tot_Giocatori/$F_tot_utenti)*100,2); ?>%</td><td><?php print round(($S_tot_Giocatori/$S_tot_utenti)*100,2); ?>%</td></tr>
                
                <tr class="dispari"><td>Percentuale minima</td><td><?php print $F_per_min; ?>%</td><td><?php print $S_per_min; ?>%</td></tr>
                <tr class="pari"><td>Percentuale massima</td><td><?php print $F_per_max; ?>%</td><td><?php print $S_per_max; ?>%</td></tr>
            </table>
        </div>
        
        <br/>
        <br/>
	</div>
</body>
</html>

 
    