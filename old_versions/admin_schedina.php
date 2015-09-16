<?php
$page_name = "admin_schedina";
session_start();
include "db.inc";
include "php/invio_mail.php";

//versione 3.0
$Errore ="";
// esci dalla sezione admin
if ($_GET['cod']=="esci"){
	session_destroy();
	header('Location:index.php');	
}

include 'php/Gestione_token.php';

include 'php/verifica_accesso_g.php';
include "php/logout.php";
include 'php/check_admin.php'; // verifica admin


$Inserzione_precedente=false;
$array_giocate = array();

if ($_POST['Carica']=='Carica'){
 $q="SELECT * FROM Schedina where Competizione_Id_competizione='".$_POST['Id']."'";
	 $t=mysql_query($q,$connessione); 	
	 while($r=mysql_fetch_object($t)){
		
	$array_giocate[1]=$r->Giocata1;
	$array_giocate[2]=$r->Giocata2;
	$array_giocate[3]=$r->Giocata3;
	$array_giocate[4]=$r->Giocata4;
	$array_giocate[5]=$r->Giocata5;
	$array_giocate[6]=$r->Giocata6;
	$array_giocate[7]=$r->Giocata7;
	$array_giocate[8]=$r->Giocata8;
	$array_giocate[9]=$r->Giocata9;
	$array_giocate[10]=$r->Giocata10;
	$array_giocate[11]=$r->Giocata11;
	$array_giocate[12]=$r->Giocata12;
	$array_giocate[13]=$r->Giocata13;
	$array_giocate[14]=$r->Giocata14;
	$array_giocate[15]=$r->Giocata15;
	$array_giocate[16]=$r->Giocata16;
	$array_giocate[17]=$r->Giocata17;
	$array_giocate[18]=$r->Giocata18;
	 }		
}

if (($_POST['inserisci']=='Invia') and ($_POST['conferma']=='ok')){	

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

/*
$puntata= $arrayletto[1].",".$arrayletto[2].",".$arrayletto[3].",".$arrayletto[4].",".$arrayletto[5].",".$arrayletto[6].",".$arrayletto[7].",".$arrayletto[8].",".$arrayletto[9].",".$arrayletto[10].",".$arrayletto[11].",".$arrayletto[12].",".$arrayletto[13].",".$arrayletto[14].",".$arrayletto[15].",".$arrayletto[16].",".$arrayletto[17].",".$arrayletto[18];
*/
for ($k=1;$k<18;$k++)
$stringa_sql=$stringa_sql."'".$giocate[$k]."',";

$q="INSERT into Competizione values (null,'".$_POST['nome']."','".$_POST['luogo']."','".$_POST['data']."','".$_POST['data']."','".$_POST['inizio']."','".$_POST['fine']."','','','','1',default,'0')";

if(!mysql_query($q,$connessione)) 
			$Errore = "Errore di inserimento";
			else{
		$q="select Id_competizione from Competizione where (Schedina='1' and Nome='".$_POST['nome']."'and Data_inizio='".$_POST['data']."')";
	$t=mysql_query($q,$connessione); 	
	while($r=mysql_fetch_object($t))
		$ID = $r->Id_competizione;

$stringa_sql=$stringa_sql."'".$giocate[18]."'";
 $q="INSERT into Schedina values ('".$ID."',".$stringa_sql.",'')";

		if(!mysql_query($q,$connessione)) 
			$Errore = "Errore di inserimento";
			else
			 $Inserimento="ok";
			}//if errore inserimento gara
}



