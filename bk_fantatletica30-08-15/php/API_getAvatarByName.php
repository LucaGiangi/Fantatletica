<?php
function getAvatarByName($first_name,$last_name){
	/* invia richiesta POST a getAvatarByName.php per ricevere l'avatar dei giocatori specificati tramite nome e cognome
	la funzione è case sensitive -> nomi minuscoli con iniziali maiuscole
	PARAM: first_name = nome1,nome2,nome3,....nomen
	PARAM: last_name = cognome1,cognome2,cognome3,...cognomen
	
	RETVAL: stringa contenente l'avatar dei giocatori (avatar di default del sito in caso di errore o mancata corrispondenza)
	
	LATO SERVER AXC
	PARAM: first_name = nome1,nome2,nome3,....nomen
	PARAM: last_name = cognome1,cognome2,cognome3,...cognomen
	
	RETVAL: stringa di errore in formato json sse la richiesta non è ben formattata
			tipica = getavatar:[{"avatar":"","error":"User not available"}]
	
	RETVAL: stringa in formato json sse la richiesta è bel formattata
			tipica {"avatar":["http:\/\/graph.facebook.com\/id_utente\/foto,http:\/\/graph.facebook.com\/id_utente\/foto]"}
	
	*/
	
		/* converto stringhe nei formati richiesti */
	//	$first_name = ucwords( strtolower($first_name)); /* porta in minuscolo tutta la stringa e in maiuscolo la prima lettera di ogni parola*/
	//	$last_name =ucwords (strtolower($last_name));
		
		/* variabile array definita in db.inc */
		global $array_avatar;
		
		$array_avatar=array();
		/* invia richiesta avatar */
		$uri = '/API/v1/getAvatarByName.php'; 
		$sito = 'www.atletipercaso.net'; 	
		$query = 'first_name='.$first_name.'&last_name='.$last_name; //valori post 
		
		//print $query;
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
		/*print $o1;*/
		/* sostituisci caratteri non validi */
		$o1= str_replace("http:\/\/www.","http://",$o1);
		$o1= str_replace("\/","/",$o1);
		//$o1= str_replace("http:","",$o1);
		$j ='['.$o1[1].']';
		//print $j;
		$json_o=json_decode($j,true); /* decodifico json */
		
		foreach($json_o as $p){	
			/* leggi dati da json ricevuto */
			
				for ($i=0;$i< sizeof($p[avatar]);$i++){
					// in caso di avatar di default indirizza img dalla cartella img de nostro sito
					if ($p[avatar][$i]=="http://atletipercaso.net/wp-content/themes/Iris/images/profile.png")
						//return "images/default_avatar.png";
						$array_avatar[$i]="images/default_avatar.png";
					else
						$array_avatar[$i]=$p[avatar][$i];
					// return ($p[avatar]);	
				}
		}
	}
?>