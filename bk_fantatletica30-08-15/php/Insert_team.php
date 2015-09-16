<?php 
/*
v 1.0 analytics 16/05/15

tiene traccia degli inserimenti del team da parte dell'utente

PARAM:	$id = id competizione
PARAM:	$action = azione sull atleta.  I=inserimento E=edit
PARAM:	$id_giocatore = id del giocatore

RETVAL: 0 SE TUTTO è ANDATO BENE
RETVAL:	-1 IN CASO DI ERRORE

il modulo è richiamato al momento dell'inserimento su db del team e alla modifica del capitano
*/

//print $decoded->user;
/* inserisci dati azione utente */

function Insert_team($id,$action,$id_giocatore){
	global $connessione;
	$q="INSERT into Insert_team values ('".$id."','".$id_giocatore."','".(date("Y/m/d G:i:s"))."','".$action."')";
	//print $q;
				if(!mysql_query($q,$connessione)) 
					print "eerr";
				else
					return 0;

}
?>