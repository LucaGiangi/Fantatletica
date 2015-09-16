<?php
/* includi libreria per decodificare token */
include 'JWT.php';

function getToken($user,$pw,$referral){
	/* invia richiesta post al server AxC per ricevere token di autenticazione. contiene id cifrato con $key
	PARAM: $user = username
	PARAM: $pw = password
	PARAM: $referral
	RETVAL: token cifrato sse id e passowrd corrisposndono
		tipico:[{"token":"","status":0}]
	RETVAL:	"0" se le credenziali non sono corrette
	
	LATO SERVER AXC
	PARAM:	user = username
	PARAM:	pw = password
	
	RETVAL: token cifrato sse id e passowrd corrispondono
		tipico:[{"token":"","status":0}]
	RETVAL:	"0" se le credenziali non sono corrette
	*/
	
	/* crea richiesta post da inviare a AxC */
	$uri = '/API/v1/getToken.php'; 
	$sito = 'www.atletipercaso.net'; 
	$query = 'origin=Fantatletica&user='.$user.'&pw='.$pw.'&referral='.$referral; //valori post 
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
	  $out.=fgets($sock); /* leggi risposta server */	
	fclose($sock);  	
	$o = explode("\r\n\r\n", $out);  /* esplodi risposta per eliminare header */
	//print 'code:'. $o[1]; 
	$o1 = explode("\r\n",$o[1]); /* esplodi risposta per valiri iniziali e finali inutili */	
	/*$j =*/
	return ('['.$o1[1].']'); 	/* carico il token */
}


function getInfo($token){
	/* invia richiesta POST a getUserInfo.php per ricevere le info dell'utente
	PARAM: $token = token JWT per identificare l'utente (utente loggato e di cui si vuole prelevare info)
	
	RETVAL: setta variabili globali definite in db.inc
		$g_avatar;
		$g_mail;
		$g_nome;
		$g_id;
		
	LATO  SERVER AXC
	PARAM: token = token ricevuto al momento del login
	
	RETVAL: "Token not received" sse il token è assente o errato
	RETVAL: striga json sse il token è valido
			stringa tipica:
[{"user_login":"","first_name":"","last_name":"","user_email":"","sex":"","birth":"","team":"","points":"","pending_points":"","avatar":"","facebookID":""}]	
	
	user_login -> nickname
		
	*/
	
	/* definite in dc.inc */
	global $g_avatar;
	global $g_mail;
	global $g_nome;
	global $g_id;
	global $key;
	
	$status=false; /* rimane false se ci sono stati problemi */
	if ($token!="0" and $token!=""){
		$decoded = JWT::decode($token, $key, array('HS256'));
		/* invia richiesta info utente */
		$uri = '/API/v1/getUserInfo.php'; 
		$sito = 'www.atletipercaso.net'; 
		$query = 'origin=Fantatletica&token='. $token; //valori post 
		
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
		//print 'code:'. $o[1]; 
		$o1 = explode("\r\n",$o[1]); /* esplodi risposta per valiri iniziali e finali inutili */	
		$j ='['.$o1[1].']';
		//print $j;
		$json_o=json_decode($j,true); /* decodifico json */
		foreach($json_o as $p){
			if ($p[error]!="Token not received"){
				/* leggi dati da json ricevuto */	
				 $g_avatar=$p[avatar];
				 $g_mail=$p[user_email];
				 $g_nome=$p[user_login];
				 $g_id=$decoded->user;
				 $status=true;
				//return array($p[avatar],$p[user_email],$p[display_name]);
				//print "kkkk".$g_nome;
			}
		}
	}
	
	if (!$status){
		$g_avatar=NULL;
		$g_mail=NULL;
		$g_nome=NULL;
		$g_id=NULL;	
	}
}



?>