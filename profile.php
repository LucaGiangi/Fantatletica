<?php
/*
Version		author		date		description
2.0.0		L.G.		17/09/15	Versione preliminare nuova grafica

*/

$page_name = "profile";
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


$id_view_gara= array();  /* contiene l'id delle gare attive. Nel caso non ci siano gare attive, si prende la prima gara nello storico*/
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


<div class="header_utente">
	 
    
	<div style=" background:url(images/corsa.jpg);background-size:100%;background-position: center center;" class="copertina">
    	<h2 class="name_level1"><?php print $g_nome ?></h2><h3>livello:1</h3>
    </div>
	<div class="notifiche">
    	<div class="call_action_contenuto" style="text-align:center;">
  			<h2 class="name_level"><?php print $g_nome ?></h2><h3>livello:1<br/></h3>
    	</div>
    </div>
    
    <div class="header_m">
    	 <?php 
	
	print '<div id="toolbar">
		<div id="menu" >
        	<div class="menu-principale-container contenuto">';          
                include "php/headerMENU4_0.php"; 
                  
			print' </div>
         </div>
		<div id="expand">
			<a href="#" id="more"></a>
		</div>
	</div>';

	?> 
    </div>
    
    <div class="call_action_contenuto">
    <div style="background:url(<?php print $g_avatar; ?>) no-repeat;background-size:100% 100%;" class="avatar" ></div>
    </div>
</div>

<!--  body info -->
<div class="body_info" style="margin-top:20px;">
	<div class="call_action_contenuto">
    	<!--<h1>Calendario</h1>  -->
        
        <?php    
		//leggi gare
		$Races=Read_futureRace($data_1);
		$json_o=json_decode($Races,true); /* decodifico json */
		$i=0;
		foreach($json_o as $r){
			for (;$i< sizeof($r[Races]);$i++){
				print'
				<div class="calendario '; if ($i<2) print 'margin_right'; print'"> 
					<div class="gara">
						<div class="gara_contenuto">
						
							<div class="calendario_top">
								<img class="lazy" height="100%" src="" data-original="images/header_gare/'.$r[Races][$i][Header_link].'"></div>
							</div>   
							<div class="calendario_bottom">
								<h4>'.$r[Races][$i][Nome].'</h4>
								<articolo>
								Apertura: '.formatta_data($r[Races][$i][Inizio_formazione]).'<br/> Chiusura: '.formatta_data($r[Races][$i][Termine_formazione]).'
								</articolo><br>';
								
					// mostro il tasto solo prima che la competizione sia chiusa
					if ((strtotime($r[Races][$i][Termine_formazione])>=strtotime($data)) )
						if 	($r[Races][$i][Attiva]){
							print'<a href="g-home-team.php" ><div class="button" >Gioca</div></a> ';  
							if (($r[Races][$i][Type]==0)) $id_view_gara[]=$r[Races][$i][Id]; // id delle gare attiv
						}else print '<div class="button enable_false" >Gioca</div>';
									
					print'			</div>         
								 
						</div> 
				</div>';
			}
		}
		
		for($j=0;$j<(3-$i);$j++){	//completa le tre gare
			print'
				<div class="calendario '; if ($j<(3-$i)-1) print 'nascondiC margin_right'; print'"> 
					<div class="gara">
						<div class="gara_contenuto">
							<div class="calendario_top">
								<img  height="100%" src="images/logo1.png" title="fantatletica" alt="fantatletica"></div>
							<div class="calendario_bottom">
							<h4>Continua a seguirci..</h4>
                				<articolo>A breve pubblicheremo le prossime date delle competizioni!<br/><br/></articolo>
							</div>         
							
						</div>    
					</div> 
				</div>';		
		}
?>
    	      

	</div>
</div>


<div class="body_info line_blu">
	<div class="call_action_contenuto">
    	<div style="width:100%; text-align:center; color:#fff; font-size:28px; margin-top:10px;   margin-bottom: 10px;" >
            <p>Leghe<br/><span class="budget"><a href="leagues.php">Guarda le tue leghe</a></span></p>
            
           <?php 
			   	$leghe=Read_leghe($g_id);
				$json_leghe=json_decode($leghe,true); /* decodifico json */
				$i=0;
				foreach($json_leghe as $l){
					for (;$i< sizeof($l[Leghe]);$i++){
						print'<a href="leagues.php"><div class="lega">';
                		print '<img class="lazy" src="images/default_league.png" data-original="'.$Avatar.'"  title="Profilo" />
									<div class="lega_info">
										<p class="lega_nome1">'.$l[Leghe][$i][Nome].'</p>
										<p class="lega_tool"><i>Giocaori:'.UtentiAttivi($l[Leghe][$i][Id]).'</i></p>
									</div>
								</div></a>';
						if ($i==5){break;}
								
					}
					if ($i==5){break;}
				}
			   if ($i==0) print'Non fai parte di nessuna lega. Crea una nuova lega diventandone amministratore oppure richiedi di poter giocare a una lega già esistente';
			   ?>                   
        </div>  
    </div>
