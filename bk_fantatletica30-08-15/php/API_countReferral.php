<?php
function countReferral($token){
/*	richiede al server AxC di inviare quanti utenti hanno referenziato l'utente identificato dal token
	PARAM:	$token= token di autenticazione

	RETVAL:	$count_referral intero nell'intervallo [0,n] (var globale) numero referral ottenuti
	RETVAL:	$rank intero nell'intervallo [0,n] (var globale)  posizione in classifica
	
	LATO SERVER AXC
	PARAM:	token= token di autenticazione
	
	RETVAL:	[{"referrals":"","rank":"",target:""}]
	
	//PER MICHELE: FARE CONTROLLI SUL TOKEN
*/


global $count_referral; //referral ottenuti
global $rank;  // posiziona in classifica
global $target;  // posiziona in classifica     differenza di referrals di quello che ti precede in classifica
/* crea richiesta post da inviare a AxC */
	$uri = '/API/v1/countReferrals.php'; 
	$sito = 'www.atletipercaso.net'; 
	$query = 'token='.$token; //valori post 
	
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
	//print $out;	
	$o = explode("\r\n\r\n", $out);  /* esplodi risposta per eliminare header */
	//print 'code:'. $o[1]; 
	$o1 = explode("\r\n",$o[1]); /* esplodi risposta per valori iniziali e finali inutili */	
	
	//$o1= str_replace("http:","",$o1);
		$j ='['.$o1[1].']';
		//print "token:". $j;
		$json_o=json_decode($j,true); /* decodifico json */
		//print  $j;
		foreach($json_o as $p){	
		
			//foreach($p[ranking] as $k)
				//	print $k;
			/* leggi dati da json ricevuto */
			
			//$count_referral= $p[referrals];
			return ($p[rank]);
			//$target=$p[target];
			
			}
			//print "ref".$count_referral;
			//print "rank".$rank;
		return;
}
?>
