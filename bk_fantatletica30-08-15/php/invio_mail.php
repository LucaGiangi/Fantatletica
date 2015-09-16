<?php
function Invio($destinazione,$corpo,$oggetto){
 		$messaggio=$corpo;

 $headers  = 'MIME-Version: 1.0' . "\r\n";
 $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
 $headers .= "To:AtletiPerCaso.net  \r\n"; 
 $headers .= 'From: direzione@sunsetbeach-club.it';

 if (mail($destinazione, $oggetto, $messaggio, $headers))
	return true;
		else
	return false;
}

function RinviaMail($destinatario){
if ($_POST['login']=="Invia"){
	// Verifica che l'indirizzo sia registrato
		$q="select * from Giocatore where Mail='".$_POST['mail']."'";
		$t=mysql_query($q,$connessione); 
		while($r=mysql_fetch_object($t)){
			$user_mail=$r->UserName;
			$pass_mail=$r->Password;	
		 	$a= $r->Mail;}
	if ($a !=""){
 		$oggetto="Credenziali area riservata SunsetBeach-Club";
 		$messaggio="<html><body>
<a href='www.sunsetbeach-club.it'> <img src='http://www.sunsetbeach-club.it/Images/Logo.PNG' title='SunsetBeach-Club'/></a><br/> 
<p> Questa mail è stata generate automaticamente a seguito di una richiesta di assistenza </p>
<font color=rgba(255, 249, 144) size='+3'><p > Dati di accesso: </p>
UserName= ".$user_mail." <br>
Password= ".$pass_mail." <br>
</font><br/>
<a href='http://www.sunsetbeach-club.it/Login/login.php'> Accedi... </a>
 </body></html> ";

 $headers  = 'MIME-Version: 1.0' . "\r\n";
 $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
 $headers .= "To:SunsetBeach-Club \r\n"; 
 $headers .= 'From: direzione@sunsetbeach-club.it';

 if (mail($a, $oggetto, $messaggio, $headers)){
	 $notifica_mail = "I tuoi dati sono stati inviati all&acute;indirizzo: ".$a;}
		}else
		$notifica_mail = "Errore di invio";
}

if ($a=="") $notifica_mail = "Nessun indirizzo mail trovato! Riprovare";	
	
	
}





?>