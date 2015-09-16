<?php
$page_name = "g-home-team";
//versione 4.1 responsitive

//($_SESSION['id_competizione']!=-1)  usato per verificare la possibilità di modificare la squadra
session_start();

$data = date ("Y-m-d");
include "db.inc";
include 'php/Gestione_token.php';
include "php/formatta_data.php"; 

include 'php/API_getAvatarByName.php';

$Errore ="";

include 'php/verifica_accesso_g.php';
include "php/logout.php";
//**************************

/* verifico se ho gia creato un team */
/* $team_creato=false; definito file sotto*/
include 'php/verifica_team_creato.php';

if ($_GET['id']!="") $_SESSION['Id_competizione_select']=$_GET['id'];
?>
<!doctype html>
<html lang="it-IT">
<head>
<meta charset="utf-8">

 <meta http-equiv="x-ua-compatible" content="IE=edge" />
        <meta name="viewport" content="initial-scale=1.0, maximum-scale=10.0, minimum-scale=1.0, user-scalable=no">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-touch-fullscreen" content="yes">

 <script src="script/jquery-1.11.1.min.js"></script>

 
	<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon"/>
	<link rel="icon" href="images/favicon.ico" type="image/x-icon"/>
    
<link type="text/css" media="all" href="css/style.css" rel="stylesheet" />
<link type="text/css" media="all" href="css/new_mobile.css" rel="stylesheet" />
<link type="text/css" media="all" href="css/stadio.css" rel="stylesheet" />
<meta property="og:title" content="Team - Fantatletica" />
<title>Team - Fantatletica</title>
</head>

<body class="body_sfondo">


 <?php include 'php/header4_0.php';?>  

