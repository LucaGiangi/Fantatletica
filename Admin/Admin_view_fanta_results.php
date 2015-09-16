<?php
$page_name = "Admin_view_fanta_results";
//versione 4.1 responsitive

//($_SESSION['id_competizione']!=-1)  usato per verificare la possibilità di modificare la squadra
session_start();

/*$data = date ("Y-m-d");*/
$data = date("Y/m/d G:i:s");
$data_1 = date("Y/m/d");
$day_select=180;
include "../db.inc";
include "../php/formatta_data.php"; 

include '../php/Gestione_token.php';
include '../php/verifica_accesso_g.php';
include "../php/logout.php";

//include '../php/check_admin.php'; // verifica admin
$Privilegi_richiesti="All,Check,";
include '../php/Check_privilegi_admin.php'; // verifica se si dispone dell'autorizzazione a vedere la pagina
$Check=Check_privilegi_admin($g_id,$Privilegi_richiesti);
if (!$Check) header('Location:Error.php');


global $g_nome;

?>

<!doctype html>
<html lang="it-IT">
<head>
	<meta charset="utf-8">

    <meta http-equiv="x-ua-compatible" content="IE=edge" />
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=10.0, minimum-scale=1.0, user-scalable=yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">

	<link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon"/>
	<link rel="icon" href="../images/favicon.ico" type="image/x-icon"/>
	<title>Admin - Fantatletica</title>
	<link type="text/css" media="all" href="../css/new_mobile.css" rel="stylesheet" />
    <link type="text/css" media="all" href="../css/style.css" rel="stylesheet" />
    <link type="text/css" media="all" href="../css/tabelle.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/schedina.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="../Analytics/menu.css">
    <link type="text/css" media="all" href="Acss.css" rel="stylesheet" />
   	<meta name="robots" content="noindex">
	<meta name="googlebot" content="noindex">
    <!-- menu -->
    <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
    <script src="../Analytics/script.js"></script>
    <!-- -->
	
    <script>
function Espandi(div){	
	if (document.getElementById(div).style.display=='block'){
		document.getElementById(div).style.display='none';	}
	else{
		document.getElementById(div).style.display='block';}
}
</script>

</head>


		
    	<?php include 'Header.php'; ?>
        
        
        <h1>Admin</h1> 
        <div style="width:100%;">
                <h3>Elenco Competizioni</h3>
                <table class="tab_el" ><tr><th width="50%">Nome</th><th width="30%">Data</th></tr>
                    
                        <?php
                        $riga=false;
                        $q="SELECT * FROM `Competizione` WHERE ('$data_1' - INTERVAL ".$day_select." DAY<`Data_fine` and Type=0) order by Data_inizio desc";
                        $t=mysql_query($q,$connessione); 	
                        while($r=mysql_fetch_object($t)){
                            if ($riga){print '<tr class="pari">';} else {print '<tr class="dispari">';} $riga=!$riga;
                            print '<td style="cursor:pointer;" onClick="Cerca_competizione('.$r->Id_competizione.');">'.$r->Nome.'<td>'.$r->Data_fine.'</td><td> 
                                    </td>
									
									</tr>';
                        }
                        ?>
                </table>
                <span class="commenti"><i>Clicca sul nome della competizione per verificare iscrizioni e risultati</i></span>	
                <h5>Attenzione!! L&acute;avvenuta modifica dei valori &egrave; segnalata dal cambio di colore da bianco a verde del campo di testo</h5>
            </div>
        
		<div id="modulo_dati">
        </div>
        </div>			        
	</div>
</body>
</html>
<script language="JavaScript" type="text/javascript">
function Espandi(div,id){	
	if (document.getElementById(div).style.display=='block'){
		document.getElementById(div).style.display='none';	}
	else{
		if (document.getElementById(div).getAttribute('name')=="no"){
			document.getElementById(div).innerHTML="<img src='../images/load.gif' />Caricamento iscrizioni";
		chiamaAjax(div,id);
		document.getElementById(div).setAttribute('name',"si");
		}	
		document.getElementById(div).style.display='block';}
}

function chiamaAjax(div,id){
	var xmlhttp;
	if (window.XMLHttpRequest){
   // codice valido per IE7 e succ., Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();}
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
	xmlhttp.open("GET","Ajax/Read_iscritti_punti_fanta.php?id="+id+"&gara="+div,true);
	xmlhttp.send(null);
}
function Cerca_competizione(id){
var xmlhttp;
if (window.XMLHttpRequest)
{xmlhttp=new XMLHttpRequest();}
else if (window.ActiveXObject){xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
else{alert("Il browser non supporta XMLHTTP");}
xmlhttp.onreadystatechange=function(){
if(xmlhttp.readyState==4){document.getElementById("modulo_dati").innerHTML=xmlhttp.responseText;}
}
xmlhttp.open("GET","Ajax/Read_iscritti_gare_fanta.php?id="+id,true);
xmlhttp.send(null);
}


function Add_result(gara,id){

	var punti =document.getElementById(id).value;
	
var xmlhttp;
if (window.XMLHttpRequest)
{xmlhttp=new XMLHttpRequest();}
else if (window.ActiveXObject){xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
else{alert("Il browser non supporta XMLHTTP");}
xmlhttp.onreadystatechange=function(){
if(xmlhttp.readyState==4){ document.getElementById(id).style.backgroundColor = "#A6E97B";}//alert(xmlhttp.responseText);}
}
xmlhttp.open("GET","Ajax/Edit_point.php?gara="+gara+"&id="+id+"&punti="+punti,true);
xmlhttp.send(null);
}

function reset_value(id){//reset colore della textbox appena si modifica il testo

	document.getElementById(id).style.backgroundColor = "#FFFFFF"; 
}
</script> 
    