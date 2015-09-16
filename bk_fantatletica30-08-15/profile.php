<?php
$page_name = "profile";
include "db.inc";
//versione 1.0 responsitive
/* 1.0->17/08/15

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

<link type="text/css" media="all" href="css/utente.css" rel="stylesheet" />
<title>Fantatletica</title>
</head>


<?php include 'php/header4_0.php';?>  

<div class="header_utente">
	<div class="copertina">
    
    </div>
	<div class="notifiche">
    
    </div>
    <div class="avater">
    
    </div>
</div>
<!--  body info -->
<div class="body_info">
	<div class="call_action_contenuto">
    <h1>Prossima gare</h1>
    
    <div class="calendario">
    
    	<div class="gara">
        	<div class="gara_contenuto"><div class="ab_sx">
				<h2>World Championships</h2><articolo>Le iscrizioni aprono il 16 Agosto alle 21:00 e chiuderanno il 22 Agosto alle 01:35.
Il budget a disposizione è di: 1200.</articolo><br><a href="g-home-team.php" ><div class="button" >Gioca</div></a></div>         
                <div class="ab_dx"><img  width="100%" src="images/header_gare/Pechino_2015"><br/><br/><span>Premi:</span><br/><a href="http://www.fantatletica.it/blog/2015/08/10/pronti-per-i-campionati-mondiali-schedina-aperta-a-tutti-e-premio-per-il-fantatletica/" target="new"><img  width="100%" src="images/Premi/Pechino-2015.png"></a></div>
            </div>    
   		</div> 

    </div>
    
    
	    <div class="calendario">
    
    	<div class="gara">
        	<div class="gara_contenuto"><div class="ab_sx">
				<h2>World Championships</h2><articolo>Le iscrizioni aprono il 16 Agosto alle 21:00 e chiuderanno il 22 Agosto alle 01:35.
Il budget a disposizione è di: 1200.</articolo><br><a href="g-home-team.php" ><div class="button" >Gioca</div></a></div>         
                <div class="ab_dx"><img  width="100%" src="images/header_gare/Pechino_2015"><br/><br/><span>Premi:</span><br/><a href="http://www.fantatletica.it/blog/2015/08/10/pronti-per-i-campionati-mondiali-schedina-aperta-a-tutti-e-premio-per-il-fantatletica/" target="new"><img  width="100%" src="images/Premi/Pechino-2015.png"></a></div>
            </div>    
   		</div> 

    </div>
    
        <div class="calendario">
    
    	<div class="gara">
        	<div class="gara_contenuto"><div class="ab_sx">
				<h2>World Championships</h2><articolo>Le iscrizioni aprono il 16 Agosto alle 21:00 e chiuderanno il 22 Agosto alle 01:35.
Il budget a disposizione è di: 1200.</articolo><br><a href="g-home-team.php" ><div class="button" >Gioca</div></a></div>         
                <div class="ab_dx"><img  width="100%" src="images/header_gare/Pechino_2015"><br/><br/><span>Premi:</span><br/><a href="http://www.fantatletica.it/blog/2015/08/10/pronti-per-i-campionati-mondiali-schedina-aperta-a-tutti-e-premio-per-il-fantatletica/" target="new"><img  width="100%" src="images/Premi/Pechino-2015.png"></a></div>
            </div>    
   		</div> 

    </div>
    
	</div>
</div>


<div class="body_info">
	<div class="call_action_contenuto">        
			<div class="sx_2col">        
                  
                  <table id="rank" class="table">
				<thead>
					<tr><th class="chart-art artwork-th"></th>
                    <th class="chart-rank">Rank<br></th>
					<th>Nickname<br>NomeTeam</th>
					<th class="chart-info">Punti<br></th>
					<th class="chart-pos">Costo team<br></th>
					<th class="chart-prev">Numero team<br></th>
				
				</tr></thead>
				<tbody data-page="0">
		<tr data-id="108785">
			<td class="chart-art"><img class="artwork" src="./FIMI - Classifiche - FIMI_files/UMG_cvrart_00602547425416_01_RGB72_1500x1500_15UMGIM28639.400x400-75.jpg"></td>
			
            <td class="chart-rank">1</td>
            <td class="chart-titolo">
				<div class="title">VERO</div>
				<div class="subtitle">GUE PEQUENO</div>
			</td>
			<td class="chart-info"><div class="info">DEF JAM RECORDINGS<br>UNIVERSAL MUSIC</div></td>
			<td class="chart-pos">1</td>
			<td class="chart-prev"><span class="pos-new">NEW</span></td>
		
		</tr>
	
		<tr data-id="108786">
			<td class="chart-art"><img class="artwork" src="./FIMI - Classifiche - FIMI_files/8051414537202.100x100-75.jpg"></td>
          <td class="chart-rank">1</td>
			<td class="chart-titolo">
				<div class="title">OUT</div>
				<div class="subtitle">THE KOLORS</div>
			</td>
			<td class="chart-info"><div class="info">BARAONDA EDIZIONI MUSICALI<br>BARAONDA EDIZIONI MUSICALI</div></td>
			<td class="chart-pos">2</td>
			<td class="chart-prev">1</td>
			
		</tr>

	</tbody>
			</table>
                  
                  
                  
                           
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
              <p>Campionati Italiani Assoluti</p>
            <img src="images/header_gare/Fidal_1.png" width="223" alt="Manifestazione"/>
            
        </div>
        
        <div class="rank2 rank_spazio rank_margin">
            <div class="cropperb didascalia">
                <img src="images/Atleti/Sebastiano_Bianchetti.jpg" title="Sebastiano Bianchetti" alt="Sebastiano Bianchetti"  />
                <span class="articolo">Sebastiano Bianchetti<br/>9 giocatori</span> 
            </div>  
        </div>
            
        <div class="rank2">
            <div class="croppera didascalia">
                <img src="images/Atleti/Desiree_Rossit.jpg" title="Desiree Rossit" alt="Desiree Rossit"  />
                <span class="articolo">Desiree Rossit<br/> 9 giocatori</span>
            </div>
        </div>
            
        <div class="rank2" >
            <div class="cropperc didascalia">
                <img src="images/Atleti/Giordano_Benedetti.jpg" title="Giordano Benedetti" alt="Giordano Benedetti" />
                <span class="articolo">Giordano Benedetti<br/>9 giocatori</span>  
            </div>
        </div>
        <p>&nbsp;</p><p>&nbsp;</p>
     		 
    </div>   
</div>

<?php include 'php/footer4_0.php';?>  
<!-- <script type="text/javascript" src="http://www.atletipercaso.net/wp-content/themes/Iris/scripts/snap.min.js"></script>-->
<!-- <script src="script/swipe.js"></script> -->
     

