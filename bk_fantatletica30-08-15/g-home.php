<?php
$page_name = "g-home";
//versione 4.1 responsitive

//($_SESSION['id_competizione']!=-1)  usato per verificare la possibilità di modificare la squadra
session_start();

/*$data = date ("Y-m-d");*/
$data = date("Y/m/d G:i:s");
$data_1 = date("Y/m/d");
include "db.inc";


include "php/verifica_gara.php"; /* cerca se esiste una gara attiva */
include "php/Create_raceRank.php";
include "php/formatta_data.php"; 
// header('Location:Thank_you.php');
$Errore ="";
// esci dalla sezione admin
/*
if ($_GET['cod']=="esci"){
	session_destroy();
	header('Location:index.php');	
}*/

include 'php/Gestione_token.php';
include 'php/verifica_accesso_g.php';
include "php/logout.php";
//**************************
/* verifico se ho gia creato un team */
/* $team_creato=false; definito file sotto*/
$team_creato=false;
include 'php/verifica_team_creato.php';

//print "Ciao fede".$g_id;
?>
<!doctype html>
<html lang="it-IT">
<head>
<meta charset="utf-8">

 <meta http-equiv="x-ua-compatible" content="IE=edge" />
        <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-touch-fullscreen" content="yes">

<!-- <script src="script/jquery-1.11.1.min.js"></script>-->
 
 <!--  menu -->
   <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
   <script src="script/script.js"></script>
   <!--  menu -->
    
	<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon"/>
	<link rel="icon" href="images/favicon.ico" type="image/x-icon"/>
    
<link type="text/css" media="all" href="css/style.css" rel="stylesheet" />
<link type="text/css" media="all" href="css/new_mobile.css" rel="stylesheet" />
<link type="text/css" media="all" href="css/tabelle.css" rel="stylesheet" />
<meta property="og:title" content="Home - Fantatletica" />
<title>Home - Fantatletica</title>
</head>


 <?php include 'php/header4_0.php';?>  

