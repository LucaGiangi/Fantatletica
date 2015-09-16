<?php
//include 'JWT.php';
function createUser($username,$password,$email,$firstname,$lastname,$birthday,$facebookID,$referral){
	/* invia richiesta POST a createUser.php per aggiungere un nuovo utente al db di AxC
	PARAM:	$username = username utente da registrare NOT NULL (registrazione classica)
	PARAM:	$password = password utente da registrare NOT NULL (registrazione classica)
	PARAM:	$mail = email dell'utente NOT NULL
	PARAM:	$referral = nickname dell'utente a cui si vuole dare l'accesso
	
	 in caso di accesso con fb 	
	PARAM:  $first_name = nome utente
	PARAM:  $last_name = cognome utente
	PARAM:	$birthday = data di nascita nel formato aaaa-mm-gg
	PARAM:  $facebookID = id di facebook 
	PARAM:	$referral = nickname dell'utente a cui si vuole dare l'accesso
	
	RETVAL: token per accesso al sito sse non si sono verificati errori
	RETVAL:	-1 sse la registrazione non è stata effettuata
	
	LATO SERVER AXC
	PARAM:	username (non presente)
	PARAM:	password (non presente)
	PARAM:	mail = email dell'utente NOT NULL
	PARAM:	$referral = nickname dell'utente a cui si vuole dare l'accesso
	
	 in caso di accesso con fb 	
	PARAM:  first_name = nome utente
	PARAM:  last_name = cognome utente
	PARAM:	birthday = data di nascita nel formato aaaa-mm-gg
	PARAM:  facebookID = id di facebook 
	PARAM:	$referral = nickname dell'utente a cui si vuole dare l'accesso

	RETVAL: stringa di errore in formato json sse la richiesta non è ben formattata
			{"token":0,"status":"Username, password or email missing"}
	RETVAL: stringa in formato json sse la richiesta è bel formattata
			{"token":"  ","status":0}
	
	*/
		global $key;
		
		$array_avatar=array();
		/* invia richiesta avatar */
		$uri = '/API/v1/createUser.php'; 
		$sito = 'www.atletipercaso.net'; 	
		$query = 'origin=Fantatletica&username='.$username.'&password='.$password.'&email='.$email.'&firstname='.$firstname.'&lastname='.$lastname.'&birthday='.$birthday.'&facebookID='.$facebookID.'&referral='.$referral; //valori post 
		//print "arrivato".$query;
		//print $query;
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
		$o1 = explode("\r\n",$o[1]); /* esplodi risposta per valari iniziali e finali inutili */	
		/*print $o1;*/
		/* sostituisci caratteri non validi */
		$o1= str_replace("http:\/\/www.","http://",$o1);
		$o1= str_replace("\/","/",$o1);
		//$o1= str_replace("http:","",$o1);
		$j ='['.$o1[1].']';
		//print "token:". $j;
		$json_o=json_decode($j,true); /* decodifico json */
		//print  $j;
		foreach($json_o as $p){	
			/* leggi dati da json ricevuto */
			if ($p[token]=="0")
				return -1;	
			else{
				
				//return (JWT::decode($p[token], $key, array('HS256')));
				return $p[token];
			}
			
		}
	}
?>