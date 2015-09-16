<?php
$page_name = "g-team";
//versione 5 
/*
v5 -> 03/05/2015 aggiornato sistema di stampa iscritti.

le iscrizioni sono stampate usanto ajax solo al momento dell'espanzione del div contenitore
moduli usati:
	print_gara.php con parametri GET

*/
session_start();

//print "id_gara=".$_SESSION['session_active'];
include "db.inc";
include 'php/Gestione_token.php';
include 'php/API_getAvatarByName.php';
include "php/formatta_data.php"; 
include 'php/Insert_team.php'; /* analisi comportamento */
include 'php/verifica_gara.php';
$Errore ="";

$completa = false; // mostra schermata per compeltare la formazione

include 'php/verifica_accesso_g.php';
include "php/logout.php";

$id_giocatore = $g_id;/*$_SESSION['g_id'];*/
//**************************
// crea formazione
if ($_POST['InvioTeam']==" "){
	//  cancella precedente team in caso si volesse fare una modifica
	//$q="DELETE from Team where Giocatore_Id_giocatore='".$id_giocatore."'"; modifica 17/06/2015
	$q="DELETE Team.* from Team join Iscritti on Iscritti.Id_iscritti=Team.Iscritti_Id_iscritti where Team.Giocatore_Id_giocatore='".$id_giocatore."' and Iscritti.Competizione_Id_competizione='".$_SESSION['id_competizione']."'";
			if(!mysql_query($q,$connessione)) 
				$Errore = "Errore di cancellazione";	
				
	// leggi valori
	$costo_team =$_POST['costo_team'];
	$n_team =$_POST['n_team'];
	
	$stringa_formazione=$_POST['lista_team'];	
	$array_formazione = array();
	$array_formazione = explode(',',$stringa_formazione); // creo array php   incremento ogni 5

	// carica stringa formazione
	$q="UPDATE Giocatore SET Stringa='".$stringa_formazione."',N_team='".$n_team."',Costo_team='".$costo_team."' where Id_giocatore='".$id_giocatore."'"; 
	if(!mysql_query($q,$connessione)) 
		$Errore = "Errore di inserimento/modifica";
	
	for($i=0;$i<count($array_formazione);$i=$i+5){
		$id_iscritti = $array_formazione[$i];
		$prima_gara="";
		$seconda_gara="";
		
		if ($array_formazione[$i+1]!="") $prima_gara = $array_formazione[$i+1];/* modifica 14/04/15 if ($array_formazione[$i+1]!="") $prima_gara = "t";*/
		if ($array_formazione[$i+3]!="") $seconda_gara = "t";
		
		$q="INSERT into Team values ('".$id_iscritti."','".$id_giocatore."','".$prima_gara."','".$seconda_gara."','1')";
			if(!mysql_query($q,$connessione)) 
				$Errore = "Errore di inserimento";
		
	}

	if ((Insert_team($_SESSION['id_competizione'],"I",$id_giocatore))==-1)  /* tieni traccia del comportamento */
		$Errore="Errore tracciamento";
	
		
if ($Errore=="")
  $completa= true;	//header('Location:g-admin.php'); 
}



// intercetta evento modifica capitano da pagina riassuntiva
if ($_GET['change']=="true") $completa= true;

//  cadici per atleti=   0-> CAPITANO; 1-> ATLETA NORMALE
if ($_GET['cap']!=""){
	
	// imposta tutti gli aleti come atleti normali (togli capitano)
	$q="UPDATE Team join Iscritti on Iscritti.Id_iscritti=Team.Iscritti_Id_iscritti SET Capitano='1' where Giocatore_Id_Giocatore='".$id_giocatore."' and Iscritti.Competizione_Id_competizione='".$_SESSION['id_competizione']."'"; 
	if(!mysql_query($q,$connessione)) 
		$Errore = "Errore di inserimento/modifica";
		
	// imposta capitano
	$q="UPDATE Team SET Capitano='0' where Giocatore_Id_Giocatore='".$id_giocatore."' and Iscritti_Id_iscritti='".$_GET['cap']."'"; 
	if(!mysql_query($q,$connessione)) 
		$Errore = "Errore di inserimento/modifica";
		
	if ((Insert_team($_SESSION['id_competizione'],"E",$id_giocatore))==-1)  /* tieni traccia del comportamento */
		$Errore="Errore tracciamento";
		
	if ($Errore=="")
  		header('Location:g-home-team.php');
		
}

