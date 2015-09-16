<?php
$host="62.149.150.121";
$dataBase="Sql416330_1";
$user="Sql416330";
$pass="002e714d";

$connessione=mysql_pconnect($host,$user,$pass);	mysql_select_db($dataBase,$connessione);


/* chiave cifratura token */
$key='ciao'; /* chiave per decifrare mex*/

/* definisci nome parametri cookies */
$C_validity = (86400 * 10); /* secondi * giorni */
$C_token="Token";


/* dati utente caricati in Gestione_token.php  function  getInfo */
$g_id="";
$g_avatar="";
$g_mail="";
$g_nome="";

$array_avatar= array();

$g_notifiche="";
?>