</div>

<div class="body_info">
	<div class="call_action_contenuto">        
		<div class="sx_4col">        
			<div class="titolo" onclick="Espandi('storico')" ><hh2>Storico <img class="espandi" style="top:5px;" src="images/freccia_1.png"></hh2></div>
            
			<div class="nascondi_testo" id="storico" >
				
				  <?php
                $Races=Read_pastRace_fanta($data);
                $json_o=json_decode($Races,true); /* decodifico json */
                $i=0;
                foreach($json_o as $r)
                    for (;$i< sizeof($r[Races]);$i++){
                        if (count($id_view_gara)==0 && ($r[Races][$i][Type]==0)) $id_view_gara[]=$r[Races][$i][Id]; // id della prima gara nello storico (ultima giocata)
                        print '<a href="#classifica" onClick="view_race('.$r[Races][$i][Id].');"><img class="lazy img_race" src="" data-original="../images/header_gare/'.$r[Races][$i][Header_link].'" title="'.$r[Races][$i][Nome].'" alt="'.$r[Races][$i][Nome].'"></a>';
                    }
                ?>  
            </div>
        </div>
                    
		<div class="dx_4col">
			<div class="titolo"><hh2><a name="classifica"></a>Classifica</hh2></div><br/>
            
            <div id="view_race">
                <div class="gara">
                    <?php 
                    $Race=Read_race($id_view_gara[0]);
                    $json_o=json_decode($Race,true); /* decodifico json */
                    $i=0;
                    foreach($json_o as $r){
                        for (;$i< sizeof($r[Races]);$i++){
                            print '<div class="sx_4col" style="background-color:transparent;"><img class="logo_gara" style="padding-right:20px; padding-bottom:20px;" src="../images/header_gare/'.$r[Races][$i][Header_link].'">
                    </div><div class="dx_4col"><h2><articolo>'.$r[Races][$i][Nome].'</articolo></h2>
                    <h3>Stato:'.$r[Races][$i][Stato_classifica].'</h3></div>';
                        }	
                    }
                    ?>
                    <br/>
                </div>
    
                <table id="rank" class="table">
                    <thead><tr><th class="chart-rank">Rank<br></th><th>Nickname<br>NomeTeam</th><th class="chart-info">Punti<br></th><th class="chart-pos">Costo team<br></th><th class="chart-prev">Numero team<br></th></tr></thead>
                    <tbody data-page="0">
                <?php			
                $stringa_rank=Rank(NULL,$id_view_gara[0]); // leggi punteggi atleti
                $json_o=json_decode($stringa_rank,true); /* decodifico json */
                foreach($json_o as $p){
                    
                    $punt=0;
                    for ($i=0;$i< sizeof($p[Rank]);$i++)
                        if ($g_nome==$p[Rank][$i][Nome]){$punt=$i; break;}
                    
                    $start=$punt-2;
                    $end=3;
                    
                    if ($punt<2){$start=0;$end=(5-$punt);}
                    
                    if ($punt>sizeof($p[Rank])-3){$end=(sizeof($p[Rank])-$punt);$start=sizeof($p[Rank])-5;}
                    
                    
                    for ($i=$start;$i< $end+$punt;$i++){
                        $riga=!$riga;		
                        if ($g_nome==$p[Rank][$i][Nome])/*$_SESSION['g_user']*/
                            {print '<tr class="evidenzia">';}
                        else
                            print '<tr>';
                            
                            //print ($p[$i][username]);
                        print '<td style="text-align:center">';
                        if ($i==0) print '<img width="15px"  class="gold" src="images/gold.png">'; 
                        if ($i==1) print '<img  width="15px" class="silver" src="images/silver.png">';
                        if ($i==2) print '<img  class="bronze" src="images/bronze.png">';
                        
                        if ($i>2) print ($i+1)."&deg;"; 
                        print'</td><td><div class="title">'.$p[Rank][$i][Nome].'</div><div class="subtitle"></div></td>';
                        print '<td style="text-align:center">'.$p[Rank][$i][Punti].'</td>';
                        print '<td style="text-align:center">'.$p[Rank][$i][Costo].'</td>';
                        print '<td style="text-align:center">'.$p[Rank][$i][Numero].'</td>';
                        print'</tr>';	
                        //$i++;	
                    }
                }
    ?>
    
                    </tbody>
                </table>
                <?php print'<a href="raceRank.php?id='.$id_view_gara[0].'"><span class="budget">Classifica completa</span></a>' ?> 
			</div>
            <?php 	 
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
        	?>
        </div>
		 
    </div>
