<?php
/*versione 4.1 login utente tramite token */
$page_name="login";

session_start();
include "db.inc";

/* gestione token */
include 'php/Gestione_token.php';
/* $ken,$C_token,$C_validity definito in db.inc */


/* leggi pagina a cui tornare */
$ret_pg=$_GET['ret'];

// scommentare quando il sito va online
//include "php/verifica_gara.php"; /* cerca se esiste una gara attiva */


$login="0";
global $C_token;
// **************** accessi ************
if(($_POST['Accedi']=="Accedi")){
	
	$j = getToken($_POST['user'],$_POST['pass'],$_POST['nickname']); /* invia richiesta post api AxC */
	print $j;
	$json_o=json_decode($j,true); /* decodifico json */
	foreach($json_o as $p){
		
		if ($p[token]!="0"){ /* verifico che ci sia un token valido per login */
			$decoded = JWT::decode($p[token], $key, array('HS256'));
			//print "user:".$decoded->user;
			/* setta cookie token */
			
			setcookie($C_token, $p[token], time() + $C_validity,"/"); // 86400 = 1 day salvo inero token
		
			$_SESSION['session_active']= true;
			/* salva dati per mantenere compatibiità con vecchia versone */
			/*$_SESSION['g_id']=$decoded->user;*/
	
			if ($ret_pg=="") /* ritorno alla pagina chiamante */
						// scommentare quando il sito va online
						//header('Location:g-home.php');
						header('Location:Thank_you.php');
					else
						header('Location:'.$ret_pg.'.php');
		}
		else
			$login="no";
}
	

	
	
	
	//Accesso Giocatore
/*	$q="select * from Giocatore";
	$t=mysql_query($q,$connessione); 
	while($r=mysql_fetch_object($t)){
		$user_letto=$r->Nickname;
		$pass_letto=$r->Password;
		if (($_POST['user']==$user_letto)&& ($_POST['pass']==$pass_letto)){
			$_SESSION['g_user'] = $_POST['user'];
			$_SESSION['g_pass'] = $_POST['pass'];
			$_SESSION['g_id'] = $r->Id_giocatore;
			$_SESSION['g_avatar'] = $r->Avatar;
			$_SESSION['g_mail'] = $r->E_mail;	
			$_SESSION['g_notifiche'] = $r->Notifiche;	
			$_SESSION['g_id'] = $r->Id_giocatore;		
			$_SESSION['g_nome'] = $r->Nome;		
			$_SESSION['g_cognome'] = $r->Cognome;
			$_SESSION['g_team'] = $r->Nome_team;	
			$_SESSION['g_stringa'] = $r->Stringa;	
			$_SESSION['g_punti'] = $r->Punti;		
			if ($ret_pg=="")
				header('Location:g-home.php');
			else
				header('Location:'.$ret_pg.'.php');
		}
		else
		$login="no";
	}*/
	
/*	if ($login="no"){
	
		$q="select * from Ad_min";
		$t=mysql_query($q,$connessione); 
		while($r=mysql_fetch_object($t)){
			$user_letto=$r->Username;
			$pass_letto=$r->Password;
			if (($_POST['user']==$user_letto)&& ($_POST['pass']==$pass_letto)){
				$_SESSION['ad_user'] = $_POST['user'];
				$_SESSION['ad_pass'] = $_POST['pass'];
				$_SESSION['ad_id'] = $r->Id;
				$_SESSION['ad_nome'] = $r->Nome;
				$_SESSION['ad_mail'] = $r->E_mail;
				
				header('Location:admin_home.php');
			}
			else
			$login="no";
		}	
	}*/
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

        <meta property="og:type" content="website" />
<meta property="og:image" content="http://www.fantatletica.it/images/facebookcover.jpg"/>
<meta property="og:url" content="http://www.fantatletica.it/login.php"/>
<meta property="og:title" content="Fantatletica by atletipercaso.net" />
<meta property="og:description" content="Crea la tua squadra e sfida i tuoi amici. Chi è il più esperto di atletica?" />

 <script src="script/jquery-1.11.1.min.js"></script>
 

	<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon"/>
	<link rel="icon" href="images/favicon.ico" type="image/x-icon"/>
    
<link type="text/css" media="all" href="css/style.css" rel="stylesheet" />
<link type="text/css" media="all" href="css/new_mobile.css" rel="stylesheet" />
<link rel="stylesheet" href="css/input.css" type="text/css" media="screen" />


<title>Fantatletica by atletipercaso.net</title>
</head>


 <?php include 'php/header4_0.php';?>  


<div class="body_info">
	<div class="call_action_contenuto">
    
<div class="login"> 
<login>

<div  class="loginsx">

 
          <?php print' <form action="login.php?ret='.$_GET['ret'].'" method="post">'; ?>

          		<p>Usa le credenziali del tuo account su atletipercaso.net per giocare subito a Fantatletica</p>
             
               <label><h3>Nome utente</h3></label>
               
               <input type="text" name="user" required placeholder="UserName" />
                    
                   <label><h3>Password</h3> </label>
                   <input type="password" name="pass" required placeholder="Password"  />   

					<label><h3> E' la prima volta che accedi a Fantatletica? Chi te lo ha fatto conoscere?</h3></label>
                   <input type="text" name="nickname" <?php print 'value="'.$_GET['refer'].'"'; ?>  placeholder="NickName"  />
                   
                   <label><h4> <a target="new" href="http://www.atletipercaso.net/wp-login.php?action=lostpassword">Recupera credenziali</a>
                   <a  href="registrati.php">&nbsp;|&nbsp;Registrati</a></h4></label>
                    <br>
               <div class="centro">    <input type="submit" value="Accedi" name="Accedi" /></div>
                   
                    
            </form>
               <?php  if ($login=="no") print '<span class="budget">  Attenzione! Username o password errati.</span>'; ?>
         
          
     </div>
            </login>
       </div>


</div>
</div>










  <?php include 'php/footer4_0.php';?>  
 <!-- <script type="text/javascript" src="http://www.atletipercaso.net/wp-content/themes/Iris/scripts/snap.min.js"></script>
-->         
<script src="script/swipe.js"></script>        

