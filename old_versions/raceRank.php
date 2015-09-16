<?php
$page_name = "raceRank";
//versione 4.1 responsitive
include "db.inc";
/*include 'php/Gestione_token.php';


include 'php/verifica_accesso_g.php';*/

include "php/formatta_data.php";
global $g_nome;
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
<meta property="og:url" content="http://www.fantatletica.it/raceRank.php"/>
<meta property="og:title" content="Classifica - Fantatletica" />
<meta property="og:description" content="Uscita la classifica del Brixia Meeting!" />
    
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
/*	if (isset($_COOKIE[$C_token])){
		print'<br/>Ciao';
		print  '<h2><img src="'.$g_avatar.'" width="50"/>'; 
		print " ".$g_nome."</h2>";
	 }
	*/	 
$q="SELECT * FROM Competizione where Id_competizione='".$_GET['id']."'";		
$t=mysql_query($q,$connessione); 	
while($r=mysql_fetch_object($t)){
	print'<img class="logo_gara" src="images/header_gare/'.$r->Header_link.'">
			<h1><articolo>&nbsp;Classifica '.$r->Nome.'</articolo></h1>
			<h2>&nbsp;'.formatta_data($r->Data_fine).'</h2>';
	
}
print'
	<p></p>        
	<table  class="tab_el schedina">
		<tr>
			<th width="10%" >Rank</th>
			<th width="60%">Nome</th>
			<th width="30%" colspan="3" >Punti</th>
		</tr>';    
         
$i=1;
$q="SELECT Id_giocatore,Punti,Nome_team FROM Giocatore where status='1' and Punti>0  order by Punti desc,Costo_team,N_team";
	//$q="SELECT Id_giocatore,Punti,Nome_team FROM Giocatore where status='1' and Punti>0 and (Stringa LIKE '%Allievi%' or Stringa LIKE '%Allieve%') order by Punti desc,Costo_team,N_team ";
	
$t=mysql_query($q,$connessione); 
while($r=mysql_fetch_object($t) ){	
	$riga=!$riga;	
		
	if ($g_nome==$r->Nome_team)/*$_SESSION['g_user']*/
		{print '<tr class="evidenzia">';}
	else
		if ($riga){print '<tr class="pari">';} else {print '<tr class="dispari">';}
		//print ($p[$i][username]);
	print '<td style="text-align:center">';
	if ($i==1) print '<img  class="gold" src="images/gold.png">'; 
	if ($i==2) print '<img  class="silver" src="images/silver.png">';
	if ($i==3)  print '<img  class="silver" src="images/silver.png">';// print '<img  class="bronze" src="images/bronze.png">';
	
	if ($i>3) print $i."&deg;"; 
	print'</td><td>'.$r->Nome_team.'</td>';
	print '<td style="text-align:center">'.$r->Punti.'</td>';
	print'</tr>';	
	$i++;
}
print' </table></articolo>';	 
?>
     	<p><div class="fb-share-button" data-href="http://www.fantatletica.it/raceRank.php" data-layout="button"></div></p>
        	<!-- </div> -->
    	</div>
    </div>
</div>
<?php include 'php/footer4_0.php';?>  
<!--  <script type="text/javascript" src="http://www.atletipercaso.net/wp-content/themes/Iris/scripts/snap.min.js"></script>-->
<script src="script/swipe.js"></script>    