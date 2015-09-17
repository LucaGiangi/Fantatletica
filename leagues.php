<?php
/*
Version		author		date		description
2.0.0		L.G			17/09/15	Versione preliminare nuova grafica

*/

$page_name = "leagues";
include "db.inc";

/*$data = date ("Y-m-d");*/
$data = date("Y/m/d G:i:s");
$data_1 = date("Y/m/d");

include "db.inc";
include "php/Gestione_token.php";
include "php/verifica_accesso_g.php";
include "php/logout.php";

include "php/formatta_data.php"; 
include "php/Create_raceRank.php";

include "php/Function/Read_Race.php";
include "php/Function/Tool_leghe.php";

include "php/API_getAvatarByName.php";

function name_by_id_utente($id){
	global $connessione;
	$q="SELECT Nome_team from Giocatore where Id_giocatore='".$id."'";
	$t=mysql_query($q,$connessione);
	while($r=mysql_fetch_object($t)){	
		return $r->Nome_team;
	}	
}
function id_by_nome_utente($nome){
	global $connessione;
	$q="SELECT Id_giocatore from Giocatore where Nome_team='".$nome."'";
	$t=mysql_query($q,$connessione);
	while($r=mysql_fetch_object($t)){	
		return $r->Id_giocatore;
	}	
}
$id_view_gara= array();  /* contiene l'id delle gare attive. Nel caso non ci siano gare attive, si prende la prima gara nello storico*/
$id_view_lega=-1; /* contiene id della prima lega letta */

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
<meta property="og:title" content="Fantatletica by TrackArena.net" />
<meta property="og:description" content="Crea la tua squadra e sfida i tuoi amici. Chi è il più esperto di atletica?" />



<meta name="description" content="Crea la tua squadra, sfida i tuoi amici e scala la classifica.Che aspetti? Prova subito il nuovo FANTATLETICA e la SCHEDINA!">
<meta name="keywords" content="Fantatletica,schedina,sfida i tuoi amici">

<!--  menu -->

<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>

<!--<script src="script/script.js"></script>-->
<!--  menu -->
    
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon"/>
<link rel="icon" href="images/favicon.ico" type="image/x-icon"/>
<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Roboto">
    
<link type="text/css" media="all" href="css/style.css" rel="stylesheet" />
<link type="text/css" media="all" href="css/new_mobile.css" rel="stylesheet" />

<link type="text/css" media="all" href="css/utente.css" rel="stylesheet" />
<link type="text/css" media="all" href="css/classifica.css" rel="stylesheet" />

<link href="css/m_style.css" rel="stylesheet" />
<link href="css/responsive.css" rel="stylesheet" />
<link href='https://fonts.googleapis.com/css?family=Contrail+One' rel='stylesheet' type='text/css'>

  
<title>Fantatletica</title>
</head>


<?php include 'php/header5_0.php';?>  


<?php
	$utenti_in_attesa=view_request($g_id);
	$json_utenti=json_decode($utenti_in_attesa,true); /* decodifico json */
	$i=0;	
	foreach($json_utenti as $u){
		if (sizeof($u[Utenti])>0) 
			print'<div class="body_info" style="margin-top:0px;background:#F00;">
					<div class="call_action_contenuto">
						<div style="width:100%; text-align:center; color:#fff; font-size:28px; margin-top:10px;   margin-bottom: 10px;" > 
							<p class="marginezero">Richieste di amicizia</p>
							<span class="articolo color_white">I seguenti utenti richiedono di poter giocare con te:</span>
							<br/>';
							
		for (;$i< sizeof($u[Utenti]);$i++){
			print'<div class="lega" id='.$i.'>';
            print '<img class="lazy request_ok" src="images/ok.png" onClick="accept_request('.$u[Utenti][$i][Id_utente].','.$u[Utenti][$i][Id_lega].',1,'.$i.');"    title="Conferma" alt="Conferma"/>
					<img class="lazy request_no" src="images/no.png" onClick="accept_request('.$u[Utenti][$i][Id_utente].','.$u[Utenti][$i][Id_lega].',2,'.$i.');"   title="Annulla"  alt="Annulla"/>	
					<div class="lega_info" style="cursor:default;">
						<p class="lega_nome1">'.name_by_id_utente($u[Utenti][$i][Id_utente]).'</p>
						<p class="lega_tool"><i>Lega:'.$u[Utenti][$i][Nome_lega].'</i></p>
					</div>
					
				</div>';
		}
		if (sizeof($u[Utenti])>0) 
			print'</div>  
				</div>
			</div>';
	}         
		