if ($_POST['inserisci']=='Invia risultati'){
	/* inserisci stringa risultati*/
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

	$risultato= $arrayletto[1].",".$arrayletto[2].",".$arrayletto[3].",".$arrayletto[4].",".$arrayletto[5].",".$arrayletto[6].",".$arrayletto[7].",".$arrayletto[8].",".$arrayletto[9].",".$arrayletto[10].",".$arrayletto[11].",".$arrayletto[12].",".$arrayletto[13].",".$arrayletto[14].",".$arrayletto[15].",".$arrayletto[16].",".$arrayletto[17].",".$arrayletto[18];

$q="UPDATE Schedina SET Risultati='".$risultato."' where Competizione_Id_competizione='".$_POST['Id_competizione']."'";
		if(!mysql_query($q,$connessione)) 
			$Errore = "Errore di aggiornamento";
			else{
			 $Aggiornamento="ok";	
			/* segnala a tutti i giocatori dei risulati*/
			$count_mail_send=0;
			
			$q="SELECT Mail,E_Mail,Id_giocatore from Giocate left join Giocatore on Giocatore.Id_giocatore=Giocate.Giocatore_Id_giocatore where Competizione_Id_competizione='".$_POST['Id_competizione']."'";	
			$t=mysql_query($q,$connessione); 	
			while($r=mysql_fetch_object($t)){		
			$mex="<p><a href='http://sunsetbeach-club.it/Riservato_Fede_Luca_001/VERSIONE2/index.php'><img style='padding-left:30px;' src='http://sunsetbeach-club.it/Riservato_Fede_Luca_001/VERSIONE2/images/logo2.png' title='Atletipercaso.net il gioco'/></a>
			<br/>
			<br/>
			<span style='color:#3b5998; font-size:18px;'>"; if($_SESSION['g_id']!="") $mex=$mex.$_SESSION['g_nome'];
$mex=$mex."!</span><br/><br/>";
$mex=$mex."<span style='color:#3b5998; font-size:18px;padding-left:30px;'>Lo staff di </span><span style='color:#E67300; font-size:18px;'> atletipercaso.net - il gioco </span><span style='color:#3b5998; font-size:18px;'>ti informa che sono usciti i risulati della schedina che hai giocato.</span></p>
			<p>verifica la tua giocata tramite il link sottostante<p>
			
			<a href='http://sunsetbeach-club.it/Riservato_Fede_Luca_001/VERSIONE2/RSchedina.php?Id=".$_POST['Id_competizione']."&cod=".$r->Mail."&Idg=".$r->Id_giocatore."' target='new'>Vedi risultati</a>
			";
			
			if ($r->Mail!="")
				Invio($r->Mail,$mex,"atletipercaso.net - la schedina!"); 
			else
				Invio($r->E_mail,$mex,"atletipercaso.net - la schedina!"); 
			$count_mail_send++;
			}
	
			}
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Atletipercaso.net -Il Gioco</title>


<meta name="author" CONTENT="Luca Giangravè, Federica Chiappori"/>
<meta name="description" content="Atletipercaso.net da oggi raddoppia!!! Non piú solo news, foto e recensioni, ma adesso anche GIOCO. Crea la tua squadra, sfida i tuoi amici e scala la vetta della classifica. In palio tanti premi per te."/>
<meta name="keywords" lang="it" content="Ateltica,Atletipercaso,fantatletica,schedina,gioco" />
<meta name="robots" content="index,follow"/>

<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/schedina.css" type="text/css" media="screen" />
<link rel="shortcut icon" href="images/Tool/ico.ico"/>
</head>
<body>

<?php include 'php/header3_0.php';?>  

<div class="newcorpo">
    <div class="contenuto">
        <div class="parziale">
		  <articolo>    
            <?php
			if ($Inserimento=="ok")print'    <div class="ok">
          <img src="images/ok.png" /><h3>Schedina inserita con successo</h3>
          </div>
          
          Nella tua mail troverai la schedina appena giocata	<br/>	<br/>';
		  
		  if ($Aggiornamento=="ok")print'    <div class="ok">
          <img src="images/ok.png" /><h3>Risultati inserita con successo</h3>
          </div>        
          Sono state inviate '.$count_mail_send.' mail	<br/>	<br/>';
		

			
			print'
			<h2>Amministratore</h2><br/> 
                <h1> Atletipercaso.net - la schedina</h1><br/> 
				
				
				 <p>Unica regola per vincere la schedina: fare <span class="budget"> 13!</span> </p>
               
          <p>Avrai un pronostico da indovinare e 3 possibilità: 1 (il vincente è il primo atleta citato), 2 (il vincente è il secondo atleta citato), X (nessuno dei due atleti sarà il vincitore della gara). Ad esempio:</p>
          
          <p><strong>Delmas Obou</strong> Vs <strong>Michael Tumi</strong>: <strong>1</strong> (vittoria per Obou), <strong>2</strong> (vittoria per Tumi), <strong>X</strong> (non vince nessuno dei due).</p>
          <p>Come facciamo nel caso in cui un’atleta non partisse nella gara in cui è iscritto? Poiché abbiamo pensato a tutto, qualora uno degli scontri previsti non abbia luogo la schedina sarà comunque valida. Infatti, compilerai altri 5 pronostici così, nel caso in cui non avvenga uno scontro, verrà ripescato il 14° pronostico. Se non ne avverranno due, verranno ripescati il 14° e il 15° e così via fino ad un massimo di 18.</p>';
				;?>

     <?php
 if ($_POST['Id_competizione']!="") print'<br/><h2>Link risultati
  <a href="admin_mostra_link_schedina.php?id='.$_POST['Id_competizione'].'">Link risultati schedina</a>
  </h2>';
 print'<br/><h2>Modifica schedine</h2>';
print'<form action="admin_schedina.php" method="post"><table>
<tr><td><label>Scegli schedina inserita</td><td>
<select name="Id">';

$q="SELECT * FROM Competizione  WHERE (Type='1') Order by Termine_formazione";
	$t=mysql_query($q,$connessione); 	
	while($r=mysql_fetch_object($t))
print'<option value="'.$r->Id_competizione.'">'.$r->Nome.'</option>';

print'</select></td></tr><tr><td> <input type="submit" onclick="carica_schedina()" name="Carica" value="Carica" /></td><td></td> </table></form>';

     print'       <div class="button-holder">
            <form action="admin_schedina.php"  method="post">';
        
			/* */
			print'<h2>Aggiungi schedina</h2>';
		print'	<table>
		<tr><td><label>Nome</label><td><td><input type="text" name="nome" placeholder="Nome schedina" required="required"/></td>	 
	 <tr><td><label>Sede</label><td><td><input type="text" name="luogo" placeholder="Sede" required="required"/></td> 
	 <tr><td><label>Data gara</label><td><td><input type="date" name="data" required="required"/></td>
	  	 <tr><td><label>Abilita schedina</label><td><td><input type="date" name="inizio" required="required"/></td>
	 	 <tr><td><label>Disabilita schedina</label><td><td><input type="date" name="fine" required="required"/></td>
		 	 <tr><td><label>Id schedina</label><td><td><input type="text" name="Id_competizione" value="'.$Id_competizione.'"/></td>
		 </table>';
	/* */   
	
  print'
            <table class="schedina">
            <tr>
			<th width="10%"></th>
<th width="60%">Scontro</th>
<th width="30%" colspan="3" >Giocata</th>
</tr>
';


           for($i=1;$i<19;$i++){
			   if ($i==14)
			   print'</table><h3>Riserve</h3><table class="schedina">
            <tr >
			<th width="10%"></th>
<th width="60%">Scontro</th>
<th width="30%" colspan="4" >Giocata</th>
</tr>';
			   	print'
<tr class="evidenzia"><td>'.$i.'</td><td><input id="input'.$i.'" value="'.$array_giocate[$i].'" name="input'.$i.'" type="text"/></td>
<td><input  type="radio" id="radio-'.$i.'-1" name="radio-'.$i.'-set" value="1" class="regular-radio big-radio" /><label for="radio-'.$i.'-1">1</label></td><td><input type="radio" id="radio-'.$i.'-2" name="radio-'.$i.'-set" value="X" class="regular-radio big-radio" /><label for="radio-'.$i.'-2">X</label></td><td><input type="radio" id="radio-'.$i.'-3" name="radio-'.$i.'-set" value="2" class="regular-radio big-radio" /><label for="radio-'.$i.'-3">2</label></td><td><input type="radio" id="radio-'.$i.'-4" name="radio-'.$i.'-set" value="NP" class="regular-radio big-radio" /><label for="radio-'.$i.'-4">Np</label></td>
           </tr>';			   
		   }

		 print'   </table>
		 <br/>
		 <input type="hidden" name="Id_competizione" value="'.$_POST['Id'].'"/>
		 
		 <input type="hidden" name="conferma" value="ok"/>';
      if ($array_giocate[1]!="")
	   print'<input type="submit"  name="inserisci" value="Invia risultati" />';
	  else 
	  print'<input type="submit"  name="inserisci" value="Invia" />';
          print'  </form>
            </div>';	
 
	 ?>
              </articolo>
        </div><!-- --->     
                <div id="articoli" class="parziale1">
            
            <?php include 'php/articoli3_0.php';?>
        </div> 
    </div> 
</div>
<?php include 'php/footer3_0.php';?>  
</body>
</html>

