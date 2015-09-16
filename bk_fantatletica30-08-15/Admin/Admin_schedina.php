<?php
$page_name = "Admin_schedina";
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

$inserimento_schedina=false; /* true se la schedina + stata inserica correttamente */

/* gestione manifestazione */
if ($_POST['Inserisci']=='Inserisci schedina'){
	/* inserisci una nuova schedina */
	/* calcola utenti attivi */
	$n_giocatori=0;
	$q="SELECT count(*) as N_giocatori FROM Giocatore where Status=1";
		$t=mysql_query($q,$connessione); 	
		while($r=mysql_fetch_object($t))
			$n_giocatori=$r->N_giocaori;
			
	$data_apertura= $_POST['inizio']." ".$_POST['ora_inizio'].":00";
	$data_chiusura= $_POST['fine']." ".$_POST['ora_fine'].":00";
	/* inserisci nuova schedina */
	$q="INSERT into Competizione values (null,'".$_POST['nome']."','".$_POST['luogo']."','".$_POST['data']."','".$_POST['data']."','".$data_apertura."','".$data_chiusura."','".$_POST['logo']."','','','1',default,'$n_giocatori')";
	
	if(!mysql_query($q,$connessione)) 
			$Errore = "Errore di inserimento";
	else
		$inserimento_schedina=true;
}
if ($_POST['Modifica']=='Modifica schedina'){
	/* calcola utenti attivi  ad ogni aggiornamento si calcolano gli utenti attivi*/
	$n_giocatori=0;
	$q="SELECT count(*) as N_giocatori FROM Giocatore where Status=1";
		$t=mysql_query($q,$connessione); 	
		while($r=mysql_fetch_object($t))
			$n_giocatori=$r->N_giocaori;
			
	/* modifica dati schedina */
	$data_apertura= $_POST['inizio']." ".$_POST['ora_inizio'].":00";
	$data_chiusura= $_POST['fine']." ".$_POST['ora_fine'].":00";
	$q="UPDATE Competizione SET Nome='".$_POST['nome']."',Sede='".$_POST['luogo']."',Data_inizio='".$_POST['data']."',Data_fine='".$_POST['data']."',Inizio_formazione='".$data_apertura."',Termine_formazione='".$data_chiusura."',Stato_classifica='".$_POST['stato_ris']."',Header_link='".$_POST['logo']."',Utenti_attivi='$n_giocatori' where Id_competizione='".$_POST['Id_competizione']."'";
	print $q;
	if(!mysql_query($q,$connessione)) 
			$Errore = "Errore di inserimento";
	else
		$modifica_schedina=true;

}
if ($_POST['Invio_foto']=='Carica'){
	
	$UPLOAD_DIR = "../images/header_gare/";   
	if(isset($_FILES['file']))  { 
		$file = $_FILES['file']; 
		if($file['error'] == UPLOAD_ERR_OK and is_uploaded_file($file['tmp_name'])){ 
			if ($file["size"] > 0) { 
 				if (move_uploaded_file($file['tmp_name'], $UPLOAD_DIR.$file['name']))  
 					$inserimento_file=true;
				else
                $Errore = "Errore di inserimento file";
 			} else
         		$Errore = "Errore di inserimento file"; 
		}   
	} 		
}
/* gestione punate schedina */
if (($_POST['Invia']=='Invia') and ($_POST['conferma']=='ok')){	

	/* leggi giocate */
	$giocate = array();
	$giocate[1]= $_POST['input1'];
	$giocate[2]= $_POST['input2'];
	$giocate[3]= $_POST['input3'];
	$giocate[4]= $_POST['input4'];
	$giocate[5]= $_POST['input5'];
	$giocate[6]= $_POST['input6'];
	$giocate[7]= $_POST['input7'];
	$giocate[8]= $_POST['input8'];
	$giocate[9]= $_POST['input9'];
	$giocate[10]= $_POST['input10'];
	$giocate[11]= $_POST['input11'];
	$giocate[12]= $_POST['input12'];
	$giocate[13]= $_POST['input13'];
	$giocate[14]= $_POST['input14'];
	$giocate[15]= $_POST['input15'];
	$giocate[16]=$_POST['input16'];
	$giocate[17]= $_POST['input17'];
	$giocate[18]= $_POST['input18'];

	for ($k=1;$k<18;$k++){
		$stringa_sql=$stringa_sql."'".$giocate[$k]."',";
		$stringa_sql_mod=$stringa_sql_mod."Giocata$k='".$giocate[$k]."',";
	}
	$stringa_sql=$stringa_sql."'".$giocate[18]."'";
	$stringa_sql_mod=$stringa_sql_mod."Giocata18='".$giocate[$k]."'";
	/* leggi risultati */
	$arrayletto = array();
	$arrayletto[1]= $_POST['radio-1-set'];
	$arrayletto[2]= $_POST['radio-2-set'];
	$arrayletto[3]= $_POST['radio-3-set'];
	$arrayletto[4]= $_POST['radio-4-set'];
	$arrayletto[5]= $_POST['radio-5-set'];
	$arrayletto[6]= $_POST['radio-6-set'];
	$arrayletto[7]= $_POST['radio-7-set'];
	$arrayletto[8]= $_POST['radio-8-set'];
	$arrayletto[9]= $_POST['radio-9-set'];
	$arrayletto[10]= $_POST['radio-10-set'];
	$arrayletto[11]= $_POST['radio-11-set'];
	$arrayletto[12]= $_POST['radio-12-set'];
	$arrayletto[13]= $_POST['radio-13-set'];
	$arrayletto[14]= $_POST['radio-14-set'];
	$arrayletto[15]= $_POST['radio-15-set'];
	$arrayletto[16]= $_POST['radio-16-set'];
	$arrayletto[17]= $_POST['radio-17-set'];
	$arrayletto[18]= $_POST['radio-18-set'];
	
	if ($arrayletto[1]!="")
		$risultato= $arrayletto[1].",".$arrayletto[2].",".$arrayletto[3].",".$arrayletto[4].",".$arrayletto[5].",".$arrayletto[6].",".$arrayletto[7].",".$arrayletto[8].",".$arrayletto[9].",".$arrayletto[10].",".$arrayletto[11].",".$arrayletto[12].",".$arrayletto[13].",".$arrayletto[14].",".$arrayletto[15].",".$arrayletto[16].",".$arrayletto[17].",".$arrayletto[18];
	else
		$risultato="";
		
	$trovata=false;
	/* verifica se devo aggiornare o fare un nuovo inserimento */
	$q="SELECT * FROM Schedina where Competizione_Id_competizione='".$_POST['Id_competizione']."'";
	$t=mysql_query($q,$connessione); 	
	while($r=mysql_fetch_object($t)){
		$trovata=true;
	}
		
	if($trovata)
		$q="UPDATE Schedina SET Risultati='".$risultato."',".$stringa_sql_mod." where Competizione_Id_competizione='".$_POST['Id_competizione']."'";
	else 
		$q="INSERT into Schedina values ('".$_POST['Id_competizione']."',".$stringa_sql.",'".$risultato."')";

	print $q;

	if(!mysql_query($q,$connessione)) 
		$Errore = "Errore di inserimento";
	else
		$Inserimento_scontri="ok";
		
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
    <link rel="stylesheet" href="../css/schedina.css" type="text/css" media="screen" />
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
        <?php 
		if ($inserimento_schedina) print'<div class="ok"><img src="../images/ok.png" /><h3>La competizione valida come schedina è stata inserita con successo</h3></div><p>&nbsp;</p>';
		if ($modifica_schedina) print'<div class="ok"><img src="../images/ok.png" /><h3>La competizione valida come schedina è stata modificata con successo</h3></div><p>&nbsp;</p>'; 
		if ($inserimento_puntate) print'<div class="ok"><img src="../images/ok.png" /><h3>La schedina è stata caricata con successo</h3></div><p>&nbsp;</p>'; 
		if ($Inserimento_scontri) print'<div class="ok"><img src="../images/ok.png" /><h3>Gli scontri sono stati caricati</h3></div><p>&nbsp;</p>';
		
		if ($inserimento_file) print'<div class="ok"><img src="../images/ok.png" /><h3>Il file è stato cricato con successo</h3></div><p>&nbsp;</p>'; 
		
		if ($Errore!="") print'<div class="errore"><img src="../images/no.png" /><h3>Errore. Operazione annullata</h3></div><p>&nbsp;</p>';
		?>
        
        <h1>Admin</h1> 
        <br/>
       	<div style="width:100%;">
        	<h3>Carica logo</h3>      	
            <h5>0) Carica nel server il logo della manifestazione</h5>		
            <form action="Admin_schedina.php" method="post" enctype="multipart/form-data">   
            <label>Logo manifestazione&nbsp;</label><input type="file" name="file">&nbsp;<input type="submit" name="Invio_foto" value="Carica"/>
            </form>
            <span class="commenti"><i>Prima di inserire il logo verificare che non sia gia presente nella lista</i></span>
        </div>
        <div style="width:100%; height:380px; ">
            <div style="width:45%; float:left;"id="modulo_ins_dati">
                <h3>Inserisci / Modifica</h3>      	
                <h5>1) Inserisci la competizione che vale come scedina</h5>
                <form action="Admin_schedina.php"  style="width:100%;" method="post">
                    <table>
                        <tr><td><label>Nome</label></td><td><input type="text" name="nome" placeholder="Nome schedina" required/></td><td></td></tr>
                        <tr><td><label>Sede</label></td><td><input type="text" name="luogo" placeholder="Sede" required/></td><td></td></tr>
                        <tr><td><label>Data gara</label></td><td><input type="date" style="width:100%;" name="data" required/></td><td></td></tr>
                        <tr><td><label>Abilita schedina</label></td><td><input type="date" style="width:100%;" name="inizio" required/></td><td><input type="time" name="ora_inizio" value="00:00" required/></td></tr>
                         <tr><td><label>Disabilita schedina</label></td><td><input type="date" style="width:100%;" name="fine" required/></td><td><input type="time" name="ora_fine" value="00:00" required/></td></tr>
                         <tr><td><label>Logo</label></td><td><select  style="width:100%;" name="logo"><option  value=" "></option>
        <?php
        $directory = "../images/header_gare/";
          //Apro l'oggetto directory
        if ($directory_handle = opendir($directory)) {
            //Scorro l'oggetto fino a quando non è termnato cioè false
            while (($file = readdir($directory_handle)) !== false) {
                //Se l'elemento trovato è diverso da una directory 
                //o dagli elementi . e .. lo visualizzo a schermo
                if((!is_dir($file))&($file!=".")&($file!=".."))
                    print'<option value="'.$file.'">'.$file.'</option>';
                
            }
            //Chiudo la lettura della directory.
            closedir($directory_handle);
        }
        ?>
                                                            </select>
                         </td></tr>
                         <tr><td><label>Stato risultati</label></td><td><select style="width:100%;" name="stato_ris"><option value="Ufficiosa">Ufficiosi</option><option value="Ufficiale">Ufficiali</option></select></td></tr>
                     </table>
                     <input type="submit" name="Inserisci" value="Inserisci schedina" />
                 </form>
                 <span class="commenti"><i>ATTENZIONE!!! Ad ogni insserimento e modifica vengono aggiornati anche i dati riguardanti gli utenti attivi. Prestare attenzione qualora si faccia una modifica a schdina superata</i></span>
            </div>
            <div style="width:55%; float:left;">
                <h3>Cerca schedina</h3>
                <h5>2) Cerca la schedina per inserire/modificare le giocate e i risultati</h5>
                <table class="tab_el" ><tr><th width="50%">Nome</th><th width="30%">Data</th><th width="20%">Anteprime</th></tr>
                    
                        <?php
                        $riga=false;
                        $q="SELECT * FROM `Competizione` WHERE ('$data_1' - INTERVAL 180 DAY<`Data_fine` and (Type=1 or Type=3) )";
                        $t=mysql_query($q,$connessione); 	
                        while($r=mysql_fetch_object($t)){
                            if ($riga){print '<tr class="pari">';} else {print '<tr class="dispari">';} $riga=!$riga;
                            print '<td style="cursor:pointer;" onClick="Cerca_schedina('.$r->Id_competizione.');Aggiorna_schedina('.$r->Id_competizione.');">'.$r->Nome.'<td>'.$r->Data_fine.'</td><td>
                                        <a href="Admin_view_schedina_personale.php?id='.$r->Id_competizione.'" target="new">View </a>
                                        <a href="javascript:void(0)" onClick="Classifica('.$r->Id_competizione.');"> Classifica</a>
                                    </td>
									
									</tr>';
                        }
                        ?>
                </table>
                <span class="commenti"><i>Clicca sul nome della schedina e procedi a effettuare le operazioni nel modulo sottostante</i></span>	
            </div>
		</div>		        
		<br/>
		<div id="modulo_dati">      
        </div>
        <br/>
        <br/>
	</div>