?>
<div class="body_info">
	<div class="call_action_contenuto">
    	<div style="width:100%; text-align:center; font-size:28px; margin-top:10px;   margin-bottom: 10px;" >        
           <?php 
			   	$leghe=Read_leghe($g_id);
				$json_leghe=json_decode($leghe,true); /* decodifico json */
				$i=0;
				foreach($json_leghe as $l){
					for (;$i< sizeof($l[Leghe]);$i++){
						if ($id_view_lega==-1) $id_view_lega=$l[Leghe][$i][Id];
						print'<a href="#classifica" onClick="view_race(25,'.$l[Leghe][$i][Id].');"><div class="lega">';
                		print '<img class="lazy" src="images/default_league.png" data-original="'.$Avatar.'"  title="Profilo" />
									<div class="lega_info">
										<p class="lega_nome1">'.$l[Leghe][$i][Nome].'</p>
										<p class="lega_tool"><i>Giocatori:'.UtentiAttivi($l[Leghe][$i][Id]).'</i></p>
									</div>
								</div></a>';
						if ($i==5){ break;}
								
					}
					if ($i==5){ break;}
				}
			   if ($i==0){
				   print'<p class="color_red">Non fai parte di nessuna lega.</p>
				   		<p><span class="articolo">Le leghe ti permettono di <span class="color_orange articolo"> giocare con i tuoi amici</span>. Crea una nuova lega diventandone amministratore oppure richiedi di poter giocare a una lega già esistente.</span></p>
						
						
						';
			   }
			   ?>       
        
        </div>  
    </div>
</div>

<div class="body_info">
	<div class="call_action_contenuto">
    
    		<?php  
			if ($i==0){// non ci sono leghe
				
							
			}else{// altrimenti mostro la classifica
				print '<div class="titolo"><hh2><a name="classifica"></a>Classifica</hh2></div><br/>         
				<div id="view_race">
					<div class="gara">';
						
						// nome e avatar lega mostrata in classifica
						$Race=Read_race(25);
						$json_o=json_decode($Race,true); /* decodifico json */
						$i=0;
						foreach($json_o as $r){
							for (;$i< sizeof($r[Races]);$i++){
								print '<div class="sx_4col" style="background-color:transparent;"><img class="logo_gara" style="padding-right:20px; padding-bottom:20px;" src="../images/header_gare/'.$r[Races][$i][Header_link].'">
						</div><div class="dx_4col"><h2><articolo>'.$r[Races][$i][Nome].'</articolo></h2>
						<h3>Stato:'.$r[Races][$i][Stato_classifica].'</h3></div>';
							}	
						}
						print'
						<br/>
					</div>
		
					<table id="rank" class="table">
						<thead><tr><th class="chart-rank">Rank<br></th><th>Nickname<br>NomeTeam</th><th class="chart-info">Punti<br></th><th class="chart-pos">Costo team<br></th><th class="chart-prev">Numero team<br></th></tr></thead>
						<tbody data-page="0">';			
						$stringa_rank=Rank($id_view_lega,25); // leggi punteggi atleti
						$json_o=json_decode($stringa_rank,true); /* decodifico json */
						foreach($json_o as $p){ 
							$i=0;            
							for (;$i< sizeof($p[Rank]);$i++){
								$riga=!$riga;		
								if ($g_nome==$p[Rank][$i][Nome])/*$_SESSION['g_user']*/
									print '<tr class="evidenzia">';
								else
									print '<tr>';
									
									//print ($p[$i][username]);
								print '<td style="text-align:center">';
								if ($i==0) print '<img width="30px"  class="gold" src="images/gold.png">'; 
								if ($i==1) print '<img  width="27px" class="silver" src="images/silver.png">';
								if ($i==2) print '<img  width="24px" class="bronze" src="images/bronze.png">';
								
								if ($i>2) print ($i+1)."&deg;"; 
								print'</td><td><div class="title"><a href="#team" onclick="view_team('.$id_view_gara.','.id_by_nome_utente($p[Rank][$i][Nome]).')">'.$p[Rank][$i][Nome].'</a></div><div class="subtitle"></div></td>';
								print '<td style="text-align:center">'.$p[Rank][$i][Punti].'</td>';
								print '<td style="text-align:center">'.$p[Rank][$i][Costo].'</td>';
								print '<td style="text-align:center">'.$p[Rank][$i][Numero].'</td>';
								print'</tr>';	
								//$i++;	
							}
							if ($i==0) print '<tr><td colspan="5">Nessun team presente per questa gara</td></tr>';
						}
						print '
						</tbody>
					</table>
				   
				</div>
				<!--<div class="other_race">Storico gare lega<br/>
					<img href="#classifica" class="lazy" onClick="view_race('.$gara.');" src="images/header_gare/zurigo.jpg"/>
					<img href="#classifica" class="lazy" onClick="view_race('.$gara.');" src="images/header_gare/zurigo.jpg"/>
					<img href="#classifica" class="lazy" onClick="view_race('.$gara.');" src="images/header_gare/zurigo.jpg"/>
					<img href="#classifica" class="lazy" onClick="view_race('.$gara.');" src="images/header_gare/zurigo.jpg"/>
					<img href="#classifica" class="lazy" onClick="view_race('.$gara.');" src="images/header_gare/zurigo.jpg"/>
					<img href="#classifica" class="lazy" onClick="view_race('.$gara.');" src="images/header_gare/zurigo.jpg"/>
					<img href="#classifica" class="lazy" onClick="view_race('.$gara.');" src="images/header_gare/zurigo.jpg"/>
				</div>-->';
					if (count($id_view_gara)>1){
						// stampo l'elenco delle gare giocate in parallelo
						print'<div class="other_race">Altre gare:<br/>';
						foreach ($id_view_gara as $gara){ 
							$Race=Read_race($gara);
							$json_o=json_decode($Race,true); /* decodifico json */		        
							print'<img href="#classifica" class="lazy" onClick="view_race('.$gara.');" src="" data-original="images/header_gare/'.$json_o[0][Races][0][Header_link].'"/>';
							 
						}
						print'</div>';
					}
			}
        	?>
        
    </div>
