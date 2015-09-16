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

//include '../php/check_admin.php'; // verifica admin
$Privilegi_richiesti="All,";
include '../php/Check_privilegi_admin.php'; // verifica se si dispone dell'autorizzazione a vedere la pagina
$Check=Check_privilegi_admin($g_id,$Privilegi_richiesti);
if (!$Check) header('Location:Error.php');


global $g_nome;

$S_tot_utenti=0;
$S_tot_Giocatori=0;
$S_per_max=0;
$S_per_min=100;

$F_tot_utenti=0;
$F_tot_Giocatori=0;
$F_per_max=0;
$F_per_min=100;

function Leggi_id($nome,$cognome){
	global $connessione;
	$Id_atleta=-1;
	$q="SELECT * FROM Atleti where Nome='".$nome."' and Cognome='".$cognome."'";
	$t=mysql_query($q,$connessione); 		
	while($r=mysql_fetch_object($t))
		$Id_atleta=$r->Id_Atleta;
	return $Id_atleta;					
}
function insert_gara($Nome_gara,$Id_atleta,$Id_gara,$Costo){
	
	$error=0; // notifica errore
	
	/* controlla che l'atleta non sia iscritto a niente */
	global $connessione;
	$id_iscrizione=-1;
	$q="SELECT * FROM Iscritti where Atleti_Id_atleti='".$Id_atleta."' and Competizione_Id_competizione='".$Id_gara."'";
		$t=mysql_query($q,$connessione); 		
		while($r=mysql_fetch_object($t)){	
			$id_iscrizione=$r->Id_iscritti;
		}
	
	if ($id_iscrizione==-1){
		$q="INSERT into Iscritti values(NULL,'".$Id_atleta."','".$Nome_gara."','','".$Costo."','0','".$Id_gara."','0','0')";	
		if(!mysql_query($q,$connessione)){$error=1;}
	}else{
		$q="UPDATE Iscritti set Gara_gara2='".$Nome_gara."',Costo_gara2='".$Costo."' where Id_iscritti='".$id_iscrizione."'";	
		if(!mysql_query($q,$connessione)){$error=1;}
	}
	if ($error==1) return -1;
	else
		return 0;
	
}
if ($_POST['Converti']=='Converti'){
	//converti da file pdf importato
	$CMAX=200;
	$CMIN=50;
	$RM=0;
	$PDM=0;
	$P=0;
	$Prezzo=0;
	
	$pre_inserimento="";
	
	$lista=explode("\n",$_POST['lista']);
	
	$sup=explode(" ",$lista[0]);
	$RM=$sup[count($sup)-1];
	
	$sup=explode(" ",$lista[count($lista)-1]);
	$PDM=$sup[count($sup)-1];
	
	$pre_inserimento=$RM."\n".$PDM."\n";
	
	$i=1; // conta numero atleti
	foreach ($lista as $row){
		
		$sup=explode(" ",$row);	
		
		if (count($sup)<9) {print $i; break;}	
		$P =$sup[count($sup)-1];
		$Sigma= 1-(($P-$RM)/($PDM-$RM));
		$Prezzo=round($Sigma*($CMAX-$CMIN)+$CMIN,0);
			
		$nome=$sup[1];
		for ($j=2;$sup[$j]!=$sup[count($sup)-7];$j++)			
			$nome=$nome." ".$sup[$j];
		
		$row_supp = $i.",1,".$nome.",".$sup[count($sup)-7].",".$P.",,".$Prezzo.",\n";
		
		$i++;
		$pre_inserimento=$pre_inserimento.$row_supp;	
	}
	
}
/*9.74
10.17
1,1,Justin GATLIN,USA,9.74,,,200,
2,1,Asafa POWELL,JAM,9.81,,,176,
*/
if ($_POST['invia1']=='invia1'){
// inserisci iscrizioni da parsing

/* stringa tipica letta
	2,882,Whitney Ashley,USA,61.89,63.00,87,COSTO
*/
	$Id_gara=$_POST['id'];
	$Nome_gara = $_POST['gara'];
	$sesso=$_POST['sesso'];
	$nome="";
	$cognome="";
	$Costo="";
	$lista=explode(",",$_POST['lista']);
	
	$ris=0;
	for ($i=1;$i<count($lista)-1;$i++){
		if ((($i)%7)==0){
			$Costo=$lista[$i-1];
			$naz=$lista[$i-4];
			$cognome="";


			// leggi il nome
			$list_nome=explode(" ",$lista[$i-5]." ");
			$nome=$list_nome[0];
			for ($j=1;$j<count($list_nome)-1;$j++){
				$cognome=$cognome." ".strtoupper($list_nome[$j]);
			}
			/* verifico se l'aatleta è gia stato inserito */
			$Id_atleta=Leggi_id($nome,$cognome);	
			print $Costo." ".$naz." ".$nome." ".$cognome."\n";
			if ($Id_atleta==-1){ //inserisco nuovo atleta
				$q="INSERT into Atleti values(NULL,'".$nome."','".$cognome."','".$sesso."','".$naz."')";
				if(!mysql_query($q,$connessione)){print 'Errore';}
				$Id_atleta=Leggi_id($nome,$cognome);
				if (insert_gara($Nome_gara,$Id_atleta,$Id_gara,$Costo)==-1) $ris=-1;
			}else{//atleta gia inserito
				if (insert_gara($Nome_gara,$Id_atleta,$Id_gara,$Costo)==-1) $ris=-1;
			}				
		}
	}			
}


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
    &rsquo;
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
        
	<br/><br/>
    
	<h1>Parsing iscrizioni iaaf</h1>
    <div id="modulo_dati1">
    
        <form action="Admin_insert_entry.php" method="post">
            <table width="60%">
                <tr>
                	<td><label>Link gara</label><input type="text" required id="Link_gara" placeholder="Link gara" name="link" value="http://www.iaaf.org/competitions/iaaf-world-championships/14th-iaaf-world-championships-4873/results/women/discus-throw/qualification/startlist#A"/></td>
                	<td><label>Nome gara</label><input type="text" required placeholder="Nome gara" name="gara"/></td>
                    <td><label>Id competizione</label><input type="number" required placeholder="id gara" name="id" value="21"/></td>
                    <td><label>Sesso</label><select name="sesso"><option value="M">M</option><option selected value="F">F</option></select></td>
                    <td><input type="button" onClick="Read();" value="Leggi" name="Leggi" /><input type="submit" value="Converti" name="Converti" /></td>
				</tr>
            	<tr>
                	<td colspan="5"><span class="commenti"><i>I dati letti sono nella forma:miglior accredito, peggior accredito<br/>
					1,275,Nome Cognome,NAZIONALITA',SB,PB,COSTO, Il calcolo viene fatto sul SB</i></span></td>
                </tr>
                <tr>
                	<td colspan="5"><textarea id="iscritti" style="width:100%;height:500px;background:#F3AA05;" name="lista"><?php print $pre_inserimento; ?></textarea></td>                
                </tr>         
            </table>
            <input type="submit" name="invia1" value="invia1"/>
        </form>
	</div>
        
<?php

?>
</div>
</body>

</html>


<script language="JavaScript" type="text/javascript">

function Read(){

var stringa =document.getElementById('Link_gara').value;
	
var xmlhttp;
if (window.XMLHttpRequest)
{xmlhttp=new XMLHttpRequest();}
else if (window.ActiveXObject){xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
else{alert("Il browser non supporta XMLHTTP");}
xmlhttp.onreadystatechange=function(){
if(xmlhttp.readyState==4){document.getElementById("iscritti").innerHTML=xmlhttp.responseText;}//alert(xmlhttp.responseText);}
}
xmlhttp.open("GET","Ajax/Parsing.php?link="+stringa,true);
xmlhttp.send(null);
}

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