<?php
$page_name = "Thank_you";
include "db.inc";

$data = date("Y/m/d G:i:s");
//versione 4.0 responsitive
session_start();
include 'php/Gestione_token.php';
//include "php/formatta_data.php"; 

$Errore ="";

$count_referral=0; //referral ottenuti
$rank=0;  // posiziona in classifica
$target=0; // di qaunto ti stanno avanti

include 'php/verifica_accesso_g.php';
include "php/logout.php";
?>
<!doctype html>
<html lang="it-IT">
<head>
<!-- Facebook Conversion Code for Visualizzazione di pagine chiave - Michele Fortunato 1 -->
<script>(function() {
  var _fbq = window._fbq || (window._fbq = []);
  if (!_fbq.loaded) {
    var fbds = document.createElement('script');
    fbds.async = true;
    fbds.src = '//connect.facebook.net/en_US/fbds.js';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(fbds, s);
    _fbq.loaded = true;
  }
})();
window._fbq = window._fbq || [];
window._fbq.push(['track', '6028483670570', {'value':'0.00','currency':'EUR'}]);
</script>
<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?ev=6028483670570&amp;cd[value]=0.00&amp;cd[currency]=EUR&amp;noscript=1" /></noscript>

<meta charset="utf-8">

<meta http-equiv="x-ua-compatible" content="IE=edge" />
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-touch-fullscreen" content="yes">

<script src="script/jquery-1.11.1.min.js"></script>
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon"/>
<link rel="icon" href="images/favicon.ico" type="image/x-icon"/>

<meta property="og:type" content="website" />
<meta property="og:image" content="http://www.fantatletica.it/images/facebookcover.jpg"/>
<meta property="og:url" content="http://www.fantatletica.it/Thank_you.php"/>
<meta property="og:title" content="Fantatletica by atletipercaso.net" />
<meta property="og:description" content="Crea la tua squadra e sfida i tuoi amici. Chi è il più esperto di atletica?" />
    
<link type="text/css" media="all" href="css/style.css" rel="stylesheet" />
<link type="text/css" media="all" href="css/new_mobile.css" rel="stylesheet" />
<title>Fantatletica by atletipercaso.net</title>

</head>

 
<?php include 'php/header4_0.php';?>  
<!-- condividi fb -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/it_IT/sdk.js#xfbml=1&version=v2.3";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div class="body_info">
	<div class="call_action_contenuto">   
		<div class="login"  style="width:95%"> 
			<login>

				<div  class="loginsx">

					</br><h1>Fantatletica.it</h1>         
					
                    
                    <p class="articolo">Al momento Fantatletica è disponibile solo per un numero limitato di giocatori, ma ci sono molte occasioni per aggiudicarsi l’accesso al sito.</p>
                    
                    <p class="articolo">Continua a seguirci qui o consulta il nostro <a href="http://www.fantatletica.it/blog/" class="color_arancio" target="new"> blog</a>.</p>
                 
                  <!--  <p>Al momento fantatletica &egrave; disponibile solo per un numero limitato di giocatori.</p>
					<p>Chiedi un invito a chi ha avuto gi&aacute; l'accesso e inizia a scalare la classifica.</br>Tieni d'occhio la tua email!</p>-->
                    
                          
					<?php	//mostra le gare aperte a tutti giocabili
                   
					$q="SELECT * FROM Competizione where Inizio_formazione<='".$data."' and Termine_formazione>='".$data."' and Type='3'";	
                         $t=mysql_query($q,$connessione); 	
                         while($r=mysql_fetch_object($t)){
                            $Id_competizione=$r->Id_competizione;
                            $nome_competizione=$r->Nome;
                            $sede_comeptizione=$r->Sede;
                            $ATTIVO=true;
                            $Header_logo=$r->Header_link;
                         }	 
                    if ($ATTIVO){		 
                        print '<h1 style="color:#F00;">Attenzione!</h1><span><h3>Nuova occasione per vincere il tuo invito.</h3></span>';
                    print'<div><img class="logo_gara" style="padding-right:20px; padding-bottom:20px;" src="images/header_gare/'.$Header_logo.'">
                        <h1><articolo>'.$nome_competizione.'</articolo></h1>
                        <h2><span class="color_arancio">Vinci l&acute;accesso a fantatletica.</span></h2>
                        <br/>
                        <a href="OpenSchedina.php" ><div class="button" >Gioca ora!</div></a>
                        <p>&nbsp;</p><br/></div>';                   
                    }
                    ?>
      
      				<h2>Occasioni passate</h2>
                    <?php	//stampa le gare aperte a tutti superate
                      $q="SELECT * FROM Competizione where  Termine_formazione<='".$data."' and Type='3'";	
                         $t=mysql_query($q,$connessione); 	
                         while($r=mysql_fetch_object($t)){
                           
							print'<a href="OpenSchedina.php?id='.$r->Id_competizione.'" ><img width="150px" src="images/header_gare/'.$r->Header_link.'" title="'.$r->Nome.'" alt="'.$r->Nome.'"/></a>';
                         }
					?>
					<br/>
                    
					<br/><br/> 
					<?php   
                    /*if ($count_referral>0){
                        print 'Fino ad ora <b>'.$count_referral.' persone</b> si sono iscritte facendo il tuo nome e sei al <b>'.$rank.' posto in classifica</b>.</p><p><a href="referralRank.php" target="new"><color_arancio>La classifica completa</color_arancio></a> </p> ';
                       if ($rank==1)
                            print '<p><b>Per ora sei primo</b>, ma attento a non farti superare!';
                        else	
                             print 'Ti basta far iscrivere <b>'.$target.' amici</b> per scalare una posizione!</p>';
                    }
                    else
                        print 'Non hai ancora invitato nessun amico a giocare.';
                    
                    print '<p><b>Hai tempo fino a marted&igrave;</b> per essere tra i primi <b>50</b> e avere l&lsquo;accesso al gioco.</p>
                    <p><b>Condividi questo link</b> con i tuoi amici per guadagnare posizioni</p>'; ?>
                     
                      </p>
                       
                    <?php print    '<p><b>http://www.fantatletica.it/index.php?refer='.str_replace(" ","%20",$g_nome).' </b></p>';
                       
                      print' <p>oppure <div class="fb-share-button" data-href="http://www.fantatletica.it/index.php?refer='.str_replace(" ","%20",$g_nome).'" data-layout="button"></div></p>';*/
					  ?>    
				</div>
			</login>
		</div>
	</div>
</div>

<br/>
<?php include 'php/footer4_0.php';?>        
<script src="script/swipe.js"></script>        