</body>
</html>
<script language="JavaScript" type="text/javascript">
function Aggiorna_schedina(id){
var xmlhttp;
if (window.XMLHttpRequest)
{xmlhttp=new XMLHttpRequest();}
else if (window.ActiveXObject){xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
else{alert("Il browser non supporta XMLHTTP");}
xmlhttp.onreadystatechange=function(){
if(xmlhttp.readyState==4){document.getElementById("modulo_ins_dati").innerHTML=xmlhttp.responseText;}
}
xmlhttp.open("GET","Ajax/Read_schedina_dati.php?id="+id,true);
xmlhttp.send(null);
}
function Cerca_schedina(id){
var xmlhttp;
if (window.XMLHttpRequest)
{xmlhttp=new XMLHttpRequest();}
else if (window.ActiveXObject){xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
else{alert("Il browser non supporta XMLHTTP");}
xmlhttp.onreadystatechange=function(){
if(xmlhttp.readyState==4){document.getElementById("modulo_dati").innerHTML=xmlhttp.responseText;}
}
xmlhttp.open("GET","Ajax/Read_schedina.php?id="+id,true);
xmlhttp.send(null);
}
function Classifica(id){
var xmlhttp;
if (window.XMLHttpRequest)
{xmlhttp=new XMLHttpRequest();}
else if (window.ActiveXObject){xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
else{alert("Il browser non supporta XMLHTTP");}
xmlhttp.onreadystatechange=function(){
if(xmlhttp.readyState==4){document.getElementById("modulo_dati").innerHTML=xmlhttp.responseText;}
}
xmlhttp.open("GET","Ajax/Read_schedina_rank.php?id="+id,true);
xmlhttp.send(null);
}
</script>
 
    