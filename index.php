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

?>
<!doctype html>
<html lang="it-IT" >
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



<meta name="description" content="Crea la tua squadra, sfida i tuoi amici e scala la classifica.Che aspetti? Prova subito il nuovo FANTATLETICA e la SCHEDINA!">
<meta name="keywords" content="Fantatletica,schedina,sfida i tuoi amici">

<!--  menu -->
<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<script src="script/script.js"></script>
<!--  menu -->
    
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon"/>
<link rel="icon" href="images/favicon.ico" type="image/x-icon"/>
<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Roboto">
    
<link type="text/css" media="all" href="css/style.css" rel="stylesheet" />
<link type="text/css" media="all" href="css/new_mobile.css" rel="stylesheet" />
<title>Fantatletica</title>
</head>


<?php include 'php/header4_0.php';?>  

<div class="call_action" style="margin-top:50px;" >
	<div class="call_action_contenuto">
 		<div class="dx">
        	
            <div class="testo">   
    			<h1><b>FANTATLETICA</b></h1><br/><br/>
    			<span class="articolo">Crea la tua squadra, sfida i tuoi amici e scala la classifica.<br/> Che aspetti? Prova subito il nuovo FANTATLETICA e la SCHEDINA!</span> 
    			<p>&nbsp;</p><p>&nbsp;</p>
                <div class="call_to_action">
          			<?php if (isset($_COOKIE[$C_token])) print'<a href="g-home.php">'; else print'<a href="login.php">'; ?>
                	<img src="images/gioca-ora1.png" alt="Gioca ora"/></a>
				</div>
                <p>&nbsp;</p>
        	</div>
        </div>
    </div>
</div>

<!--  body info -->
<div class="body_info">
	<div class="call_action_contenuto">
    
		<?php if (isset($_COOKIE[$C_token])) print'<a href="g-home.php">'; else print'<a href="login.php?refer='.$_GET['refer'].'">'; ?>
        <div class="tre_articoli">
			<h2><img src="images/eb469a.png" alt="Fantatletica" ></h2>
        	<h2>Fantatletica</h2>
        	
			<span class="articolo">    
Scegli tra gli atleti iscritti alla gara quelli che vuoi nella tua squadra e decidi chi sarà il capitano. Più andrano bene i tuoi atleti più punti guadagnerai. Ah..stai attento a non sforare il budget a disposizione!</span><br>
        </div></a>
        
		<?php print'<a href="OpenSchedina.php">'; //if (isset($_COOKIE[$C_token])) print'<a href="g-home.php">'; else print'<a href="login.php?refer='.$_GET['refer'].'">'; ?>
        <div class="tre_articoli">
			<h2><img src="images/eb469b.png" alt="Schedina" ></h2>
			<h2>Schedina</h2>
        	<span class="articolo">            
 Come nella classica schedina del calcio, gioca 1, X e 2 e indovina i pronostici delle gare. L’unica regola è fare 13! Ce la farai? </span> <br>

        </div></a>
        
		<a href="Hall_of_fame.php">
        	<div class="tre_articoli">
				<h2><img src="images/eb469c.png" alt="Hall of fame" ></h2>
        		<h2>Hall of fame</h2>
      			<span class="articolo">          
I vincitori di ogni tappa del Fantatletica e della schedina avranno l'onore di vedere il proprio nome in questa sezione. Prova a lasciare il segno nella Hall of Fame!</span> <br>
    
            </div>
		</a>
	</div>
</div>



<div class="body_info blog_home">
	<div class="call_action_contenuto">
    	<div style="width:100%; text-align:center; color:#fff; font-size:28px; margin-top:10px;   margin-bottom: 10px;" >
            <p>Il blog di Fantatletica</p>
			<span class="articolo color_white "><a href="http://www.fantatletica.it/blog/">Entra nel blog!</a><br/>
             Qui troverai tutte le news che riguardano il gioco: partite imminenti, classifiche, vincitori, premi e tutti gli aggiornamenti di fantatletica. </span><br/><br/>
  
            
        </div>  
    </div>
</div>


<div class="body_info">
	<div class="call_action_contenuto">
    	<div style="width:100%; text-align:center; font-size:28px; margin-top:10px;   margin-bottom: 10px;" >
            <p class="color_red">Gioca con noi</p>
            
			<div class="sx_2col">        
                    <p><span class="nascondi1 articolo">Per giocare puoi registrarti al sito <a href="http://www.trackarena.com/" >trackarena.com</a>, oppure direttamente su <span class="color_orange articolo">Fantatletica</span> seguendo il link.<br/>
                    </span></p>
                  
                 	<a href="registrati.php"><div class="button1 b_color2">Registrati</div></a>             
			</div>
                
            <div class="dx_2col">
                <p><span class="nascondi1 articolo">Una volta registrato su <span class="color_orange articolo">Fantatletica</span> o su <a href="http://www.trackarena.com/" >trackarena.com</a> ti baster&agrave; accedere con le tue credenziali per iniziare a giocare.<br/></span></p>
                    <a href="login.php"><div class="button1 b_color2">Login</div></a>
                
            </div><br/><br/>
  
            
        </div>  
    </div>
</div>

<div class="body_info" style="background:#F3AA05;">
	<div class="call_action_contenuto">
    
        <div style="width:100%; text-align:center; color:#fff; font-size:28px; margin-top:10px;   margin-bottom: 10px;" >
            <p>Atleti pi&uacute; giocati</p>
              <p>World Championships</p>
            <img src="images/header_gare/Pechino_2015.png" width="223" alt="Manifestazione"/>
            
        </div>
        
        <div class="rank1 rank_spazio rank_margin" style="height:425px;">
            <div class="cropperb didascalia">
                <img src="images/Atleti/Renaud_Lavillenie.jpg" title="Renaud Lavillenie" alt="Renaud Lavillenie"  />
                <span class="articolo">Renaud Lavillenie<br/>19 giocatori</span> 
            </div>  
        </div>
            
        <div class="rank2">
            <div class="croppera didascalia" style="height:375px;">
                <img src="images/Atleti/Eaton_Ashton.jpg" title="Eaton Ashton" alt="Eaton Ashton"  />
                <span class="articolo">Eaton Ashton<br/>17 giocatori</span>
            </div>
        </div>
            
        <div class="rank3" >
            <div class="cropperc didascalia" style="height:330px;">
                <img src="images/Atleti/Dibaba_Genzebe.jpg" title="Dibaba Genzebe" alt="Dibaba Genzebe" />
                <span class="articolo">Dibaba Genzebe<br/>16 giocatori</span>  
            </div>
        </div>
        <p>&nbsp;</p><p>&nbsp;</p>
     		 
    </div>   
</div>

<?php include 'php/footer4_0.php';?>  
<!-- <script type="text/javascript" src="http://www.atletipercaso.net/wp-content/themes/Iris/scripts/snap.min.js"></script>-->
<!-- <script src="script/swipe.js"></script> -->
     

