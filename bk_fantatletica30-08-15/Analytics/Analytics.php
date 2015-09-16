<?php
$page_name = "Analytics";
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
		google.load("visualization", "1.1", {packages:["bar"]});
		google.setOnLoadCallback(Schedina_giocatori);
		function Schedina_giocatori() {
			var data = google.visualization.arrayToDataTable([
				['Competizione', 'Giocatori Attivi', 'Giocatori giocanti'],
			<?php
			
				$q="SELECT Nome,Utenti_attivi,count(Giocate.Puntata) as Giocanti from Competizione join Giocate on Giocate.Competizione_Id_competizione=Competizione.Id_competizione where Competizione.Inizio_formazione<'$data' group by Competizione.Id_competizione order by Competizione.Inizio_formazione";
				$t=mysql_query($q,$connessione); 	
				$Dati="";
				while($r=mysql_fetch_object($t)){	
					if ($Dati!= "") $Dati=$Dati.",";
					
					$val=round(($r->Giocanti/$r->Utenti_attivi)*100,2);
					$Dati=$Dati."['".$r->Nome." %".$val."',".$r->Utenti_attivi.",".$r->Giocanti."]";
					$S_tot_utenti+=$r->Utenti_attivi; /* calcola % totale */
					$S_tot_Giocatori+=$r->Giocanti;
					
					if ($S_per_max<$val) $S_per_max=$val;
					if ($S_per_min>$val) $S_per_min=$val;
					
				}
				echo $Dati;
			?>
			]);

			var options = {
			chart: {
				title: '% Giocatori',
				subtitle: 'Schedina',
			}
		};

		var chart = new google.charts.Bar(document.getElementById('Schedina_giocatori'));
		chart.draw(data, options);
      }
	  </script>
	  <script type="text/javascript">
		google.load('visualization', '1.1', {packages: ['line']});
		google.setOnLoadCallback(AndamentoSchedina);
		
		function AndamentoSchedina() {
		
		  var data = new google.visualization.DataTable();
		  data.addColumn('string', 'Data');
		  data.addColumn('number', 'Percentuale');	
		  data.addRows([
		  <?php
		  $q="SELECT Data_inizio,Nome,Utenti_attivi,count(Giocate.Puntata) as Giocanti from Competizione join Giocate on Giocate.Competizione_Id_competizione=Competizione.Id_competizione where Competizione.Inizio_formazione<'$data' group by Competizione.Id_competizione order by Competizione.Inizio_formazione";
				$t=mysql_query($q,$connessione); 	
				$Dati="";
				while($r=mysql_fetch_object($t)){	
					if ($Dati!= "") $Dati=$Dati.",";
					
					$val=round(($r->Giocanti/$r->Utenti_attivi)*100,2);
					$Dati=$Dati."['".formatta_data($r->Data_inizio)."',".$val."]";				
				}
				echo $Dati;
			?>
			
		  ]);
		
		  var options = {
			chart: {
			  title: '%',
			  subtitle: 'Schedina'
			}
		
		  };
		
		  var chart = new google.charts.Line(document.getElementById('AndamentoSchedina'));
		
		  chart.draw(data, options);
		}
	</script>
	  
	<script type="text/javascript">
	/* ***************	FANTATLETICA	****** */
     google.setOnLoadCallback(Fanta_giocatori);
		function Fanta_giocatori() {
			var data = google.visualization.arrayToDataTable([
				['Competizione', 'Giocatori Attivi', 'Giocatori giocanti'],
			<?php
			
				$q="SELECT Nome,Utenti_attivi,count(DISTINCT Team.Giocatore_id_giocatore) as Giocanti from Competizione 
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
					$Dati=$Dati."['".$r->Nome." %".$val."',".$r->Utenti_attivi.",".$giocanti."]";
					$F_tot_utenti+=$r->Utenti_attivi; /* calcola % totale */
					$F_tot_Giocatori+=$giocanti;
					
					if ($F_per_max<$val) $F_per_max=$val;
					if ($F_per_min>$val) $F_per_min=$val;
				}
				echo $Dati;
			?>
			]);

			var options = {
			chart: {
				title: '% Giocatori',
				subtitle: 'Fantatletica',
			}
		};

		var chart = new google.charts.Bar(document.getElementById('Fanta_giocatori'));
		chart.draw(data, options);
      }
	</script>
    <script type="text/javascript">
		google.load('visualization', '1.1', {packages: ['line']});
		google.setOnLoadCallback(AndamentoFanta);
		
		function AndamentoFanta() {
		
		  var data = new google.visualization.DataTable();
		  data.addColumn('string', 'Data');
		  data.addColumn('number', 'Percentuale');	
		  data.addRows([
		  <?php
		  $q="SELECT Data_inizio,Nome,Utenti_attivi,count(DISTINCT Team.Giocatore_id_giocatore) as Giocanti from Competizione 
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
						$Dati=$Dati."['".formatta_data($r->Data_inizio)."',".$val."]";
					
				}
				echo $Dati;
			?>
			
		  ]);
		
		  var options = {
			chart: {
			  title: '%',
			  subtitle: 'Fantatletica'
			}
		
		  };
		
		  var chart = new google.charts.Line(document.getElementById('AndamentoFanta'));
		
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
        
        <h1>Statistiche gicatori</h1>
        <br/>
        <h3>Schedina</h3>
        <div id="Schedina_giocatori" style="width:100%; height: 500px;"></div>
        <div id="AndamentoSchedina" style="width:100%; height: 300px;"></div>
       	<a href="Analytics_details.php">Dettagli...</a>
        
        <h3>Fantatletica</h3>
        <div id="Fanta_giocatori" style="width:100%; height: 500px;"></div>
        <div id="AndamentoFanta" style="width:100%; height: 300px;"></div>
        <a href="Analytics_details.php">Dettagli...</a>
		
        <br/>
		<br/>
        
        <div onclick="Espandi('uno')"><h2>Statistiche sul totali<img class="espandi" style="top:0px;" src="../images/freccia_1.png"></h2></div>
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

 
    