</div>

<div class="body_info">
	<div class="call_action_contenuto"> 
		<a name="team"></a><div class="team" id="view_team"></div>
    </div>
</div>

<div class="body_info" style="background:#F3AA05;">
	<div class="call_action_contenuto">
    	<div style="width:100%; text-align:center; color:#fff; font-size:28px; margin-top:10px;   margin-bottom: 10px;" >        	            
            <p class="marginezero"><a name="send_request"></a>Unisciti a una lega</p>
			<span class="commenti"><i>Ricerca la lega utilizzando il campo di testo qui sotto e invia la richiesta di amicizia.<br/>La richiesta dovrà essere accettata dall'amministratore della lega.</i></span>  
            <div class="center">                
                <input type="text" class="blu" name="nome_lega" value="" placeholder="Nome lega" id="nome_lega" alt="Nome della lega da cercare" title="Nome della lega da cercare" />
            </div>
            <input onClick="search_league();" type="button" id="button_search" class="search" align="Cerca" title="Cerca" />
            <div id="result_search"></div>  
        </div>  
    </div>
</div>

<div class="body_info" id="new_league">
	<div class="call_action_contenuto">
    	<div style="width:100%; text-align:center; font-size:28px; margin-top:10px; margin-bottom: 10px;" > 
        	<p><a name="new_leagues"></a>Crea la tua lega</p>       
           	
           <!-- <span class="commenti"><i>Carica una nuova immagine per la lega</i></span><br/>
            <input type="file" id="name_file"  name="file"><br/>
            <span class="commenti"><i>o scegliala tra le foto gi&aacute; caricate</i></span><br/>
            <select id="img_select" class="st_input"><option></option><option style="background-image:url(images/default_avatar.png);">iii</option><option>nome1</option></select><br/><br/>-->
            <div class="center">
            	<input type="text" name="nome_lega" value="" placeholder="Nome nuova lega" id="new_nome_lega" />  
            </div>
            <input type="button" onClick="new_lega();" class="add" align="Crea" title="Crea" />
            <div id="notifica_leghe"></div> 
        </div>  
    </div>
</div>


<?php include 'php/footer4_0.php';?>  

<script  src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script  src="http://www.appelsiini.net/projects/lazyload/jquery.lazyload.js?v=1.9.1"></script>
<script>$(function() {$("img").lazyload({effect : "fadeIn"});});;</script> 

