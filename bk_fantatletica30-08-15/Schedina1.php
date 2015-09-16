<?php
$page_name = "OpenSchedina";
//versione 4.1 responsitive
session_start();

/*$data = date ("Y-m-d");*/
$data = date("Y/m/d G:i:s");
$id_comp=$_GET['id']; /* usato per capire quando devo stampare il riepilogo della schedina ATTIVO= false */

include "db.inc";

include "php/formatta_data.php"; 
// header('Location:Thank_you.php');
$Errore ="";

include "php/invio_mail.php";
//session_start();

//include 'php/Gestione_token.php';
//include 'php/verifica_accesso_g.php';
//include "php/logout.php";
global $g_nome;
global $g_id;

/*if(isset($_COOKIE[$C_token])){ 
	getInfo($_COOKIE[$C_token]);
}*/

$Inserzione_precedente=false;
$modifica= false;

function email_exist($email) {
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) return false;
  elseif (!checkdnsrr(array_pop(explode('@',$email)),'MX')) return false;
  else return true;
}


/* destinatari */
$destinatari  = '<'.$_POST['Email'].'>'; // notare la virgola


/* oggetto */
$oggetto = "#Fantatletica";

/* messaggio */
$messaggio = '
<html>
<head>
 <title>Promemoria compleanni di Agosto</title>
</head>
<body>
<p>Questi sono i compleanni di Agosto!</p>
<table>
 <tr>
  <th>Persona</th><th>Giorno</th><th>Mese</th><th>Anno</th>
 </tr>
 <tr>
  <td>Walter</td><td>11</td><td>Agosto</td><td>1946</td>
 </tr>
 <tr>
  <td>Sara</td><td>14</td><td>Agosto</td><td>1985</td>
 </tr>
</table>
</body>
</html>
';

/* Per inviare email in formato HTML, si deve impostare l'intestazione Content-type. */
$intestazioni  = "MIME-Version: 1.0\r\n";
$intestazioni .= "Content-type: text/html; charset=iso-8859-1\r\n";

/* intestazioni addizionali */
$intestazioni .= "To: ".'<'.$_POST['Email'].'>'."\r\n";
$intestazioni .= "From: atletipercaso.net <info@atletipercaso.net>\r\n";
$intestazioni .= "Cc: fantatletica.it\r\n";
$intestazioni .= "Bcc: fantatletica.it\r\n";

/* ed infine l'invio */





if (($_POST['Invio']==' ') and ($_POST['conferma']=='ok')){	
	/* leggi dati dal form */
	$arrayletto = array();
	$arrayletto[1]= $_POST['radio-1-set'];
	$arrayletto[2]= $_POST['radio-2-set'];
	$arrayletto[3]= $_POST['radio-3-set'];
	$arrayletto[4]= $_POST['radio-4-set'];
	$arrayletto[5]= $_POST['radio-5-set'];
	$arrayletto[6]= $_POST['radio-6-set'];
	$arrayletto[7]= $_POST['radio-7-set'];
	$arrayletto[8]= $_POST['radio-8-set'];
	$arrayletto[9]= $_POST['radio-9-set'];
	$arrayletto[10]= $_POST['radio-10-set'];
	$arrayletto[11]= $_POST['radio-11-set'];
	$arrayletto[12]= $_POST['radio-12-set'];
	$arrayletto[13]= $_POST['radio-13-set'];
	$arrayletto[14]= $_POST['radio-14-set'];
	$arrayletto[15]= $_POST['radio-15-set'];
	$arrayletto[16]= $_POST['radio-16-set'];
	$arrayletto[17]= $_POST['radio-17-set'];
	$arrayletto[18]= $_POST['radio-18-set'];
	/* crea stringa da inserire */
	$puntata= $arrayletto[1].",".$arrayletto[2].",".$arrayletto[3].",".$arrayletto[4].",".$arrayletto[5].",".$arrayletto[6].",".$arrayletto[7].",".$arrayletto[8].",".$arrayletto[9].",".$arrayletto[10].",".$arrayletto[11].",".$arrayletto[12].",".$arrayletto[13].",".$arrayletto[14].",".$arrayletto[15].",".$arrayletto[16].",".$arrayletto[17].",".$arrayletto[18];
	
	if(false){ //if ($_SESSION['g_id']!=""){/* inserisci schedina da utente loggato*/ 
		 /* verifico che non sia gia inserita una schedina*/
		 $q="SELECT * FROM Giocate where (Giocatore_Id_giocatore='".$g_id."' and Competizione_Id_competizione='".$_POST['Id_competizione']."')";
		 $t=mysql_query($q,$connessione); 	
		 while($r=mysql_fetch_object($t)){
			 $Inserzione_precedente=true; /* schedina gia inserita */
		 }
		
		if (!$Inserzione_precedente){/* inserisci schedina */
			$q="INSERT into Giocate values ('".$g_id."','".$puntata."','".$_POST['Id_competizione']."','','".$data."')";
			if(!mysql_query($q,$connessione)) 
				$Errore = "Errore di inserimento";
			else
				$Inserimento="ok";
		
		}else{
			/* modifica schedina inserita */
			$q="UPDATE Giocate SET Puntata='".$puntata."',Time='".$data."' where (Giocatore_Id_giocatore='".$g_id."' and Competizione_Id_competizione='".$_POST['Id_competizione']."')";
			
			if(!mysql_query($q,$connessione)) 
				$Errore = "Errore di inserimento";
			else{
				$Inserimento="ok";$modifica=true;$Inserzione_precedente=false;}
		}
	 
	 }else{// if ($_SESSION['g_id']!="")   UTENTE NON REGISTRATO NON GESTITA
	 
	 	/* verifico che la mail esista */
		if (email_exist($_POST['Email'])){
	
			/* modifico la schedina inserita */				
			 /* verifico se esiste gia una mail per questa schedina */
			 $q="SELECT * FROM Giocate where (Mail='".$_POST['Email']."' and Competizione_Id_competizione='".$_POST['Id_competizione']."')";
				 $t=mysql_query($q,$connessione); 	
				 while($r=mysql_fetch_object($t)){
					 $Inserzione_precedente=true; /* schedina gia inserita  */
				 }
				 if (!$Inserzione_precedente){
					$q="INSERT into Giocate values (null,'".$puntata."','".$_POST['Id_competizione']."','".$_POST['Email']."','".$data."')";
					if(!mysql_query($q,$connessione)) 
						$Errore = "Errore di inserimento";
					else
						 $Inserimento="ok";		
				}
		 }else
			$Errore="L&acute;indirizzo mail specificato risulta inesistente. Controllare i dati inseriti e riprovare.Se il problema persiste contattate l&acute;amministratore";
	 }
}