</div>



<div class="body_info">
	<div class="call_action_contenuto"> 
		<div class="team" id="view_team">
			<div class="titolo"><hh2>Il tuo team</hh2></div>
			<?php	
            $q="SELECT * FROM Team 
                    JOIN Iscritti ON Iscritti.Id_iscritti= Team.Iscritti_Id_iscritti
                    JOIN Atleti ON Iscritti.Atleti_id_atleti = Atleti.Id_Atleta where (Team.Giocatore_Id_giocatore='".$g_id."' and Iscritti.Competizione_Id_competizione='".$id_view_gara[0]."') order by Capitano";
            $t=mysql_query($q,$connessione); 	
            while($r=mysql_fetch_object($t)){
                getAvatarByName($r->Nome,$r->Cognome);
                $Avatar = $array_avatar[0];
                if ($r->Capitano==0){							
                            print'<div class="ischomeiscritti">';	
							print '<div class="team_name_race">'.$r->Prima_gara.'</div>
							<div class="bandiera" ><img class="lazy" src="" data-original="images/Flags/'.$r->Nationality.'.png"/></div>
							<img class="lazy" src="images/default_avatar.png" data-original="'.$Avatar.'"  title="Profilo" />
							<div class="team_info">
											<p class="team_nome1">'.$r->Cognome.'</p>
											<p class="team_nome1">'.$r->Nome.'</p>
											<p class="team_tool">Capitano</p>
							</div>';                      	
                        if ($r->Prima_gara==$r->Gara_Gara1 && $r->Risultato_punti!=0) print '<div class="team_name_race">'.($r->Risultato_punti*2).' Punti</div>';
                        if ($r->Prima_gara==$r->Gara_Gara2 && $r->Risultato_classifica!=0) print '<div class="team_name_race">'.($r->Risultato_classifica*2).' Punti</div>';
                        print'</div>';
                }
                else{	
                        print'<div class="ischomeiscritti">';	
							print '<div class="team_name_race">'.$r->Prima_gara.'</div>
							<div class="bandiera" ><img class="lazy" src="" data-original="images/Flags/'.$r->Nationality.'.png"/></div>
							<img class="lazy" src="images/default_avatar.png" data-original="'.$Avatar.'"  title="Profilo" />
							<div class="team_info">
											<p class="team_nome1">'.$r->Cognome.'</p>
											<p class="team_nome1">'.$r->Nome.'</p>
											<p class="team_tool">i</p>
							</div>';                      	
                        if ($r->Prima_gara==$r->Gara_Gara1 && $r->Risultato_punti!=0) print '<div class="team_name_race">'.$r->Risultato_punti.' Punti</div>';
                        if ($r->Prima_gara==$r->Gara_Gara2 && $r->Risultato_classifica!=0) print '<div class="team_name_race">'.$r->Risultato_classifica.' Punti</div>';
                        print'</div>';
                    }
            }//while		
                ?>   
            
   		</div>

		<br/><br/>   
    </div>
</div>
<?php include 'php/footer4_0.php';?>  

<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://www.appelsiini.net/projects/lazyload/jquery.lazyload.js?v=1.9.1"></script>
<script>
$(function() {$("img").lazyload({effect : "fadeIn"});});;
function Espandi(div){if (document.getElementById(div).style.display=='block'){document.getElementById(div).style.display='none';} else{document.getElementById(div).style.display='block';}}
</script> 

<script>
function view_race(id,utente){
var utente="<?php print $g_nome; ?>";
var xmlhttp;
if (window.XMLHttpRequest){xmlhttp=new XMLHttpRequest();}
else if (window.ActiveXObject){xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
else{alert("Il browser non supporta XMLHTTP");}

xmlhttp.onreadystatechange=function()
{if(xmlhttp.readyState==4){document.getElementById('view_race').innerHTML=xmlhttp.responseText;}}
xmlhttp.open("GET","php/Ajax/view_race.php?id="+id+"&utente="+utente,true);
view_team(id);
xmlhttp.send(null);
}
function view_team(id){
var utente="<?php print $g_id; ?>";
var xmlhttp;
if (window.XMLHttpRequest){xmlhttp=new XMLHttpRequest();}
else if (window.ActiveXObject){xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
else{alert("Il browser non supporta XMLHTTP");}
xmlhttp.onreadystatechange=function()
{if(xmlhttp.readyState==4){document.getElementById('view_team').innerHTML=xmlhttp.responseText;}}
xmlhttp.open("GET","php/Ajax/view_team.php?id="+id+"&utente="+utente,true);
xmlhttp.send(null);
}
</script>

     

