<?php
//verifica accesso pagine riservate
$verificato = false;

/*
$q="select * from Giocatore";
$t=mysql_query($q,$connessione); 	
while($r=mysql_fetch_object($t)){
	$user_letto=$r->Nickname;
	$pass_letto=$r->Password;
	if (($_SESSION['g_user']==$user_letto)&& ($_SESSION['g_pass']==$pass_letto))
		$verificato= true;
}
*/
/*include 'Gestione_token.php';*/
include "API_countReferral.php";

//$count_referral=0; //referral ottenuti
$rank=0;  // posiziona in classifica
//$target=0; // di qaunto ti stanno avanti
global $page_name;
//$count_referral=0; //referral ottenuti
//$location=0;  // posiziona in classifica
/* verifica tramite token */
if(isset($_COOKIE[$C_token])){ /* verifica presenza token salvato sul dispositivo */
	getInfo($_COOKIE[$C_token]);
	if ($g_id!=NULL){
		$token_= $_COOKIE[$C_token];	
		/* aggiorna scadenza token */
		$verificato= true;
		// leggi referral utente da AxC
		$rank=countReferral($token_);
		// GESTIONE TABELLE GIOCATORE SU FANTATLETICA
		/*if ($page_name!="Thank_you")*/ 
		
		setcookie($C_token, $token_, time() + $C_validity,"/"); // 86400 = 1 day salvo inero token
		 admin_giocatore($g_id,$g_nome,$rank); // invio id e nickname
	}
	
	/*if (!$_SESSION['session_active']){
		$_SESSION['session_active']= true;		
		include "verifica_gara.php";
	}*/
}
if (!$verificato) header('Location:login.php');
	
	

function admin_giocatore($g_id,$g_nome,$rank){
	
	if (!$_SESSION['session_active']){
		$_SESSION['session_active']= true;		
		/*include "verifica_gara.php";*/
	}
	
	/* verifico che la tabella giocatore contenga gia i dati del giocatore che si è loggato */
	global $connessione;
		global $page_name;
	$status=0;
	$trovato = false;
	$q="SELECT * FROM Giocatore where Id_giocatore='".$g_id."'";
	/*print $q;*/
		$t=mysql_query($q,$connessione); 	
		while($r=mysql_fetch_object($t)){
			$trovato = true;
			$status =$r->Status;
			//if ($r->Status == 0)  header('Location:Thank_you.php');/* l'utente è gia registrato sul db Fa e quindi leggo il suo diritto di accesso */
		}
	
	if (!$trovato){
		
		if ($rank > 50 || $rank =="" ) $status=0; else $status=1; /* verifica appartenenza ai 50 da attivare */		
		$q="INSERT into Giocatore  values ('".$g_id."','True','".$g_nome."','0','','0','0','0','".$status."','0')";
		
		if(!mysql_query($q,$connessione)) 
			$Errore = "Errore di inserimento";
		//if ($status == 0) header('Location:Thank_you.php');/* non può giocare */
	}
	
	if ($status==0)
	if ($page_name!="Thank_you")  header('Location:Thank_you.php');

}


?>