/* verifica che ci siano schedine da giocare */
// verifica disponibilità gara

$ATTIVO= false; /* indica lo stato della schedina. =true quando posso modificare la schedina. usato per bloccare la schedina quando visualizatta per riepilogo */
$Risultati= array(); /* array con risultati della schedina */
$Stato_classifica = false; /* quando lo Stato_classifica = Ufficiale allora posso mostrare i risultati e Stato_classifica = true */
$Header_logo="";

		if ($id_comp==""){
			 $q="SELECT * FROM Competizione where Inizio_formazione<='".$data."' and Termine_formazione>='".$data."' and Type='1' and Id_competizione='18'";	
			 $t=mysql_query($q,$connessione); 	
			 while($r=mysql_fetch_object($t)){
				$Id_competizione=$r->Id_competizione;
				$nome_competizione=$r->Nome;
				$sede_comeptizione=$r->Sede;
				$ATTIVO=true;
				$Header_logo=$r->Header_link;
			 }
		}else{ /* mostro schedina passata come parametro */
			$q="SELECT * FROM Competizione JOIN Schedina on Schedina.Competizione_Id_competizione=Competizione.Id_competizione where Id_competizione='18'";	
			 $t=mysql_query($q,$connessione); 	
			 while($r=mysql_fetch_object($t)){
				$Id_competizione=$r->Id_competizione;
				$nome_competizione=$r->Nome;
				$sede_comeptizione=$r->Sede;
				$Risultati = explode(",",$r->Risultati);
				$Header_logo=$r->Header_link;
				if ($r->Stato_classifica=="Ufficiale")	$Stato_classifica=true;
			 }
		}
/*	 if ($g_id==257)
 $q="SELECT * FROM Competizione where  Type='2' ";
	 $t=mysql_query($q,$connessione); 	
	 while($r=mysql_fetch_object($t)){
		$Id_competizione=$r->Id_competizione;
		$nome_competizione=$r->Nome;
		$sede_comeptizione=$r->Sede;
		$ATTIVO=true;
	 }*/