<!--  body info -->
<div class="body_info">
	<div class="call_action_contenuto">
    
    <!--	<div style="background:rgba(200,200,200,0.7); padding:10px;">
         
        <h2>Avvisi</h2>
        <p> <span class="budget"> Congratulazioni</span>, sei rientrato tra i primi 50 utenti che potranno provare in escusiva il fantatletica!<br>
         presto riceverai una mail con tutte le info per giocare la prima partita.</p>
         <p><span class="budget">Il Brixia Meeting ti aspetta!!</span></p>
         
              </div>-->
    
    <!-- ********************* -->
   
     <div class="col_sx">
     	<div class="titolo"><hh2>Prossime tappe</hh2></div>
     	
      <?php 
	    $cont=0;
		$q="SELECT * FROM Competizione where Termine_formazione>='".$data."' and Type<2 order by Data_inizio LIMIT 0,3";
		
		$t=mysql_query($q,$connessione); 	
		while($r=mysql_fetch_object($t)){
       
	   print'
	    <div class="gara">
        	<div class="gara_contenuto">';
			if ($cont!=0) print ' <hr>';
            	print '<div class="ab_sx">
				<h2>'.$r->Nome.'</h2>';
                 
				 if ($r->Type==1) 
				  print'<articolo> Gioca la tua schedina!.<br>I pronostici aprono il '.formatta_data($r->Inizio_formazione).' e chiuderanno il '.formatta_data($r->Termine_formazione).'.<br></articolo><br>';
				 else
				 print'<articolo>   Crea la tua squadra per '.$r->Nome.'<br> Le iscrizioni aprono il '.formatta_data($r->Inizio_formazione).' e chiuderanno il '.formatta_data($r->Termine_formazione).'.<br>
Il budget a disposizione è di: '.$r->Budget.'.</articolo><br>';
                	
					
               if ((strtotime($r->Inizio_formazione)<strtotime($data)) && (strtotime($r->Termine_formazione)>strtotime($data)) ) { 
			   		
					if ($r->Type==1 ) /*  type =2 -> competizione di prova su cui admin sta facendo test */
						print '<a href="Schedina.php" ><div class="button" >Gioca</div></a>';
					else{
						print '<a href="'; if ($team_creato) print 'g-home-team.php'; else print'g-team_new.php?id='.$r->Id_competizione ;print '" ><div class="button" >Gioca</div></a>';}
			   }
			   else
			   		print '<div class="button enable_false" >Gioca</div>';
			    print'</div>         
                <div class="ab_dx">'; 
				if ($r->Header_link!="") print '<img  width="100%" src="images/header_gare/'.$r->Header_link.'">';
				if ($r->Id_competizione ==21) print '<br/><br/><span>Premi:</span><br/><a href="http://www.fantatletica.it/blog/2015/08/10/pronti-per-i-campionati-mondiali-schedina-aperta-a-tutti-e-premio-per-il-fantatletica/" target="new"><img  width="100%" src="images/Premi/Pechino-2015.png"></a>';
				
				else{
					 print '<img  width="100%" src="images/logo1.png">';}	
				
				print'</div>
            </div>    
   		</div>';
		$cont++;
	}
	
	   ?> 
       <!-- ********************** -->
        <div class="gara">
        	<div class="gara_contenuto">
            <p>&nbsp;</p><p>&nbsp;</p>
			 <hr>
            	<div class="ab_sx">
				<h2>Continua a seguirci..</h2>
                <articolo>A breve pubblicheremo le prossime date delle competizioni a cui potrai partecipare<br/><br/></articolo>
       			</div>
                <div class="ab_dx">
					<img  width="100%" src="images/logo1.png">	
				</div>
            </div>
        </div>
       <!-- ******************* -->
	  </div>
      <!-- punti -->
       
       <div class="col_dx">
           		
                <?php 
		$nome_comp="";   
	    $cont=0;
		/* considero una gara in corso fino a 4 giorni dopo la sua fine */
		$q="SELECT * FROM Competizione where (Termine_formazione<='".$data."' and Data_fine + INTERVAL 3 DAY>='".$data_1."'  and Type<2) order by Data_inizio LIMIT 0,3";
		$t=mysql_query($q,$connessione); 	
		while($r=mysql_fetch_object($t)){ 
			$nome_comp=$r->Nome;
			   print'
				<div class="gara">
					<div class="gara_contenuto">';
					if ($cont==0) print '<div class="titolo"><hh2>In corso</hh2></div>';
					if ($cont!=0) print ' <hr>';
						print '<div class="ab_sx">
						<h2>'.$r->Nome.'</h2><h4>'.formatta_data($r->Data_fine).'</h4>';
						
					 if ($r->Type!=1)  print '<a href="g-home-team.php?id='.$r->Id_competizione.'" ><div class="button" >Il tuo team</div></a>';
					 if ($r->Type==1) print '<a href="Schedina.php?id='.$r->Id_competizione.'" ><div class="button" >Guarda schedina</div></a>';
						print'</div>         
						<div class="ab_dx">'; 
						if ($r->Header_link!="") print '<img  width="100%" src="images/header_gare/'.$r->Header_link.'">';
						else{
							 print '<img  width="100%" src="images/logo1.png">';}	
						if ($r->Type==1 /*&& $r->Stato_classifica=='Ufficiale'*/) print '<a href="schedinaRank.php?id='.$r->Id_competizione.'"><color_arancio>Guarda la classifica completa</color_arancio></a>';
						print'</div>
					</div>    
				</div>';
				$cont++;
		}
		if ($cont==0){/* non ci sono gare in corso quindi stampo quelle passate */
			$q="SELECT * FROM Competizione where (Data_fine <='".$data_1."' and Stato_classifica='Ufficiale' and Type<2) order by Data_fine desc  LIMIT 0,1";
			
			$t=mysql_query($q,$connessione); 	
			while($r=mysql_fetch_object($t)){ 
				print'
				<div class="gara">
					<div class="gara_contenuto">';
					if ($cont==0) print '<div class="titolo"><hh2>Ultima partita</hh2></div>';
					if ($cont!=0) print ' <hr>';
						print '<div class="ab_sx">
						<h2>'.$r->Nome.'</h2><h4>'.formatta_data($r->Data_fine).'</h4>';
						
					    if ($r->Type!=1)  print '<a href="g-home-team.php?id='.$r->Id_competizione.'" ><div class="button" >Il tuo team</div></a>';
					 	if ($r->Type==1) print '<a href="Schedina.php?id='.$r->Id_competizione.'" ><div class="button" >Guarda schedina</div></a>';
						print'</div>         
						<div class="ab_dx">'; 
						if ($r->Header_link!="") print '<img  width="100%" src="images/header_gare/'.$r->Header_link.'">';
						else{
							print '<img  width="100%" src="images/logo1.png">';}	
						
						if ($r->Type==1 /*&& $r->Stato_classifica=='Ufficiale'*/) print '<a href="schedinaRank.php?id='.$r->Id_competizione.'"><color_arancio>Guarda la classifica completa</color_arancio></a>';
						print'</div>
					</div>    
				</div>';
				$cont++;
			
			}		
		}	
	   ?> 
               
        </div>
      
      <div class="col_dx">
      	<?php  /* leggi nome ultima gara. i punti sono azzerati a nuova gara */
      		//$q="SELECT * FROM Competizione where (Inizio_formazione <='".$data."' and Type=0) order by Data_inizio desc LIMIT 0,1";
				$q="SELECT * FROM Competizione where Id_competizione='21' order by Data_inizio desc LIMIT 0,1";
			$t=mysql_query($q,$connessione); 	
			while($r=mysql_fetch_object($t)){ 
				print	'<div class="titolo"><hh2>Classifica</hh2></div>';
                /* la classifica si azzera con una nuova competizione */
			   		print '<div class="ab_sx"><h2>'.$r->Nome.'</h2><h4>'.formatta_data($r->Data_fine).'</h4></div>';
					print '<div class="ab_dx">';
					/*if ($r->Stato_classifica=="Ufficiale")*/ print '<a href="raceRank.php?id='.$r->Id_competizione.'"><color_arancio>Guarda la classifica completa</color_arancio></a>'; /*else*/ print "<br/>Stato classifica:".$r->Stato_classifica;
					
					print '</div>';
			    	include 'php/classifica4_0.php';
					break;
			}
           		
				?> 
        </div>
        
    </div>
</div>


  <?php include 'php/footer4_0.php';?>  
<!-- <script type="text/javascript" src="http://www.atletipercaso.net/wp-content/themes/Iris/scripts/snap.min.js"></script>-->
      