<script>
function search_league(){
var nome=document.getElementById('nome_lega').value;
if (nome!=""){
	document.getElementById('button_search').style.display="none";
	document.getElementById('result_search').innerHTML='<img src="images/load.gif" alt="Attendi" title="Attendi"/>';
	var xmlhttp;
	if (window.XMLHttpRequest){xmlhttp=new XMLHttpRequest();}
	else if (window.ActiveXObject){xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	else{alert("Il browser non supporta XMLHTTP");}
	
	xmlhttp.onreadystatechange=function()
	{if(xmlhttp.readyState==4){document.getElementById('button_search').style.display="inline";document.getElementById('result_search').innerHTML=xmlhttp.responseText;}}
	xmlhttp.open("GET","php/Ajax/search_leagues.php?name="+nome,true);
	xmlhttp.send(null);
}

}
function new_lega(){
var utente="<?php print $g_id; ?>";	
var nome=document.getElementById('new_nome_lega').value;

document.getElementById('notifica_leghe').innerHTML="";
document.getElementById('new_league').style.backgroundColor = "#ffffff";
var xmlhttp;
if (window.XMLHttpRequest){xmlhttp=new XMLHttpRequest();}
else if (window.ActiveXObject){xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
else{alert("Il browser non supporta XMLHTTP");}
xmlhttp.onreadystatechange=function()
{if(xmlhttp.readyState==4){
	if (xmlhttp.responseText=="La lega è stata creata")document.getElementById('new_league').style.backgroundColor = "#A6E97B";
	document.getElementById('notifica_leghe').innerHTML=xmlhttp.responseText;
	}}
xmlhttp.open("GET","php/Ajax/new_leagues.php?name="+nome+"&id="+utente,true);
xmlhttp.send(null);
}

function confirm_request(id){document.getElementById(id).innerHTML='<p style="cursor:pointer" onclick="send('+id+');">Clicca per confermare</p>';}
function accept_request(id,id_lega,val,bloc){
	var utente="<?php print $g_id; ?>";	
var xmlhttp;
if (window.XMLHttpRequest){xmlhttp=new XMLHttpRequest();}
else if (window.ActiveXObject){xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
else{alert("Il browser non supporta XMLHTTP");}
xmlhttp.onreadystatechange=function()
{if(xmlhttp.readyState==4){document.getElementById(bloc).innerHTML=xmlhttp.responseText;}}
xmlhttp.open("GET","php/Ajax/accept_leagues.php?lega="+id_lega+"&id="+id+"&val="+val,true);
xmlhttp.send(null);
}
function send(id){
var utente="<?php print $g_id; ?>";	
var xmlhttp;
if (window.XMLHttpRequest){xmlhttp=new XMLHttpRequest();}
else if (window.ActiveXObject){xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
else{alert("Il browser non supporta XMLHTTP");}
xmlhttp.onreadystatechange=function()
{if(xmlhttp.readyState==4){document.getElementById(id).innerHTML=xmlhttp.responseText;}}
xmlhttp.open("GET","php/Ajax/send_request_leagues.php?name="+utente+"&id="+id,true);
xmlhttp.send(null);	
}
function view_team(id,utente){
document.getElementById('view_team').innerHTML='<img src="images/load.gif" alt="Attendi" title="Attendi"/>';
var xmlhttp;
if (window.XMLHttpRequest){xmlhttp=new XMLHttpRequest();}
else if (window.ActiveXObject){xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
else{alert("Il browser non supporta XMLHTTP");}
xmlhttp.onreadystatechange=function()
{if(xmlhttp.readyState==4){document.getElementById('view_team').innerHTML=xmlhttp.responseText;}}
xmlhttp.open("GET","php/Ajax/view_team.php?id="+id+"&utente="+utente,true);
xmlhttp.send(null);
}
function view_race(id,lega){
var utente="<?php print $g_nome; ?>";
var xmlhttp;
if (window.XMLHttpRequest){xmlhttp=new XMLHttpRequest();}
else if (window.ActiveXObject){xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
else{alert("Il browser non supporta XMLHTTP");}

xmlhttp.onreadystatechange=function()
{if(xmlhttp.readyState==4){document.getElementById('view_race').innerHTML=xmlhttp.responseText;}}
xmlhttp.open("GET","php/Ajax/view_race.php?id="+id+"&utente="+utente+"&lega="+lega,true);
xmlhttp.send(null);
}
</script>

     