<!--  body info -->
<div class="body_info">
	<div class="call_action_contenuto bordo">
    
    	
     		<div class="titolo">
            	<hh2>Gli atleti del tuo team</hh2>
                	
               <?php 
			   
			   	if ($_SESSION['id_competizione']!=-1) /* possibilità di modifica team a iscrizione aperta */
             	print'<a href="g-team_new.php?change=team"><color_arancio>&nbsp;[Modifica team]</colore_arancio></a><a href="g-team_new.php?change=true"><color_arancio>&nbsp;[Modifica capitano]</colore_arancio></a>';
				?>
            </div>
           
         	<div class="team"> <br/>
             <?php	print '<h2> &nbsp;'.$_SESSION['nome'].'</h2>';?>
           	<?php	
			$q="SELECT * FROM Team 
					JOIN Iscritti ON Iscritti.Id_iscritti= Team.Iscritti_Id_iscritti
					JOIN Atleti ON Iscritti.Atleti_id_atleti = Atleti.Id_Atleta where (Team.Giocatore_Id_giocatore='".$g_id/*$_SESSION['g_id']*/."' and Iscritti.Competizione_Id_competizione='".$_SESSION['Id_competizione_select']."') order by Capitano";
			$t=mysql_query($q,$connessione); 	
			while($r=mysql_fetch_object($t)){
				getAvatarByName($r->Nome,$r->Cognome);
				$Avatar = $array_avatar[0];
				if ($r->Capitano==0){							
						print'<div class="ischomeiscritti capitano">'; 
						print $r->Prima_gara; print'<br/><div class="img_cont">
						
						<div class="bandiera" ><img class="lazy" src="" data-original="../images/Flags/'.$r->Nationality.'.png"/> </div>
						<img class="lazy" src="images/default_avatar.png" data-original="'.$Avatar.'"  title="Profilo" /> </div><h2>'.$r->Cognome.'<br />'.$r->Nome.'</h2>';
						print 'Capitano';
						if ($r->Prima_gara==$r->Gara_Gara1 && $r->Risultato_punti!=0) print '<br/>'.($r->Risultato_punti*2).' Punti';
						if ($r->Prima_gara==$r->Gara_Gara2 && $r->Risultato_classifica!=0) print '<br/>'.($r->Risultato_classifica*2).' Punti';
						
            			/*if ($r->Prima_gara=="t")*/ //print $r->Prima_gara;/*modifica 14/04/15 modificato anche prog in g-team $r->Gara_Gara1;	*/
            			print'</div>';
				}
				else{	
						print'<div class="ischomeiscritti">'; print $r->Prima_gara; print'<br/><div class="img_cont">	
						<img class="lazy" src="images/default_avatar.png" data-original="'.$Avatar.'"  title="Profilo" /> </div>
						<div class="bandiera" ><img class="lazy" src="" data-original="../images/Flags/'.$r->Nationality.'.png"/> </div>
						<h2>'.$r->Cognome.'<br />'.$r->Nome.'</h2>';
						//print '<br/>';
            			/*if ($r->Prima_gara=="t")*/	
            			if ($r->Prima_gara==$r->Gara_Gara1 && $r->Risultato_punti!=0) print $r->Risultato_punti.' Punti';
						if ($r->Prima_gara==$r->Gara_Gara2 && $r->Risultato_classifica!=0) print $r->Risultato_classifica.' Punti';
						
						
						print'</div>';
					}
			}//while		
				?>   
            
   		</div>
	</div>
    	<!--	<div class="titolo"><hh2>TeamMaps</hh2></div>-->
         
         <div class="erba">
          <div class="stadio">
          
       <?php   
	   	$duecento=="";
		$asta=="";
		$peso=="";
		$triplo=="";
		$alto=="";
		$giave=="";
		$alto=="";
		$martello=="";
		$mille500="";
		$qcento="";
		$cento="";
		
		$cento10="";
	   		$q="SELECT * FROM Team 
					JOIN Iscritti ON Iscritti.Id_iscritti= Team.Iscritti_Id_iscritti
					JOIN Atleti ON Iscritti.Atleti_id_atleti = Atleti.Id_Atleta where (Team.Giocatore_Id_giocatore='".$g_id/*$_SESSION['g_id']*/."' and Iscritti.Competizione_Id_competizione='".$_SESSION['Id_competizione_select']."') order by Capitano";
					$t=mysql_query($q,$connessione); 	
					while($r=mysql_fetch_object($t)){
          
						if (strstr($r->Prima_gara, "200m") || strstr($r->Prima_gara, "200 m") || strstr($r->Prima_gara, "200 Metres") || strstr($r->Prima_gara, "siepi"))
							 $duecento=$duecento.$r->Cognome.' '.$r->Nome.'<br />';
						if (strstr($r->Prima_gara, "asta") || strstr($r->Prima_gara, "Pole Vault"))
							 $asta=$asta.$r->Cognome.' '.$r->Nome.'<br />';
						if (strstr($r->Prima_gara, "Peso") || strstr($r->Prima_gara, "Shot Put"))
							 $peso=$peso.$r->Cognome.' '.$r->Nome.'<br />';
						if (strstr($r->Prima_gara, "triplo") or strstr($r->Prima_gara, "lungo") || strstr($r->Prima_gara, "Triple Jump") || strstr($r->Prima_gara, "Long Jump"))
							 $triplo=$triplo.$r->Cognome.' '.$r->Nome.'<br />';
						if (strstr($r->Prima_gara, "giave") || strstr($r->Prima_gara, "Giave") || strstr($r->Prima_gara, "Javelin"))
								 $giave=$giave.$r->Cognome.' '.$r->Nome.'<br />';
						if (strstr($r->Prima_gara, "Salto in alto") || strstr($r->Prima_gara, "High Jump"))
								 $alto=$alto.$r->Cognome.' '.$r->Nome.'<br />';
						if (strstr($r->Prima_gara, "martello") || strstr($r->Prima_gara, "Hammer Throw"))
								 $martello=$martello.$r->Cognome.' '.$r->Nome.'<br />';
						if (strstr($r->Prima_gara, "1500m") || strstr($r->Prima_gara, "1500 m")  || strstr($r->Prima_gara, "1500 Metres"))
								 $mille500=$mille500.$r->Cognome.' '.$r->Nome.'<br />';
						if (strstr($r->Prima_gara, "400m") || strstr($r->Prima_gara, "2000 siepi") || strstr($r->Prima_gara, "400 m") || strstr($r->Prima_gara, "800 m") or strstr($r->Prima_gara, "800m") ||  strstr($r->Prima_gara, "400 Hs") ||   strstr($r->Prima_gara, "400 hs") || strstr($r->Prima_gara, "400 Metres"))
							 $qcento=$qcento.$r->Cognome.' '.$r->Nome.'<br />';
						if (strstr($r->Prima_gara, "100m") || strstr($r->Prima_gara, "100 m") or strstr($r->Prima_gara, "100 Hs") or strstr($r->Prima_gara, "100 hs")  or strstr($r->Prima_gara, "60 Hs") || strstr($r->Prima_gara, "100 Metres") || strstr($r->Prima_gara, "100 Metres Hurdles"))
							 $cento=$cento.$r->Cognome.' '.$r->Nome.'<br />';
						if (strstr($r->Prima_gara, "110hs") || strstr($r->Prima_gara, "110 Hs") || strstr($r->Prima_gara, "110 hs") || strstr($r->Prima_gara, "110 Metres Hurdles"))
								 $cento10=$cento10.$r->Cognome.' '.$r->Nome.'<br />';
						if (strstr($r->Prima_gara, "3000m") || strstr($r->Prima_gara, "3000 m")|| strstr($r->Prima_gara, "Marcia") || strstr($r->Prima_gara, "5000 m") ||strstr($r->Prima_gara, "5000m") || strstr($r->Prima_gara, "3000 Metres") || strstr($r->Prima_gara, "5000 Metres") )
							 $tremila=$tremila.$r->Cognome.' '.$r->Nome.'<br />';
					}	
			      
     	 if ($duecento!="")print '<div class="colore duecento evidenzia"><span>'.$duecento.'</span></div>';      
         if ($asta!="")print '   <div class="colore asta evidenzia"><span>'.$asta.'</span></div>';
         if ($peso!="")print '  <div class="colore peso evidenzia"><span>'.$peso.'</span></div>';
         if ($giave!="")print '  <div class="colore giavellotto evidenzia"><span>'.$giave.'</span></div>';
         if ($alto!="")print '  <div class="colore alto evidenzia"><span>'.$alto.'</span></div>';
         if ($martello!="")print '  <div class="colore martello evidenzia"><span>'.$martello.'</span></div>';
          
         if ($triplo!="")print '    <div class="colore triplo evidenzia"><span>'.$triplo.'</span></div>';
         if ($cento!="")print '      <div class="colore cento evidenzia"><span>'.$cento.'</span></div>';
         if ($cento10!="")print '       <div class="colore cento10 evidenzia"><span>'.$cento10.'</span></div>';
         if ($qcento!="")print '       <div class="colore quattrocento evidenzia"><span>'.$qcento.'</span></div>';
         if ($mille500!="")print '      <div class="colore mille5 evidenzia"><span>'.$mille500.'</span></div>';
		 if ($tremila!="")print '      <div class="colore tremila_5mila evidenzia"><span>'.$tremila.'</span></div>';
		 
         ?>  
		  </div>
            
          </div>
            
     <articolo1>      
     
     </articolo1>
       
        
    
    
</div>


  <?php include 'php/footer4_0.php';?>  
  <script type="text/javascript" src="http://www.atletipercaso.net/wp-content/themes/Iris/scripts/snap.min.js"></script>
         
  
<!--Lazy Load -->

</body>
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://www.appelsiini.net/projects/lazyload/jquery.lazyload.js?v=1.9.1"></script>
<script>
 $(function() {

          $("img").lazyload({

              effect : "fadeIn"

          });

      });;
</script> 
<script src="script/swipe.js"></script>
</html>
