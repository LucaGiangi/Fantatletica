<?php
$page_name = "schedina";
//versione 4.1 responsitive
session_start();

/*$data = date ("Y-m-d");*/
$data = date("Y/m/d G:i:s");
$id_comp=$_GET['id']; /* usato per capire quando devo stampare il riepilogo della schedina ATTIVO= false */

include "../db.inc";

include "../php/formatta_data.php"; 
// header('Location:Thank_you.php');
$Errore ="";

include "../php/invio_mail.php";
//session_start();

include '../php/Gestione_token.php';
include '../php/verifica_accesso_g.php';
include "../php/logout.php";
include '../php/check_admin.php';
global $g_nome;


$g_id_letto=$_GET['id_giocatore'];
/*if(isset($_COOKIE[$C_token])){ 
	getInfo($_COOKIE[$C_token]);
}*/

$Inserzione_precedente=false;
$modifica= false;


/* verifica che ci siano schedine da giocare */
// verifica disponibilità gara

$ATTIVO= false; /* indica lo stato della schedina. =true quando posso modificare la schedina. usato per bloccare la schedina quando visualizatta per riepilogo */
$Risultati= array(); /* array con risultati della schedina */
$Stato_classifica = false; /* quando lo Stato_classifica = Ufficiale allora posso mostrare i risultati e Stato_classifica = true */
$Header_logo="";
			$q="SELECT * FROM Competizione JOIN Schedina on Schedina.Competizione_Id_competizione=Competizione.Id_competizione where Id_competizione='".$id_comp."'";	
			 $t=mysql_query($q,$connessione); 	
			 while($r=mysql_fetch_object($t)){
				$Id_competizione=$r->Id_competizione;
				$nome_competizione=$r->Nome;
				$sede_comeptizione=$r->Sede;
				$Risultati = explode(",",$r->Risultati);
				$Header_logo=$r->Header_link;
				if ($r->Stato_classifica=="Ufficiale")	$Stato_classifica=true;
			 }
		

$Giocata= array();
if ($ATTIVO || $id_comp!=""){
		$q="select Puntata from Giocate where (Giocatore_Id_giocatore='".$g_id_letto."' and Competizione_Id_competizione='".$Id_competizione."')";
	$t=mysql_query($q,$connessione); 	
	while($r=mysql_fetch_object($t)){
		$Giocata = explode(",",$r->Puntata);}
}
?>
<!doctype html>
<html lang="it-IT">
<head>
<meta charset="utf-8">

<meta http-equiv="x-ua-compatible" content="IE=edge" />
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-touch-fullscreen" content="yes">

 <script src="../script/jquery-1.11.1.min.js"></script>

<link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon"/>
<link rel="icon" href="../images/favicon.ico" type="image/x-icon"/>

<meta property="og:type" content="website" />
<meta property="og:image" content="http://www.fantatletica.it/images/facebookcover.jpg"/>
<meta property="og:url" content="http://www.fantatletica.it/Schedina.php"/>
<meta property="og:title" content="Schedina - Fantatletica" />
<meta property="og:description" content="Nuova schedina FANTATLETICA" />
    
<link type="text/css" media="all" href="../css/style.css" rel="stylesheet" />

<link rel="stylesheet" href="../css/schedina.css" type="text/css" media="screen" />
<link rel="stylesheet" href="../css/input.css" type="text/css" media="screen" />
<link rel="stylesheet" href="../css/tabelle.css" type="text/css" media="screen" />
<link type="text/css" media="all" href="../css/new_mobile.css" rel="stylesheet" />
<link type="text/css" media="all" href="Acss.css" rel="stylesheet" />
<meta name="robots" content="noindex">
<meta name="googlebot" content="noindex">
    
<title>Admin - Fantatletica</title>
</head>

