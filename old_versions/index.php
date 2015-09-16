<?php
$page_name = "index";
include "db.inc";
//versione 4.1 responsitive
/* 4.1-> 29/04/15
aggiornamento da gestione login con sessioni a gestione con token
aggiunte variabili blobali in db.inc per memorizzare (al caricamento di ogni pagina) le info del giocatore
sessioni usate per memorizzare dati partita e gestione admin(gestione admin da cambiare successivamente)
PAGINE AGGIORNATE: TUTTE LE PAGINE GIOCATORE


5.0 ->18/07/2015 aggiornata grafica
*/
//session_start();

/* se il cookie è presente mostro menu giocatore */

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
<meta property="og:url" content="http://www.fantatletica.it/"/>
<meta property="og:title" content="Fantatletica by atletipercaso.net" />
<meta property="og:description" content="Crea la tua squadra e sfida i tuoi amici. Chi è il più esperto di atletica?" />

<!-- <script src="script/jquery-1.11.1.min.js"></script>-->
 
 <!--  menu -->
   <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
   <script src="script/script.js"></script>
   <!--  menu -->
    
	<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon"/>
	<link rel="icon" href="images/favicon.ico" type="image/x-icon"/>
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Roboto">
    
<link type="text/css" media="all" href="css/style.css" rel="stylesheet" />
<link type="text/css" media="all" href="css/new_mobile.css" rel="stylesheet" />
<title>Fantatletica by atletipercaso.net</title>
</head>


 <?php include 'php/header4_0.php';?>  

<div class="call_action" style="margin-top:50px;" >
	<div class="call_action_contenuto">
 		<div class="dx">
        	
            <div class="testo">   
    <h1><b>FANTATLETICA</b></h1><br/><br/>
    <articolo><span>Crea la tua squadra, sfida i tuoi amici e scala la classifica.<br/> Che aspetti? Prova subito il nuovo FANTATLETICA e la SCHEDINA!</span></articolo>
    <p>&nbsp;</p><p>&nbsp;</p>
                <div class="call_to_action">
          <?php if (isset($_COOKIE[$C_token])) print'<a href="g-home.php">'; else print'<a href="login.php">'; ?><img src="images/gioca-ora1.png" alt="Gioca ora"/></a>
                </div>
                <p>&nbsp;</p>
        	</div>
        </div>
    </div>
</div>

<!--  body info -->
<div class="body_info">
	<div class="call_action_contenuto">
    
     <div class="tre_articoli">
     
     <h2><img src="images/eb469a.png" alt="Fantatletica" ></h2>
        <h2>Fantatletica</h2>
        	
   <articolo>         
Scegli tra gli atleti iscritti alla gara quelli che vuoi nella tua squadra e decidi chi sarà il capitano. Più andrano bene i tuoi atleti più punti guadagnerai. Ah..stai attento a non sforare il budget a disposizione!
</articolo>
<br>

 
<?php //if (isset($_COOKIE[$C_token])) print'<a href="g-home.php">'; else print'<a href="login.php?refer='.$_GET['refer'].'">';
//print '<div class="button_home" >GIOCA ORA</div></a>'; ?>
        </div>
        
           <div class="tre_articoli">
             <h2><img src="images/eb469b.png" alt="Schedina" ></h2>
        <h2>Schedina</h2>
        	
   <articolo>           
 Come nella classica schedina del calcio, gioca 1, X e 2 e indovina i pronostici delle gare. L’unica regola è fare 13! Ce la farai? </articolo>
<br>
<?php //if (isset($_COOKIE[$C_token])) print'<a href="Schedina.php">'; else print'<a href="login.php?refer='.$_GET['refer'].'">';
 //print'<div class="button_home" >GIOCA ORA</div></a>'; ?>
        </div>
        
           <div class="tre_articoli">
           
           <h2><img src="images/eb469c.png" alt="Hall of fame" ></h2>
        <h2>Hall of fame</h2>
      <articolo>         
I vincitori di ogni tappa del Fantatletica e della schedina avranno l'onore di vedere il proprio nome in questa sezione. Prova a lasciare il segno nella Hall of Fame!</articolo>
<br>
<!--<a href="Hall_of_fame.php"><div class="button_home" >VINCITORI</div></a>-->
        </div>
       
        
    
    </div>
</div>


<div class="body_info" style="background:#F3AA05;">
	<div class="call_action_contenuto">
    
    <div style="width:100%; text-align:center; color:#fff; font-size:28px; margin-top:10px;   margin-bottom: 10px;" >
    	<p>Atleti pi&uacute; giocati</p>
        <img src="images/header_gare/EuropeiJ.png" width="223" alt="Manifestazione"/>
        
    </div>
    
    
    
		<div class="rank1">
       		<div class="croppera didascalia">
				<img src="images/Atleti/Ayomide_Folorunso.jpg" title="Ayomide Folorunso" alt="Ayomide Folorunso"  />
                <span><articolo>Ayomide Folorunso<br/> 20 giocatori</articolo></span>  
			</div>
		</div>
        
        <div class="rank2">
        	<div class="cropperb didascalia">
				<img src="images/Atleti/Benedetta_Cuneo.jpg" title="Benedetta Cuneo" alt="Benedetta Cuneo"  />
                <span><articolo> Benedetta Cuneo<br/> 16 giocatori </articolo></span>  
			</div>  
        </div>
        
        <div class="rank3" >
       		<div class="cropperc didascalia">
				<img src="images/Atleti/Yohanes_Chiappinelli.jpg" title="Yohanes Chiappinelli" alt="Yohanes Chiappinelli" />
                <span><articolo> Yohanes Chiappinelli <br/> 15 giocatori</articolo> </span>  
			</div>
        </div>
    
  		 
    </div>   
</div>

<?php include 'php/footer4_0.php';?>  
<!-- <script type="text/javascript" src="http://www.atletipercaso.net/wp-content/themes/Iris/scripts/snap.min.js"></script>-->
<!-- <script src="script/swipe.js"></script> -->
     

