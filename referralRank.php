<?php
$page_name = "rank";
//versione 4.1 responsitive
include "db.inc";
/*include 'php/Gestione_token.php';

include 'php/verifica_accesso_g.php';*/

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
<meta property="og:url" content="http://www.fantatletica.it/referralRank.php"/>
<meta property="og:title" content="Classifica - Fantatletica" />
<meta property="og:description" content="Chi saranno i primi 50 ad avere accesso esclusivo a Fantatletica? Hai tempo fino a martedì sera per scalare la classifica!" />
    
<link type="text/css" media="all" href="css/style.css" rel="stylesheet" />
<link type="text/css" media="all" href="css/new_mobile.css" rel="stylesheet" />
<link rel="stylesheet" href="css/schedina.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/input.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/tabelle.css" type="text/css" media="screen" />
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

	
		 
	print'Classifica provvisoria.<p> Hai tempo fino a marted&igrave; per invitare nuovi amici e scalare posizioni.</br> Fai <color_arancio><a href="http://www.fantatletica.it/login.php">login</a></color_arancio> per avere maggiori informazioni </p>
            <table  class="tab_el schedina">
            <tr><th width="10%" >Rank</th>
			<th width="60%">Nome</th>
			<th width="30%" colspan="3" >Refferals</th>
			</tr>';    
         
	/*  leggi dati da API AxC */
		$uri = '/API/v1/referralRank.php'; 
		$sito = 'www.atletipercaso.net'; 	
		$query = ''; //valori post 
		
		if (!($sock = fsockopen($sito,80))) die ("Errore connessione\n"); 
		
		fputs ($sock, 
		  "POST $uri HTTP/1.1\r\n". 
		  "Host: $sito\r\n". 
		  "Content-Type: application/x-www-form-urlencoded\r\n". 
		  "Content-Length: ".strlen($query)."\r\n". 
		  "Connection: close\r\n\r\n". 
		  $query."\r\n"); 
		
		$out = ""; 
		while (!feof($sock)) 
		  $out.=fgets($sock); 
		
		fclose($sock); 
		$o = explode("\r\n\r\n", $out);  /* esplodi risposta per eliminare header */
		$o1 = explode("\r\n",$o[1]); /* esplodi risposta per valiri iniziali e finali inutili */	

		$j ='['.$o1[1].']';

		$json_o=json_decode($j,true); /* decodifico json */
		
		foreach($json_o as $p){	
				for ($i=1;$i<51;$i++){
					$riga=!$riga;	
					if ($riga){print '<tr class="pari">';} else {print '<tr class="dispari">';}
					//print ($p[$i][username]);
					print '<td style="text-align:center">'.$i.'&deg;</td><td>'.($p[$i][username]).'</td>';
					if ($i>3) print'<td></td>'; else print '<td style="text-align:center">'.($p[$i][referrals]).'</td>';
					print'</tr>';		
				}
		}
		print' </table></articolo>';	 
	 ?>
     	<p><div class="fb-share-button" data-href="http://www.fantatletica.it/referralRank.php" data-layout="button"></div></p>
        	<!-- </div> -->
    	</div>
    </div>
</div>
<?php include 'php/footer4_0.php';?>  
<!--  <script type="text/javascript" src="http://www.atletipercaso.net/wp-content/themes/Iris/scripts/snap.min.js"></script>-->
<script src="script/swipe.js"></script>    