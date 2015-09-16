<?php 
/*
v 1.0 analytics 16/05/15

stampa le iscrizioni per la gara passata come parametro
PARAM:	variabile get 'id' = id dell'atleta
PARAM:	variabile get 'action' = azione sull atleta.  I=inserimento D=cancellazione

il modulo è richiamato tramite ajax
*/
session_start();
include "../db.inc";
include "JWT.php";

global $key;
global $C_token;
$token= $_COOKIE[$C_token];
//print $token;
$decoded = JWT::decode($token, $key, array('HS256'));
//print $decoded->user;
/* inserisci dati azione utente */
if ($decoded->user>0){
	$q="INSERT into Track_actions values ('".$_GET[id]."','".$decoded->user."','".(date("Y/m/d G:i:s"))."','".$_GET['action']."')";
				if(!mysql_query($q,$connessione)) 
					print  "Errore di inserimento";
				else
					print "ok";
}
?>