/* verifico se ho gia creato un team */
/* $team_creato=false; definito file sotto*/
include 'php/verifica_team_creato.php';

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
  <!--<script src="script/jquery-1.11.1.min.js"></script>-->
 <!--  <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
 <script src="script/script.js"></script>   layzload   --> 
   <!--  menu --> 

	<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon"/>
	<link rel="icon" href="images/favicon.ico" type="image/x-icon"/>
    
<link type="text/css" media="all" href="css/style.css" rel="stylesheet" />
<link type="text/css" media="all" href="css/new_mobile.css" rel="stylesheet" />
<link type="text/css" media="all" href="css/tabelle.css" rel="stylesheet" />
<link type="text/css" media="all" href="css/input.css" rel="stylesheet" />
<title><?php print $_SESSION['nome']; ?></title>
</head>

<body class="body_sfondo">

 <?php include 'php/header4_0.php';?>  

<!--  body info -->
<div class="body_info">
	<div class="call_action_contenuto">
    
     <div class="col_sx">
   
   
   
  <?php
//	 $attiva= false;   // true se è possibile fare la formazione false altrimenti
	// $id_competizione =-1; // contiene l'identificativo della manifestazione
//	 $budget = 0;
//	 $data = date ("Y-m-d");
 	
//	 $q="SELECT * FROM Competizione where Inizio_formazione<='".$data."' and Termine_formazione>='".$data."'";
//	 $t=mysql_query($q,$connessione); 	
//	 while($r=mysql_fetch_object($t)){
//		 $id_competizione=$r->Id_competizione;
	//	 $budget = $r->Budget;
	//	 print '<h3>'.$r->Nome.',&nbsp;'.$r->Sede.'</h3>';
	// }
//	 if ($id_competizione==-1) print '<h3>Iscrizioni chiuse <a href="competizioni.php" target="new"> <span class="modifica">Guarda calendario</span></a></h3>';





/* versione 3_0 *** LA VERIFICA DI UNA GARA ATTIVA VIENE FATTA AL MOMENTO DEL LOGIN */
	$budget = $_SESSION['id_budget'];
	$data = date ("Y-m-d");
	
	if ($_SESSION['id_competizione']!=-1){
		print'<div class="titolo"><hh2>'.$_SESSION['nome'].'</hh2></div>';

	   print' <div class="gara">
        	<div class="gara_contenuto">';
			if ($cont!=0) print ' <hr>';
            	print '<div class="ab_sx">
				<h2>Sede: '.$_SESSION['sede'].'</h2>
                  <articolo>In questa lista ci sono gli atleti della tua squadra. Clicca sul nome di chi vuoi che diventi il tuo capitano.</articolo>';
			    print'</div>         
                <div class="ab_dx">'; 
				/*if ($_SESSION['Schedina']==0) print '<img  width="100%" src="images/Fidal_1.png">';
				if ($_SESSION['Schedina']==2) print '<img  width="100%" src="images/IAAF_1.png">';	*/	
				 print '<img  width="100%" src="images/header_gare/'.$_SESSION['Header'].'.png">';
				
				print'</div><hr>
            </div>    
   		</div>';
	}
	else{
		print '<div class="titolo"><hh2>Iscrizioni chiuse</hh2></div>';
	}
	 ?>

  <!--   <div id="prova">prova</div> -->
      <!-- ** -->
      
        <div>
   <?php //	if ($_SESSION['id_competizione']!=-1) print'<articolo>In questa lista troverai gli atleti iscritti alla gara.<br/>Clicca sul nome dell&acute;atleta che vuoi nella tua squadra ed entrerà a far parte del tuo team.</articolo>';?>
<p></p>
        </div>
          <!-- *************  -->      
             
             <?php

