<?php
$page_name = "Admin_insert_entry";
//versione 4.1 responsitive

//($_SESSION['id_competizione']!=-1)  usato per verificare la possibilità di modificare la squadra
session_start();

/*$data = date ("Y-m-d");*/
$data = date("Y/m/d G:i:s");
$data_1 = date("Y/m/d");

include "../db.inc";
include "../php/formatta_data.php"; 

include '../php/Gestione_token.php';
include '../php/verifica_accesso_g.php';
include "../php/logout.php";

include '../php/check_admin.php'; // verifica admin
global $g_nome;

$S_tot_utenti=0;
$S_tot_Giocatori=0;
$S_per_max=0;
$S_per_min=100;

$F_tot_utenti=0;
$F_tot_Giocatori=0;
$F_per_max=0;
$F_per_min=100;


if ($_POST['invia']=='invia'){
	
	list($nome,$cognome)=explode(" ",$_POST['nome']);
	$cognome=strtoupper($cognome);
	print $nome." ".$cognome;
	$id=$_POST['id'];
	/* cerca id */
	if ($id==""){
		/*$q="SELECT Id_Atleta FROM Atleti where Nome='".$nome."' and Cognome='".$cognome."'";
		$t=mysql_query($q,$connessione); 		
		while($r=mysql_fetch_object($t)){	
			$id=$r->Id_Atleta;
		}*/
		
		if ($id==""){	
			//$q="INSERT into Atleti values(NULL,'".$nome."','".$cognome."','F')";
			//if(!mysql_query($q,$connessione)){print 'Errore';}
			/*$q="SELECT Id_Atleta FROM Atleti where Nome='".$nome."' and Cognome='".$cognome."'";
			$t=mysql_query($q,$connessione); 		
			while($r=mysql_fetch_object($t)){	
				$id=$r->Id_Atleta;
			}*/
		}else{}
	}
	/*			*/
	$sigma= 1-(($_POST['accredito']-$_POST['migliore'])/($_POST['peggiore']-$_POST['migliore']));
	$prezzo = round($sigma*(200-50)+50);
	
	$prezzo2=0;
	if ($_POST['accredito2']!=""){
		$sigma2= 1-(($_POST['accredito2']-$_POST['migliore2'])/($_POST['peggiore2']-$_POST['migliore2']));
		$prezzo2 = round($sigma2*(200-50)+50);
	}
	//$q="INSERT into Iscritti values(NULL,'".$id."','".$_POST['gara']."','".$_POST['gara2']."','".$prezzo."','".$prezzo2."','17','0','0')";	
	//if(!mysql_query($q,$connessione)){print 'Errore';}else{print $q;}
}
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
    <link type="text/css" media="all" href="Acss.css" rel="stylesheet" />
    <link rel="stylesheet" href="../Analytics/menu.css">
    
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
        
        <h1>Insert</h1> 
        
        <div id="modulo_dati">
        
        <form action="Admin_insert_entry.php" method="post">
        	<table>
            	<tr><td><input type="text" placeholder="gara" name="gara"/></td><td><input type="text" placeholder="accredito" name="accredito"/></td><td><input type="text" placeholder="M tempo" name="migliore"/></td><td><input type="text" placeholder="P tempo" name="peggiore"/></td></tr>
            
           		<tr><td><input type="text" placeholder="gara2" name="gara2"/></td><td><input type="text" placeholder="accredito2" name="accredito2"/></td><td><input type="text" placeholder="M tempo2" name="migliore2"/></td><td><input type="text" placeholder="P tempo2" name="peggiore2"/></td></tr>
        <tr><td><input type="text" placeholder="id" name="id"/></td><td></td></tr>
        
  			</table>
        	<input type="text" placeholder="nome" name="nome"/>
        	<input type="submit" name="invia" value="invia">
        </form>
        </div>
        
        <br/>
        <br/>
	</div>
</body>
</html>
<script language="JavaScript" type="text/javascript">
function Cerca_utenti(){
var xmlhttp;
var id=document.getElementById("utente").value;
if (window.XMLHttpRequest)
{xmlhttp=new XMLHttpRequest();}
else if (window.ActiveXObject){xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
else{alert("Il browser non supporta XMLHTTP");}
xmlhttp.onreadystatechange=function(){
if(xmlhttp.readyState==4){document.getElementById("modulo_dati").innerHTML=xmlhttp.responseText;}
}
xmlhttp.open("GET","Ajax/Read_utenti.php?id="+id,true);
xmlhttp.send(null);
}
</script>