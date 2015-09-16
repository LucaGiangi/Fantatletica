<?php
$page_name = "Admin_viewschedina";
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
	<title>Statistiche - Fantatletica</title>
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
        
        <h1>Admin</h1> 
        <br/>
        <h3>Lista delle puntate per giocatore</h3>
                <table class="tab_el" ><tr><th width="50%">Nome</th><th width="10%">Data</th><th width="40%">Tools</th></tr>
                        <?php
                        $riga=false;
                        $q="SELECT * FROM `Competizione` WHERE ('$data_1' - INTERVAL 180 DAY<`Data_fine` and (Type=1 or Type=3))";
                        $t=mysql_query($q,$connessione); 	
                        while($r=mysql_fetch_object($t)){
                            if ($riga){print '<tr class="pari">';} else {print '<tr class="dispari">';} $riga=!$riga;
                            print '<td>'.$r->Nome.'<td>'.$r->Data_fine.'</td>
                                       <td><a href="javascript:void(0)" onClick="Giocate('.$r->Id_competizione.');">Puntate aggiornate al momento</a></td>
									</tr>';
                        }
                        ?>
                </table>
        
        
        <div id="modulo_dati">
        </div>
        </div>
        <br/>
        <br/>
	</div>
</body>
</html>
<script language="JavaScript" type="text/javascript">
	function Giocate(id){
	var xmlhttp;
	if (window.XMLHttpRequest)
	{xmlhttp=new XMLHttpRequest();}
	else if (window.ActiveXObject){xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	else{alert("Il browser non supporta XMLHTTP");}
	xmlhttp.onreadystatechange=function(){
	if(xmlhttp.readyState==4){document.getElementById("modulo_dati").innerHTML=xmlhttp.responseText;}
	}
	xmlhttp.open("GET","Ajax/Read_schedina_giocate.php?id="+id,true);
	xmlhttp.send(null);
	}
</script>
 
    