if ($completa== false){
		///					Struttura array javascript contenente le info della formazione
		///					[id_atleta,gara1,costo1,gara2,costo2] ---> incremento contatore di 5
		/// 				ATTENZIONE è IMPORTANTE CHE LA PRIMA GARA SIA SEMPRE LA PRIMA IN ORDINE ALFABETICO
		if ($_SESSION['id_competizione']!=-1){//verifica presenza di competizioni attive
					// crea liste per memorizzare gli atleti che fanno due gare
				
						$i=0;
					//$cento = array();
					$lista_doppiatori = array(array("Nome","Costo","Foto","Gara","Cognome","Primagara","id"));
					
					// mostra iscritti alla gara		  
								$riga = false;
								$gara_prec = "";	
								$id_table=0;	
								/*$q="SELECT * FROM Iscritti JOIN Atleti ON Iscritti.Atleti_id_atleti = Atleti.Id_Atleta where Competizione_Id_competizione='".$_SESSION['id_competizione']."' ORDER BY  Atleti.sesso desc,Iscritti.Gara_Gara1,Atleti.Cognome";  modifica del 07/07/2015 campionati europei U23 anche in Read_iscritti_gare_fanta	*/	
								$q="SELECT * FROM Iscritti JOIN Atleti ON Iscritti.Atleti_id_atleti = Atleti.Id_Atleta where Competizione_Id_competizione='".$_SESSION['id_competizione']."' ORDER BY  Iscritti.Gara_Gara1,Atleti.sesso desc,Atleti.Cognome";
								
								$t=mysql_query($q,$connessione); 	
								while($r=mysql_fetch_object($t)){
									
									  if ($gara_prec!=$r->Gara_Gara1){	//crea nuova tabella gara
											// stampa fine tabella
											if($gara_prec != "")
											print ' </tbody></table></div><br/> ';
											//aggiorna gara attuale
											$gara_prec=$r->Gara_Gara1; 
											
											//stampa inizio tabella <span class="titolo_gara">
											print'<div onclick="Espandi(';
											print"'";
											print $r->Gara_Gara1;
											print "'";
											print')"><div class="titolo"> <hh3 class="cursore">'.$r->Gara_Gara1.'</hh3></div></div>    
												<div style="display:none;" name="no" id="'.$r->Gara_Gara1.'">';
										}//crea nuova tabella gara

							$riga = !$riga;	
								}
								//completa ultima tabella modifica 23/02/15
								print ' </div><br/> ';
							//*****************************************					
		}//verifica presenza di competizioni attive
		else{
			//mostra calendario
		/*	print'<h1>Programma gare</h1>';
			$q="SELECT * FROM Competizione order by Data_inizio LIMIT 0,7";
			$t=mysql_query($q,$connessione); 	
			while($r=mysql_fetch_object($t)){
				print '<div class="ischome">
				<div class="evidenzia_gara1">
				<h3>'.$r->Nome.'</h3>
				</div>
				Data:<br/>'.formatta_data($r->Data_inizio).'<br/>
				</div>';
			}*/
		}
		//else
} // if completa
else{  //mostra team formato
	print' <p><span class="titolo_gara">Team -scegli capitano</span></p> ';   
	print '<table width="100%" class="tab_el" id='.$id_table.'> 
															<tbody>
																<tr>
																	<th width="3%">Naz.</th>
																	<!--<th width="7%">Foto</th>-->
																	<th width="55%">Nome atleta</th>
																	<th width="15%">Costo</th>
																	<th width="20%">2°Gara</th>
																</tr> ';
																
			$q="SELECT * FROM Team 
						JOIN Iscritti ON Iscritti.Id_iscritti= Team.Iscritti_Id_iscritti
						JOIN Atleti ON Iscritti.Atleti_id_atleti = Atleti.Id_Atleta where Team.Giocatore_Id_giocatore='".$g_id/*$_SESSION['g_id']*/."' and Iscritti.Competizione_Id_competizione='".$_SESSION['id_competizione']."' order by Capitano";
			$t=mysql_query($q,$connessione); 	
			while($r=mysql_fetch_object($t)){
				
				 if ($riga){print '<tr class="pari">';} else {print '<tr class="dispari">';}	
												print'<td><!--<img src="images/Flag_of_Italy.svg.png" TITLE="Nazionalit&agrave" width="30"/>--><img src="images/Flags/'.$r->Nationality.'.png" title="'.$r->Nationality.'" alt="'.$r->Nationality.'" width="30"/></td>';	
										//  $Avatar = getAvatarByName($r->Nome,$r->Cognome);  modifica 16/08/15 campionati mondiali
									
									
									/*	  if ($r->Avatar=="") 
											$Avatar = "images/profilo.jpg";
										  else
											$Avatar = "images/atleti/".$r->Avatar;*/
											
										 // print'<td><!--<img class="lazy" src="images/default_avatar.png" data-original="'.$Avatar.'" width="30" title="Profilo" />modifica 16/08/15 campionati mondiali--></td>'; //modifica 16/08/15 campionati mondiali
									  print'<td><a href="g-team_new.php?cap='.$r->Id_iscritti.'" ><strong>'.$r->Cognome.'</strong> '.$r->Nome.'</a></td>';   //termina riga
									
									print'<td style="text-align:right;">'.$r->Costo_gara1.'</td>';
									print '<td>'.$r->Gara_Gara2.'</td>';
									print'</tr>';
				$riga = !$riga;
			}
	print ' </tbody></table><br/> ';
print '<a href="g-home-team.php"> <input type="submit" name="Annulla" value="Annulla" /></a>';//<a href="g-admin.php">
} //else
?>
               
       <!-- ** -->
             
	 </div><!--col_sx-->
      
     <!-- formazione -->
        <div class="col_dx">
        
        
          <div class="gara">
        	<div class="gara_contenuto">
			
            	<div class="ab_sx">
				<h2>ISTRUZIONI</h2>
              <articolo>Qui appariranno gli atleti del tuo team. Cliccaci sopra per eliminarli dalla tua squadra. Attento a rimanere nei limiti del budget!</articolo>
			    </div>         
                <div class="ab_dx">
				 <hh3>BUDGET</hh3>
                <span id="SpesaParziale">0</span>/<span id="SpetaTotale" class="budget"><?php print $budget;   ?></span>
                <br /> <br />
                <span id="comunica" class="budget">   </span>	
				</div>
            </div>    
   		</div>

           <?php    
		   if ($_SESSION['id_competizione']!=-1){
          			print'        
             <table class="tab_el" id="tabella">
                <tbody>
                    <tr>                 	
                      <th width="10%">Foto</th>
                        <th width="57%">Nome</th>
                        <th width="13%">Costo</th>
                        <th width="20%">Gare</th>
                    </tr>               
            	</tbody>
            </table>  
            
        <form action="g-team_new.php" method="post">
            <div id="idTeam">
             <input type="hidden" name="lista_team" value="" /> 
			</div> <div id="idTeam1">
			 <input type="hidden" name="costo_team" value="" />
			</div> <div id="idTeam2">
			 <input type="hidden" name="n_team" value="" />
            </div>    
			<gioca>   <input type="submit" class="Invio" name="InvioTeam" value=" " /></gioca>     
            
            </form> '; 
            }?>
        </div><!-- col_dx -->

    </div>
