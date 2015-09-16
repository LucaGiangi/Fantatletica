<?php
$page_name = "schedinaRank";
//versione 4.1 responsitive
include "db.inc";
/*include 'php/Gestione_token.php';


include 'php/verifica_accesso_g.php';*/
$id_comp =$_GET['id'];

include "php/formatta_data.php"; 

global $g_nome;
$Header_logo="";
$nome_competizione="";
$data_fine="";

/* carica struttura per classifica schedina */
$posizione= array(); /* in posizione n ci stanno quelli che hanno totalizzato n punti */

for ($i=0;$i<14;$i++)
	$posizione[$i]=array();


function ContaPunti($Puntata,$Risultati){
	$vet_puntata = array();
	$vet_risultati = array();	
	$vet_puntata = explode(",",$Puntata);
	$vet_risultati = explode(",",$Risultati);
	
	$Giocate_vinte=0; // conta pronostici azzeccati
	$Giocate_calcolate=0; //calcola giocate valide
	
	for($i=0;$i<18;$i++){
		
		if ($Giocate_calcolate<13) 	
			   if ($vet_risultati[$i]!='NP'){ // verifica che la giocata sia valida
					$Giocate_calcolate++;	
					if ($vet_puntata[$i]==$vet_risultati[$i])
						$Giocate_vinte++;
				}	
	}
	return $Giocate_vinte; /* ritorna puntate vinete */
}	
/* leggi risultati */
$ok_gara=false;			/* indica se la gara è stata trovata */
$ok_classifica=false;	/* indica se i risultati sono visibili */

if ($id_comp!=""){
	
	$q="select * from Competizione where Id_competizione='".$id_comp."'";
		
	$t=mysql_query($q,$connessione); 
	while($r=mysql_fetch_object($t)){
		$Header_logo=$r->Header_link;
		$nome_competizione=$r->Nome;
		$data_fine=$r->Data_fine;
		$ok_gara= true;
	}

	if ($ok_gara){	
		$q="select Giocate.Puntata,Giocate.Giocatore_Id_giocatore,Schedina.Risultati,Giocatore.Nome_team from Giocate JOIN Schedina on Giocate.Competizione_Id_competizione=Schedina.Competizione_Id_competizione JOIN Giocatore on Giocatore.Id_giocatore=Giocate.Giocatore_Id_giocatore where Giocate.Competizione_Id_competizione='".$id_comp."' ";
			//print $q;
		$t=mysql_query($q,$connessione); 
		while($r=mysql_fetch_object($t)){	
			$ok_classifica= true;	
			$posizione[ContaPunti($r->Puntata,$r->Risultati)][]= $r->Nome_team;
		}
	}
}
/*print $id_comp;
print $q*/
?>
<!doctype html>
<html lang="it-IT">
<head>
<meta charset="utf-8">

<meta http-equiv="x-ua-compatible" content="IE=edge" />
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-touch-fullscreen" content="yes">

<script src="script/jquery-1.11.1.min.js"></script>

<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon"/>
<link rel="icon" href="images/favicon.ico" type="image/x-icon"/>

<meta property="og:type" content="website" />
<meta property="og:image" content="http://www.fantatletica.it/images/facebookcover.jpg"/>
<meta property="og:url" content="http://www.fantatletica.it/schedinaRank.php"/>
<meta property="og:title" content="Classifica - Fantatletica" />
<meta property="og:description" content="Risultati schedina Fantatletica" />
    
<link type="text/css" media="all" href="css/style.css" rel="stylesheet" />

<link rel="stylesheet" href="css/schedina.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/input.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/tabelle.css" type="text/css" media="screen" />
<link type="text/css" media="all" href="css/new_mobile.css" rel="stylesheet" />
<title>Classifica - Fantatletica</title>
</head>

<?php include 'php/header4_0.php';?>  
<!-- condividi fb -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/it_IT/sdk.js#xfbml=1&version=v2.3";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<!--  body info -->
<div class="body_info">
	<div class="call_action_contenuto">
    	<div class="contenuto_centro">

<?php	 

print ' <div class="gara">';
$k=1;
$int_c=0;
if ($ok_gara && $ok_classifica){ /* è stata trovata una gara */
	print'<img class="logo_gara" style="padding-right:20px;  padding-bottom:20px;" src="images/header_gare/'.$Header_logo.'">
		<h1>Risultati</h1>
		<h2><articolo>'.$nome_competizione.'</articolo></h2>
		<h3>'.formatta_data($data_fine).'</h3>
		<p></p>         
		<table  class="tab_el schedina">
		<tr>
			<th width="10%" >Rank</th>
			<th width="60%">Nome</th>
			<th width="30%" colspan="3" >Pronostici vinti</th>
		</tr>';    
			
	for($i=13;$i>=0;$i--){
		
		for($j=0;$j<count($posizione[$i]);$j++){
			$riga=!$riga;				
			if ($riga){print '<tr class="pari">';} else {print '<tr class="dispari">';}	
			print '<td style="text-align:center">';
			/*if ($i==13) print '<img  class="gold" src="images/gold.png">'; 
			if ($i==12) print '<img  class="silver" src="images/silver.png">';
			if ($i==11) print '<img  class="bronze" src="images/bronze.png">';
			if ($i<11)*/ print $k."&deg;"; 
			print'</td><td>'.$posizione[$i][$j].'</td>';
			print '<td style="text-align:center">'.$i.'</td>';
			print'</tr>';
		}
		
		if (count($posizione[$i])>0 )$k+=count($posizione[$i]);
		$int_c=0;
	}
	print' </table></articolo>';
}
else{ /* se non esiste una gara o se la classifica non è ufficiale torno alla pagina home giocatore */
	header('Location:g-home.php');
}
?>
     	<p><div class="fb-share-button" data-href="http://www.fantatletica.it/schedinaRank.php" data-layout="button"></div></p>
        	<!-- </div> -->
    	</div>
    </div>
</div>
<?php include 'php/footer4_0.php';?>  
<!--  <script type="text/javascript" src="http://www.atletipercaso.net/wp-content/themes/Iris/scripts/snap.min.js"></script>-->
<script src="script/swipe.js"></script>    