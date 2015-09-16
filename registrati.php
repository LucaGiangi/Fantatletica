<?php
/*versione 4.1 registrazione utenti */
$page_name="registrati";
include "db.inc";
session_start();
/* gestione token */
include 'php/Gestione_token.php';
include 'php/API_createUser.php';


global $C_token;
// **************** accessi ************
$registra="";

if ($_POST['facebookID']!=""){
	
	$token=createUser("","",$_POST['email'],$_POST['firstname'],$_POST['lastname'],$_POST[' birthday'],$_POST['facebookID'],""); //$_POST['nickname']
	if ($token==-1){
		$registra="no";	
	}
	else{
		setcookie($C_token, $token, time() + $C_validity,"/");
		$_SESSION['session_active']= true;
		// da cambiare quando on-line
			header('Location:Thank_you.php');
	}
}


if ($_POST['Registrati']=="Registrati"){
	
	$token= (createUser($_POST['user'],$_POST['pass'],$_POST['mail'],"","","","",""));//$_POST['nickname']
	if ($token==-1){
		$registra="no";	
	}
	else{
		setcookie($C_token, $token, time() + $C_validity,"/"); // 86400 = 1 day salvo inero token
		$_SESSION['session_active']= true;
		// da cambiare quando online
			header('Location:Thank_you.php');
		
	}
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
<meta property="og:url" content="http://www.fantatletica.it/registrati.php"/>
<meta property="og:title" content="Fantatletica by atletipercaso.net" />
<meta property="og:description" content="Registrati su Fantatletica.it e gioca subito!" />

<script src="script/jquery-1.11.1.min.js"></script>
<script src="script/facebook.js"></script>

<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon"/>
<link rel="icon" href="images/favicon.ico" type="image/x-icon"/>
    
<link type="text/css" media="all" href="css/style.css" rel="stylesheet" />
<link type="text/css" media="all" href="css/new_mobile.css" rel="stylesheet" />
<link rel="stylesheet" href="css/input.css" type="text/css" media="screen" />

<title>Fantatletica - Registrati</title>
</head>


 <?php include 'php/header4_0.php';?>  


<div class="body_info">
	<div class="call_action_contenuto">
    
		<div class="login"> 
			<login>

				<div  class="loginsx">

          			<?php print' <form action="registrati.php" method="post">'; ?>
            		<p>Usa le credenziali del tuo account su TrackArena.com per giocare subito a Fantatletica <a href="login.php">Login</a></p>
               		<label><h3>Nome utente</h3></label>
               
               		<input type="text" name="user" required placeholder="UserName" />
                    
					<label><h3>Password</h3> </label>
					<input type="password" name="pass" required placeholder="Password"  />   
					<label><h3>Email</h3> </label>
					<input type="email" name="mail" required placeholder="Mail"  /> 
                 
                 <!--  <label><h3>Chi ti ha detto di fantatletica?</h3> </label>
                   <input type="text" name="nickname" id="nickname" <?php// print 'value="'.$_GET['refer'].'"'; ?> placeholder="NickName"  /> -->
                   
                 <!--<label><h4>Verrà spedita una password via e-mail. </h4></label>-->
                    <br/><br/>
               		<div class="centro"><input type="submit" value="Registrati" name="Registrati" /></div>
               		<div class="centro"><input type="submit" onClick="fb_login()" class="fb_registra fb" value="Registrati con Fb " name="Registrati_fb" /> <img width="40" src="images/sidebar-facebook.png"></div> 
                   
            		</form>
               		<?php  if ($registra=="no") print '<span class="budget">Errore nella registrazione riprovare</span>'; ?>
         
				</div>
			</login>
		</div>

	</div>
</div>

<?php include 'php/footer4_0.php';?>      
<script src="script/swipe.js"></script>        