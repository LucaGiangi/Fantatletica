<?php
$page_name = "profile";
include "db.inc";
//versione 1.0 responsitive
/* 1.0->17/08/15

*/

/*$data = date ("Y-m-d");*/
$data = date("Y/m/d G:i:s");
$data_1 = date("Y/m/d");

include "db.inc";
include 'php/Gestione_token.php';
include 'php/verifica_accesso_g.php';
include "php/logout.php";

include "php/formatta_data.php"; 
include "php/Create_raceRank.php";

include "php/Function/Read_Race.php";
include "php/Function/Tool_leghe.php";


$id_view_gara=-1;  /* contiene l'id della prima gara trovata attiva. Nel caso non ci siano gare attive, si prende la prima gara nello storico*/
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
<script src="script/script.js"></script>
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
	 
    <?php  print 'il tuo avatar :'.$g_avatar; ?>
	<div style="background:url(<?php print $g_avatar; ?>) no-repeat;background-size:100%;background-position: center center;" class="copertina">
    	<h2 class="name_level1"><?php print $g_nome ?>&nbsp;Lv:1</h2>
    </div>
	<div class="notifiche">
    	<div class="call_action_contenuto" style="text-align:center;">
  			<h2 class="name_level"><?php print $g_nome ?>&nbsp;Lv:1</h2>
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
<div class="body_info">
	<div class="call_action_contenuto">
    	<!--<h1>Calendario</h1>  -->
        
        <?php    
		//leggi gare
		$Races=Read_futureRace($data);
		$json_o=json_decode($Races,true); /* decodifico json */
		$i=0;
		foreach($json_o as $r){
			for (;$i< sizeof($r[Races]);$i++){
				print'
				<div class="calendario '; if ($i<2) print 'margin_right'; print'"> 
					<div class="gara">
						<div class="gara_contenuto"><div class="ab_sx">
							<h2>'.$r[Races][$i][Nome].'</h2>
							<articolo></articolo><br>';
				if 	($r[Races][$i][Attiva]){ 
					print'<a href="g-home-team.php" ><div class="button" >Gioca</div></a> ';  
					if ($id_view_gara==-1) $id_view_gara=$r[Races][$i][Id]; // id della prima gara attiva
				}else print '<div class="button enable_false" >Gioca</div>';
							
							
				print'			</div>         
							<div class="ab_dx">
							<img  width="100%" src="images/header_gare/'.$r[Races][$i][Header_link].'"></div>
						</div>    
					</div> 
				</div>';
			}
		}
		
		for($j=0;$j<(3-$i);$j++){	//completa le tre gare
			print'
				<div class="calendario '; if ($j<(3-$i)-1) print 'nascondiC margin_right'; print'"> 
					<div class="gara">
						<div class="gara_contenuto"><div class="ab_sx">
							<h2>Continua a seguirci..</h2>
                <articolo>A breve pubblicheremo le prossime date delle competizioni a cui potrai partecipare<br/><br/></articolo>
							</div>         
							<div class="ab_dx">
							<img  width="100%" src="images/logo1.png"></div>
						</div>    
					</div> 
				</div>';		
		}
?>
    	      

	</div>
</div>


<div class="body_info">
	<div class="call_action_contenuto">        
		<div class="sx_3col">        
			  <!--<p><h1>Leghe</h1></p>--><div class="titolo"><hh2>Leghe</hh2></div><br/>
               
               <?php 
			   	$leghe=Read_leghe($g_id);
				$json_leghe=json_decode($leghe,true); /* decodifico json */
				$i=0;
				foreach($json_leghe as $l){
					for (;$i< sizeof($l[Leghe]);$i++){
						print ' <a href="#"><div class="lega_ico">';
               			if ($l[Leghe][$i][Admin]==$g_id) print	'<div class="lega_nRic">'.UtentiInAttesa($l[Leghe][$i][Id]).'</div>';
                		print '	<div class="lega_nUt">'.UtentiAttivi($l[Leghe][$i][Id]).'</div>
								<div class="lega_nome">'.$l[Leghe][$i][Nome].'</div>
              					</div></a>';
					}
				}
			 // Add_leghe(257,"Lega fantatletica");
			   if ($i==0) print'Nessuna lega. "link" e crea lega';
			   ?>           
		</div>
                    
		<div class="dx_3col">
        	<div class="titolo"><hh2>Classifica</hh2></div><br/>      
            <div class="gara">
				<div>
                	<img class="logo_gara" style="padding-right:20px; padding-bottom:20px;" src="../images/header_gare/Fidal_1">
					<h2><articolo>nome manifestazione prova</articolo></h2>
					<h3>stato:Ufficiale</h3>
					<a href=""><span class="budget">Classifica completa</span></a>
					<br/>
				</div>
			</div>
			
            <table id="rank" class="table">
				<thead><tr><th class="chart-rank">Rank<br></th><th>Nickname<br>NomeTeam</th><th class="chart-info">Punti<br></th><th class="chart-pos">Costo team<br></th><th class="chart-prev">Numero team<br></th></tr></thead>
                <tbody data-page="0">
			<?php			
            $stringa_rank=Rank(NULL,13); // leggi punteggi atleti
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
		</table>';








			<?php //include 'php/classifica4_1.php'; ?> 
            
            
            
            
            
             
		</div>
               
		<br/><br/>   
    </div>
</div>


<div class="body_info line_blu">
	<div class="call_action_contenuto">
    	<div style="width:100%; text-align:center; color:#fff; font-size:28px; margin-top:10px;   margin-bottom: 10px;" >
            <p>Storico</p>
            
            <?php
			$Races=Read_pastRace($data);
			$json_o=json_decode($Races,true); /* decodifico json */
			$i=0;
			foreach($json_o as $r)
				for (;$i< sizeof($r[Races]);$i++){
					print '<img class="img_race" src="../images/header_gare/'.$r[Races][$i][Header_link].'" title="'.$r[Races][$i][Nome].'" alt="'.$r[Races][$i][Nome].'">';
				}
			?>       
            <br/><br/>
  
            
        </div>  
    </div>
</div>



<?php include 'php/footer4_0.php';?>  

<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://www.appelsiini.net/projects/lazyload/jquery.lazyload.js?v=1.9.1"></script>
<script>
 $(function() {

          $("img").lazyload({

              effect : "fadeIn"

          });

      });;
</script> 
<!-- <script type="text/javascript" src="http://www.atletipercaso.net/wp-content/themes/Iris/scripts/snap.min.js"></script>
<script src="script/swipe.js"></script>-->
     