</div>
  <?php include 'php/footer4_0.php';?>  
<!-- <script type="text/javascript" src="http://www.atletipercaso.net/wp-content/themes/Iris/scripts/snap.min.js"></script>-->
   
</body>
</html>

<script language="JavaScript" type="text/javascript">



function Track(id,action){
var xmlhttp;
if (window.XMLHttpRequest)
{xmlhttp=new XMLHttpRequest();}
else if (window.ActiveXObject){xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
else{alert("Il browser non supporta XMLHTTP");}
xmlhttp.onreadystatechange=function(){
if(xmlhttp.readyState==4){document.getElementById("prova").innerHTML=xmlhttp.responseText;}
}
xmlhttp.open("GET","php/Track_actions.php?id="+id+"&action="+action,true);
xmlhttp.send(null);
}







function Espandi(div){	

	if (document.getElementById(div).style.display=='block'){
		document.getElementById(div).style.display='none';	}
	else{
		if (document.getElementById(div).getAttribute('name')=="no"){
			document.getElementById(div).innerHTML="<img src='images/load.gif' />Caricamento iscrizioni";
		chiamaAjax(div);
		document.getElementById(div).setAttribute('name',"si");
		}
		
		document.getElementById(div).style.display='block';}
}

	

function chiamaAjax(div)
{
var xmlhttp;
if (window.XMLHttpRequest)
   {
   // codice valido per IE7 e succ., Firefox, Chrome, Opera, Safari
   xmlhttp=new XMLHttpRequest();
   }
else if (window.ActiveXObject)
   {
   // codice valido per IE6 e IE5
   xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
   }
else
   {
   alert("Il browser non supporta XMLHTTP");
   }
xmlhttp.onreadystatechange=function()
{
if(xmlhttp.readyState==4)
   {
   document.getElementById(div).innerHTML=xmlhttp.responseText;
   }
}
xmlhttp.open("GET","php/print_gara.php?gara="+div,true);
xmlhttp.send(null);
}

var num=1;
var riga = true;
var spesapar =0;
var spesatot= 0;

var num_atleti=0; //conta atleti

var listaAtleti  =[];
//var indiceatleti = 0;
var budget = document.getElementById('SpetaTotale').innerHTML;

function accoda(legginome,leggicosto,immagine,leggigara,cod){
    if(document.createElement && document.getElementById && document.getElementsByTagName) {
	
	if (verifica(cod,leggicosto,leggigara,num_atleti)){
        //crea elementi
        var Tr=document.createElement("TR");
		var Td0=document.createElement("INPUT");
        var Td1=document.createElement("TD");
        var Td2=document.createElement("TD");
		var Td3=document.createElement("TD");
		var Td4=document.createElement("TD");
        var bandiera=document.createElement("IMG");
       
        //setta proprietà
		if (riga) Tr.setAttribute("class","pari"); else Tr.setAttribute("class","dispari");
		riga = !riga;	
        bandiera.setAttribute("src",immagine);
		var nome=document.createElement("a");
		nome.setAttribute("href","javascript:void(0)");
		var textnode=document.createTextNode(legginome);
		nome.appendChild(textnode);
		
	
		
		var costo=document.createElement("p");
		var textnode1=document.createTextNode(leggicosto);
		costo.appendChild(textnode1);
		
		var gare=document.createElement("p");
		var textnode2=document.createTextNode(leggigara);
		gare.appendChild(textnode2);

		Td0.setAttribute("type","radio");
        Td0.setAttribute("name","cap");

		// setta gestore evento cambio capitano
        if(Td0.attachEvent) Td0. attachEvent('onclick',function(e){capitano(cod);})
        else if(Td0.addEventListener) Td0. addEventListener('click',function(e){capitano(cod);},false)
		
  		// setta gestore evento
        if(nome.attachEvent) nome. attachEvent('onclick',function(e){rimuovi(e,leggicosto,cod,leggigara);})
        else if(nome.addEventListener) nome. addEventListener('click',function(e){rimuovi(e,leggicosto,cod,leggigara);},false)	
        // concatena oggetti
        Td1.appendChild(bandiera);
        Td2.appendChild(nome); 
        Td3.appendChild(costo);
		Td4.appendChild(gare);
	//	Tr.appendChild(Td0);
        Tr.appendChild(Td1);
        Tr.appendChild(Td2);
		Tr.appendChild(Td3);
		Tr.appendChild(Td4);
        document.getElementById('tabella').getElementsByTagName('TBODY')[0].appendChild(Tr);
        // incrementa variabile globale
        num++
		
		// conta atleti
		num_atleti++;
		
		//aggiorna saldo
		//spesapar+= parseInt(leggicosto);
		//document.getElementById("SpesaParziale").innerHTML =spesapar;
		//aggiorno lista
		Add_team(cod,leggigara,leggicosto);
    }}
}

function rimuovi(e,eliminacosto,cod,gara){
    if(document.removeChild && document.getElementById && document.getElementsByTagName) {
        if(!e) e=window.event;
        var srg=(e.target)?e.target:e.srcElement;

        // risali al tr del td che contiene l' elemento che ha scatenato l' evento
        while(srg.tagName!="TR"){srg=(srg.parentNode)?srg.parentNode:srg.parentElement}

        // riferimento al tbody
        var tb=document.getElementById('tabella').getElementsByTagName('TBODY')[0];
        
        // rimuovi
        tb.removeChild(srg);
		//aggiorna saldo
		//spesapar-= parseInt(eliminacosto);
		//document.getElementById("SpesaParziale").innerHTML =spesapar;
		//aggiorna lista
		Delete_team(cod,gara);
		
		//numero atleti
		num_atleti--;
		// rimuovi comunicazioni
		document.getElementById('comunica').innerHTML="";
    }
}


function verifica(cod,costo,gara,n_atleti){
	var costocal = costo;
	var postrovato = -1;
	// verifica doppia gara e singolo atleta epr gara
	for (var i=0; i<listaAtleti.length; i=i+5){
		if (listaAtleti[i]==cod){
			document.getElementById('comunica').innerHTML="Atleta gi&agrave; inserito";
				return false;
			postrovato = i;
			if 	(listaAtleti[i+1]==gara || listaAtleti[i+3]==gara){   // verifica atleta gia schierato nella gara	 
				document.getElementById('comunica').innerHTML="Atleta gi&agrave; inserito";
				return false;}
		}	
	}
	// modifico il costo per l'inserimento dell'atleta
	if (postrovato!=-1){
		var costo1 = 0;
		if (listaAtleti[postrovato+1]!="") costo1= listaAtleti[postrovato+2];
		if (listaAtleti[postrovato+3]!="") costo1= listaAtleti[postrovato+4];
		if (costo1 >= costo)
			costocal= (parseInt(costo)-parseInt(costo1));
		else
			costocal=0;
			
			//	document.getElementById('test').innerHTML=costocal;
	}
	//verifica saldo
	if (parseInt(costocal)+parseInt(spesapar) > parseInt(budget) ){
		document.getElementById('comunica').innerHTML="Non hai sufficente credito";
		return false;
	}
	
	
	if (n_atleti > 9){
			document.getElementById('comunica').innerHTML="Hai superato il tetto massimo di atleti";
		return false;}
	
	document.getElementById('comunica').innerHTML="";

	return true;
}

function Add_team(id,gara,costo){
	var trovato = false;
	var addcosto = 0;
	
	for (var i=0; i<listaAtleti.length; i=i+5){
		if (listaAtleti[i]==id){
	 //atleta che fa due gare
				listaAtleti[i+3]=gara;
				//aggiorno la spesa in modo da considerare solo il massimo
				spesapar-= parseInt(listaAtleti[i+2]);
				spesapar+= Math.max(parseInt(listaAtleti[i+2]),parseInt(costo));
				listaAtleti[i+4]= costo;

				trovato = true;
			}}
	if (!trovato){
		listaAtleti.push(id);//[indiceatleti] = id;
		//indiceatleti++;
		listaAtleti.push(gara);//[indiceatleti] = gara;
		//indiceatleti++;
		listaAtleti.push(costo);//[indiceatleti] = costo;
		//indiceatleti++;
		listaAtleti.push("");//[indiceatleti] = "";  //seconda gara
		//indiceatleti++;
		listaAtleti.push("");//[indiceatleti] = "";  //costo seconda gara
		//indiceatleti++;
		addcosto = costo;	
	}

	spesapar+= parseInt(addcosto);
	document.getElementById("SpesaParziale").innerHTML =spesapar;	
	document.getElementById('idTeam').innerHTML=" <input type='hidden' name='lista_team' value='"+listaAtleti+"' /> ";
	document.getElementById('idTeam1').innerHTML=" <input type='hidden' name='costo_team' value='"+spesapar+"' /> ";
	document.getElementById('idTeam2').innerHTML=" <input type='hidden' name='n_team' value='"+num_atleti+"' /> ";
	
	Track(id,"I");
}



function Delete_team(id,gara){
	var supp=0;
	var trovato = false;
for (var i=0; i<listaAtleti.length; i=i+5){
	 if (listaAtleti[i]==id){
		  if (listaAtleti[i+1]==gara){
			 	 //verifico che abbia tolto il max
				 var supp=0;
				 if (listaAtleti[i+4]!="") supp=parseInt(listaAtleti[i+4]);
				 
			    if (parseInt(listaAtleti[i+2]) == Math.max(parseInt(listaAtleti[i+2]),supp)){ 
			  	spesapar-= parseInt(listaAtleti[i+2]);  //sottraggo il massimo
				if (listaAtleti[i+4]!="")
					spesapar+= parseInt(listaAtleti[i+4]);	//sommo il minimo
				}
			  	listaAtleti[i+1]="";listaAtleti[i+2]="";  // elimina gara
			  }
		  if (listaAtleti[i+3]==gara){
			  supp=0;
			  if (listaAtleti[i+2]!="") supp=parseInt(listaAtleti[i+2]);
			  if (parseInt(listaAtleti[i+4]) == Math.max(parseInt(listaAtleti[i+4]),supp)){ 
			  	spesapar-= parseInt(listaAtleti[i+4]);  //sottraggo il massimo
				if (listaAtleti[i+2]!="")
					spesapar+= parseInt(listaAtleti[i+2]);	//sommo il minimo
				}
			  listaAtleti[i+3]="";listaAtleti[i+4]=""; 
			  }
		  
		  
		  if  ((listaAtleti[i+1]=="") && (listaAtleti[i+3]=="")) listaAtleti.splice(i, 5); //listaAtleti[i]="";
		  trovato = true;
	 }
	if (trovato) break; 
}
document.getElementById("SpesaParziale").innerHTML =spesapar;		 
document.getElementById('idTeam').innerHTML=" <input type='hidden' name='lista_team' value='"+listaAtleti+"' /> ";
Track(id,"D");
}

//-->
</script>
<!--Lazy Load -->
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<!--
<script src="http://www.appelsiini.net/projects/lazyload/jquery.lazyload.js?v=1.9.1"></script>
<script>
 $(function() {

          $("img").lazyload({

              effect : "fadeIn"

          });

      });;
</script> -->
<script src="script/swipe.js"></script>