<?php include '../php/header4_0.php';?>  
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
	 
	if ($Inserimento=="ok")
		if ($modifica)
			print'<div class="ok"><img src="images/ok.png" /><login><hh3>Schedina modificata con successo</hh3></login></div><br/><br/>';
		else
			print'<div class="ok"><img src="images/ok.png" /><login><hh3>Schedina inserita con successo</hh3></login></div><br/><br/>';
	
	if ($Inserzione_precedente)
		print' <div class="errore"><img src="images/no.png" /><login><hh3>Hai gia presentato una schedina per questa gara</hh3></login></div> &Eacute; possibile inserire una sola schedina per competizione!<br/> <br/>';
	
		  ?>
        

    <!-- -->
     <?php
if ($ATTIVO || $id_comp!=""){ //stampa solo se una schedina è attiva   
	//print'<div class="titolo"><hh2>'.$nome_competizione.'</hh2></div>';
	print '<div class="gara">';
	
	print'<div><img class="logo_gara" style="padding-right:20px; padding-bottom:20px;" src="../images/header_gare/'.$Header_logo.'">
			<h1><articolo>'.$nome_competizione.'</articolo></h1>
			<!--<h2><img src="'.$g_avatar.'" width="50"/></h2>-->
			<p>&nbsp;</p><p>&nbsp;</p></div>';       
	
/*	if (isset($_COOKIE[$C_token])){
		print'<br/>Stai giocando come';
		
		print  '<h2><img src="'.$g_avatar.'" width="50"/>'; 
	
		print " ".	$g_nome."</h2>";
	}*/
	 
	print'<div class="button-holder"><form action="Schedina.php"  method="post">';
            
        // if (isset($_COOKIE[$C_token])){// verifica se è un utente loggato o meno
		//	  print'<input type="hidden" name="Id_giocatore" value="'.$g_id_letto/*$_SESSION['g_id']*/.'">';  
		// }
		// else{
	//print'	<br/><login> <label><hh3>Gioca veloce tramite indirizzo mail</hh3></label></login><login>  <input type="email" value="" required="required" name="Email" placeholder="Indirizzo e-mail" /></login>  <p>Oppure effettua il <a href="login.php"><color_arancio>login al sito</color_arancio></a>';}
		 
	print'<input type="hidden" name="Id_competizione" value="'.$Id_competizione.'"/>'; /* memorizza id schedina*/
	print'<table  class="tab_el schedina img_schedina" style="float: left;">
		<tr>
			<th width="5%" ></th>
			<th class="hidden_gara" width="5%" >Gara</th>
			<th width="60%">Scontro</th>
			<th width="30%" colspan="3" >Giocata</th>
		</tr>';

	
	$Giocate_vinte=0; // conta pronostici azzeccati
	$Giocate_calcolate=0; //calcola giocate valide


	$array_giocate = array();
	$q="SELECT * FROM Schedina where Competizione_Id_competizione='".$Id_competizione."'";
	$t=mysql_query($q,$connessione); 	
	while($r=mysql_fetch_object($t)){		
		$array_giocate[1]=$r->Giocata1;
		$array_giocate[2]=$r->Giocata2;
		$array_giocate[3]=$r->Giocata3;
		$array_giocate[4]=$r->Giocata4;
		$array_giocate[5]=$r->Giocata5;
		$array_giocate[6]=$r->Giocata6;
		$array_giocate[7]=$r->Giocata7;
		$array_giocate[8]=$r->Giocata8;
		$array_giocate[9]=$r->Giocata9;
		$array_giocate[10]=$r->Giocata10;
		$array_giocate[11]=$r->Giocata11;
		$array_giocate[12]=$r->Giocata12;
		$array_giocate[13]=$r->Giocata13;
		$array_giocate[14]=$r->Giocata14;
		$array_giocate[15]=$r->Giocata15;
		$array_giocate[16]=$r->Giocata16;
		$array_giocate[17]=$r->Giocata17;
		$array_giocate[18]=$r->Giocata18;}
	
	$riga = false;          
	for($i=1;$i<19;$i++){
		$Gara_scontro = array();
		$Gara_scontro = explode(":",$array_giocate[$i]);
		$riga=!$riga;
		if ($i==14)
			print'</table><h3>&nbsp;</h3><table class="tab_el schedina" style="float: left;">
				<tr >
					<th width="5%"></th>
					<th class="hidden_gara" width="5%" >Gara</th>
					<th width="60%">Riserve</th>
					<th width="30%" colspan="3" >Giocata</th>
				</tr>';
	
	if ($g_id_letto=="")
		if ($riga){print '<tr class="pari">';} else {print '<tr class="dispari">';} /* stampa la schedina senza risultati */
	else{
		/* calcola partite conteggiate e vinte */
		if ($Giocate_calcolate<13) 	
			   if ($Risultati[$i-1]!='NP'){ // verifica che la giocata sia valida
					$Giocate_calcolate++;	
					if ($Risultati[$i-1]==$Giocata[$i-1])
						$Giocate_vinte++;
				}
		print '<tr ';
		if ($Risultati[$i-1]=='NP')print'class="puntatanulla"';if ($Risultati[$i-1]==$Giocata[$i-1])print'class="puntataok"';if ($Risultati[$i-1]!=$Giocata[$i-1]) print'class="puntataerrore"'; 
		print '>';
	}
	print'<td style="text-align:center;" >'.$i.'</td>
		<td class="hidden_gara" style="text-align:center;">'.$Gara_scontro[0].'</td>
		<td>'.$Gara_scontro[1].'</td>

		<td>
			<input required '; if (!$ATTIVO) print 'disabled';  print ' type="radio" id="radio-'.$i.'-1" name="radio-'.$i.'-set" value="1" class="regular-radio big-radio" '; if ($Giocata[$i-1]=='1') print 'checked'; print'/>
			<label for="radio-'.$i.'-1">1</label>
		</td>
		<td>
			<input type="radio"'; if (!$ATTIVO) print 'disabled';  print ' id="radio-'.$i.'-2" name="radio-'.$i.'-set" value="X" class="regular-radio big-radio" '; if ($Giocata[$i-1]=='X') print 'checked'; print' />
			<label for="radio-'.$i.'-2">X</label>
		</td>
		<td>
			<input type="radio"'; if (!$ATTIVO) print 'disabled';  print ' id="radio-'.$i.'-3" name="radio-'.$i.'-set" value="2" class="regular-radio big-radio"' ; if ($Giocata[$i-1]=='2') print 'checked'; print' />
			<label for="radio-'.$i.'-3">2</label>
		</td>
</tr>';			   
	}

		// print' <tr><td></td><td><span class="">Schedina realizzata da</span></td><td colspan="3"> <img  src="images/Fede.png" /></td></tr> 
	print'</table><br/>';
	if ($ATTIVO) 
		print'<input type="hidden" name="conferma" value="ok"/>
			<gioca><input type="submit" class="Invio" name="Invio" value=" " /></gioca>';
	else{ /* mostra risultati solo se la classifica è ufficiale */
		if ($Stato_classifica){
			if ($Giocate_vinte==13)
				print '<h2>Complimenti hai totalizzato 13!!</h2>';
			else
				print '<h2>Hai totalizzato '; print $Giocate_vinte.' punti.</h2>';
		}
	}
	print '</form></div></div>';

}else{//mostra prossime schedine
	header('Location:g-home.php');
	}
?>
     <!--	<p><div class="fb-share-button" data-href="http://www.fantatletica.it/Schedina.php" data-layout="button"></div></p>-->
      		
    	</div>
    </div>
</div>
<?php include '../php/footer4_0.php';?>  
<!--  <script type="text/javascript" src="http://www.atletipercaso.net/wp-content/themes/Iris/scripts/snap.min.js"></script>-->
<script src="../script/swipe.js"></script>  

<!--
SELECT Cognome,Nome,count(`Iscritti_Id_iscritti`) as Giocato_n_volte 
FROM `Team` JOIN Iscritti on `Iscritti_Id_iscritti`=Iscritti.Id_iscritti
JOIN Atleti on Iscritti.Atleti_id_atleti=Atleti.Id_atleta where Iscritti.Competizione_id_competizione =7 group by `Iscritti_Id_iscritti` order by Giocato_n_volte desc -->