$Giocata= array();
if ($ATTIVO || $id_comp!=""){
		$q="select Puntata from Giocate where (Giocatore_Id_giocatore='".$g_id."' and Competizione_Id_competizione='".$Id_competizione."')";
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

 <script src="script/jquery-1.11.1.min.js"></script>

<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon"/>
<link rel="icon" href="images/favicon.ico" type="image/x-icon"/>

<meta property="og:type" content="website" />
<meta property="og:image" content="http://www.fantatletica.it/images/facebookcover.jpg"/>
<meta property="og:url" content="http://www.fantatletica.it/Schedina.php"/>
<meta property="og:title" content="Schedina - Fantatletica" />
<meta property="og:description" content="Nuova schedina FANTATLETICA" />
    
<link type="text/css" media="all" href="css/style.css" rel="stylesheet" />

<link rel="stylesheet" href="css/schedina.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/input.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/tabelle.css" type="text/css" media="screen" />
<link type="text/css" media="all" href="css/new_mobile.css" rel="stylesheet" />
<title>Schedina - Fantatletica</title>
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
    	<div class="contenuto_centro" style="margin-top: 80px;">

     <?php
if ($ATTIVO || $id_comp!=""){ //stampa solo se una schedina è attiva   
	//print'<div class="titolo"><hh2>'.$nome_competizione.'</hh2></div>';
	print '<div class="gara">';
	
	print'<div><img class="logo_gara" style="padding-right:20px; padding-bottom:20px;" src="images/header_gare/'.$Header_logo.'">
			<h1><articolo>'.$nome_competizione.'</articolo></h1>
			<!--<h2><img src="'.$g_avatar.'" width="50"/></h2>-->
			<p>&nbsp;</p><br/></div>';       
	
 
	if ($Inserimento=="ok")
		if ($modifica)
			print'<div class="ok"><img src="images/ok.png" /><login><hh3>Schedina modificata con successo</hh3></login></div><br/><br/>';
		else
			print'<div class="ok"><img src="images/ok.png" /><login><hh3>Schedina inserita con successo</hh3></login></div><br/><br/>';
	
	if ($Inserzione_precedente)
		print' <div class="errore"><img src="images/no.png" /><login><hh3>Hai gia presentato una schedina per questa gara</hh3></login></div> &Eacute; possibile inserire una sola schedina per competizione!</hh3><br/> <br/>';
	if ($Errore!="")
		print '<div class="errore"><img src="images/no.png" /><login><hh3>'.$Errore.'</hh3></login></div><br/> <br/>';
	

	print '<div onclick="Espandi()">
                <h1 style="color:rgb(255, 203, 5);">Regolamento<img class="espandi" style="top:0px;" src="images/freccia_1.png"></h1></div>
                <div class="nascondi_testo" id="uno">
				
				
				 <p>Unica regola per vincere la schedina: fare <span class="budget"> 13!</span> </p>
               	<p> Chi riuscirà a prevedere correttamente tutti i pronostici <span class="budget">vincerà l&acute;accesso a tutte le partite del fantatletica</span></p>
          <p>Per ognuno dei 13 pronostici devi scegliere 1, 2, o X. Se scegli l&acute;opzione 1 prevedi che il primo nome indicato sia il vincitore della gara. Se giochi 2 prevedi che &egrave; il secondo nome quello vincente. Se giochi X prevedi che a vincere la gara non sarà nessuno dei due atleti previsti dalla schedina.  Ad esempio:</p>
          
          <p><strong>Delmas Obou</strong> Vs <strong>Michael Tumi</strong>: <strong>1</strong> (vittoria per Obou), <strong>2</strong> (vittoria per Tumi), <strong>X</strong> (non vince nessuno dei due).</p>
		  
          <p>Come facciamo nel caso in cui un&acute;atleta non partisse nella gara in cui &egrave; iscritto? Poich&egrave; abbiamo pensato a tutto, qualora uno degli <color_arancio>scontri previsti non abbia luogo la schedina sarà comunque valida</color_arancio>. Infatti, compilerai altri 5 pronostici in modo che, nel caso in cui non avvenga uno scontro, verrà ripescato il 14&deg; pronostico. Se non ne avverranno due, verranno ripescati il 14&deg; e il 15&deg; e cos&igrave; via fino ad un massimo di 18.</p>
<p>E se un&acute;atleta si ritira durante la gara? Verrà considerato come partito e quindi classificato all&acute;ultimo posto della classifica. </p>
<p>E se un&acute;atleta si qualifica per una finale e poi non la disputa? In quel caso invece si considera come non avvenuto lo scontro e quindi verrà scartato quel pronostico.</p>
                </div>';


	print'<div class="button-holder"><form action="Schedina1.php"  method="post">';

	print'	<br/><login> <label><hh3>Gioca veloce tramite indirizzo mail</hh3></label></login><login>  <input type="email" value="" required="required" name="Email" placeholder="Indirizzo e-mail" /></login> <br/>
	<span><i>In caso di vittoria invieremo il codice di attivazione alla mail specificata.</i></span>
	
	<br/><br/>';
		 
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
	
	if (!$Stato_classifica)
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
	print'<div><img class="logo_gara" style="padding-right:20px; padding-bottom:20px;" src="images/header_gare/Fidal_1.png">
			<h1><articolo>Campionati Italiani Assoluti</articolo></h1>
			<p>&nbsp;</p><br/></div>';
			print 'iscrizioni chiuse';
	}
?>
     <!--	<p><div class="fb-share-button" data-href="http://www.fantatletica.it/Schedina.php" data-layout="button"></div></p>-->
      		
    	</div>
    </div>
</div>
<br/>
<?php include 'php/footer4_0.php';?>  
<!--  <script type="text/javascript" src="http://www.atletipercaso.net/wp-content/themes/Iris/scripts/snap.min.js"></script>-->
<script src="script/swipe.js"></script> 
<script> 
function Espandi(){	

	if (document.getElementById('uno').style.display=='block'){
		document.getElementById('uno').style.display='none';	}
	else{
		document.getElementById('uno').style.display='block';}
}
</script>