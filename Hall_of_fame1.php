<?php
/*
Version		author		date		description
2.0.0		L.G.		17/09/15	Versione preliminare nuova grafica

*/

$page_name = "hall_of_fame";
include "db.inc";
//versione 4.0 responsitive
session_start();
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
<meta property="og:image" content="http://www.fantatletica.it/images/halloffame.jpg"/>
<meta property="og:url" content="http://www.fantatletica.it/Hall_of_fame.php"/>
<meta property="og:title" content="Hall of Fame - Fantatletica" />
<meta property="og:description" content="Vuoi vedere il tuo nome tra quello dei pochi vincitori del fantatletica? Gioca le partite e tenta la vittoria!" />

<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon"/>
<link rel="icon" href="images/favicon.ico" type="image/x-icon"/>
<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Roboto">

<script src="script/jquery-1.11.1.min.js"></script>

    
<link type="text/css" media="all" href="css/style.css" rel="stylesheet" />
<link type="text/css" media="all" href="css/new_mobile.css" rel="stylesheet" />
<link href="css/m_style.css" rel="stylesheet" />
<link type="text/css" media="all" href="css/utente.css" rel="stylesheet" />
<link href="css/responsive.css" rel="stylesheet" />
<title>Hall of Fame - Fantatletica</title>
</head>
<?php include 'php/header5_0.php';?>  





<div class="body_info" id="new_league">
	<div class="call_action_contenuto">
    	<div style="width:100%; text-align:center; font-size:28px; margin-top:10px; margin-bottom: 10px;" > 
        	<span class="articolo">Vuoi vedere il tuo nome tra quello dei pochi vincitori del fantatletica? Gioca le partite e tenta la vittoria!</span>
           	     
        </div>  
    </div>
</div>

<div class="body_info" style="background:#F3AA05;">
	<div class="call_action_contenuto">
    	<div style="width:100%; text-align:center; color:#fff; font-size:28px; margin-top:10px;   margin-bottom: 10px;" >        	            
            <p class="marginezero"><a name="send_request"></a>Vincitori schedina</p>
			<span class="articolo"><i>Nessuno è riuscito a fare 13. Pensi di poter essere il primo?</i></span>     
        </div>  
    </div>
</div>

<div class="body_info">
	<div class="call_action_contenuto">
    	<div style="width:100%;text-align:center;font-size:28px; margin-top:10px;margin-bottom: 10px;" >        	            
            <p class="marginezero"><a name="send_request"></a>Vincitori fantatletica</p>
			
            
            
            <div class="fame fanta">
            	 <div class="puntina">&nbsp;</div>
                 <div class="cropper">
					<img src="images/Vincitori/Giovanni_Mastrippolito.jpg" title="Profilo" alt="Giovanni Mastrippolito" /><br>
                </div>
                <div class="cont_testo">
                    <p class="team_nome1">mastro</p>	
                    <p class="team_nome1">Brixia Meeting 2015<br/>&nbsp;</p>
                </div>
            </div>
            
            <div class="fame fanta">
            	 <div class="puntina">&nbsp;</div>
                 <div class="cropper">
					<img src="images/Vincitori/Francesco_Fortunato.jpg" title="Profilo" alt="Francesco Fortunato" /><br>
                </div>
                <div class="cont_testo">
                    <strong>Francesco Fortunato</strong>	
                    <hr>
                    Vincitore gara:	<br>	
                    <strong>Campionati Italiani Junior/Promesse 2015</strong>
                 </div>
            </div>
            <div class="fame fanta">
            	 <div class="puntina">&nbsp;</div>
                 <div class="cropper">
                	<img src="images/Vincitori/Stefano_Guidotti_Icardi.jpg" title="Profilo" alt="Stefano Guidotti Icardi"/><br>
                </div>
                <div class="cont_testo">
                    <strong>steone88</strong>	
                    <hr>
                    Vincitore gara:	<br>	
                    <strong>Campionati Italiani Allievi 2015</strong>
                </div>  
            </div>
            
            <div class="fame fanta">
            	 <div class="puntina">&nbsp;</div>
                 <div class="cropper">
                	<img src="images/Vincitori/Riccardo_Serra.jpg" title="Profilo" alt="Riccardo Serra" /><br>
                </div>
                <div class="cont_testo">
                    <strong>Rickyserra</strong>	
                    <hr>
                    Vincitore gara:	<br>	
                    <strong>European U23 Championships 2015</strong>
                </div>  
            </div>
            
            
            <div class="fame fanta">
            	 <div class="puntina">&nbsp;</div>
                 <div class="cropper">
                	<img src="images/Vincitori/Martino_De_Nardi.jpg" title="Profilo" alt="Martino De Nardi"/><br>
                </div>
                <div class="cont_testo">
                    <strong>Martino</strong>	
                    <hr>
                    Vincitore gara:	<br>	
                    <strong>European Junior Championships 2015</strong>
                </div>  
            </div>
            <div class="fame fanta">
            	 <div class="puntina">&nbsp;</div>
                 <div class="cropper">
                	<img src="images/Vincitori/Stefano_Guidotti_Icardi.jpg" title="Profilo" alt="Stefano Guidotti Icardi"/><br>
                </div>
                <div class="cont_testo">
                    <strong>steone88</strong>	
                    <hr>
                    Vincitore gara:	<br>	
                    <strong>Campionati Italiani Assoluti 2015</strong>
                </div>  
            </div>
             <div class="fame fanta">
            	 <div class="puntina">&nbsp;</div>
                 <div class="cropper">
                	<img src="images/Vincitori/Matteo_Mercati.jpg" title="Profilo" alt="Matteo Mercati"/><br>
                </div>
                <div class="cont_testo">
                    <p class="team_nome1">MatteMerca21</p>	
                    <hr>
                    Vincitore gara:	<br>	
                    <strong>World Championships Pechino 2015</strong>
                </div>  
            </div>
            
        
        </div>  
    </div>
</div>

       
    </div>
</div>

<?php include 'php/footer4_0.php';?> 
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://www.appelsiini.net/projects/lazyload/jquery.lazyload.js?v=1.9.1"></script>
<script>
$(function() {$("img").lazyload({effect : "fadeIn"});});;
function Espandi(div){if (document.getElementById(div).style.display=='block'){document.getElementById(div).style.display='none';} else{document.getElementById(div).style.display='block';}}
</script> 