<?php
$page_name = "Read_schedina_rank";
//versione 4.1 responsitive

//($_SESSION['id_competizione']!=-1)  usato per verificare la possibilità di modificare la squadra
session_start();

/*$data = date ("Y-m-d");*/
$data = date("Y/m/d G:i:s");
$data_1 = date("Y/m/d");

include "../../db.inc";
include "../../php/formatta_data.php"; 

include '../../php/Gestione_token.php';
include '../../php/verifica_accesso_g.php';
include "../../php/logout.php";

include '../../php/check_admin.php'; // verifica admin


/* carica struttura per classifica schedina */
$posizione= array(); /* in posizione n ci stanno quelli che hanno totalizzato n punti */

for ($i=0;$i<14;$i++)
	$posizione[$i]=array();


function ContaPunti($Puntata,$Risultati){
	$vet_puntata = array();
	$vet_risultati = array();	
	$vet_puntata = explode(",",$Puntata);
	$vet_risultati = explode(",",$Risultati);
	
	$Giocate_vinte=0; // conta pronostici azzeccati
	$Giocate_calcolate=0; //calcola giocate valide
	
	for($i=0;$i<18;$i++){
		
		if ($Giocate_calcolate<13) 	
			   if ($vet_risultati[$i]!='NP'){ // verifica che la giocata sia valida
					$Giocate_calcolate++;	
					if ($vet_puntata[$i]==$vet_risultati[$i])
						$Giocate_vinte++;
				}	
	}
	return $Giocate_vinte; /* ritorna puntate vinete */
}	
/* leggi risultati */
$ok_gara=false;			/* indica se la gara è stata trovata */
$ok_classifica=false;	/* indica se i risultati sono visibili */


$q="select * from Competizione where Id_competizione='".$_GET['id']."'";
	
$t=mysql_query($q,$connessione); 
while($r=mysql_fetch_object($t)){
	$Header_logo=$r->Header_link;
	$nome_competizione=$r->Nome;
	$data_fine=$r->Data_fine;
	
}
$k=1;
$int_c=0;
	
if ($_GET['id']!='18' && $_GET['id']!='22')
	
	$q="select Giocate.Puntata,Giocate.Giocatore_Id_giocatore,Schedina.Risultati,Giocatore.Nome_team as Nome from Giocate JOIN Schedina on Giocate.Competizione_Id_competizione=Schedina.Competizione_Id_competizione JOIN Giocatore on Giocatore.Id_giocatore=Giocate.Giocatore_Id_giocatore where Giocate.Competizione_Id_competizione='".$_GET['id']."'";
else
	
	$q="select Giocate.Puntata,Giocate.Mail as Nome,Schedina.Risultati from Giocate JOIN Schedina on Giocate.Competizione_Id_competizione=Schedina.Competizione_Id_competizione where Giocate.Competizione_Id_competizione='".$_GET['id']."'";

$t=mysql_query($q,$connessione); 
while($r=mysql_fetch_object($t)){	
	$ok_classifica= true;	
	$posizione[ContaPunti($r->Puntata,$r->Risultati)][]= $r->Nome;
}

$int_conta=0;
print'<h3>Classifica</h3>';
		
print'<img class="logo_gara" style="padding-right:20px;  padding-bottom:20px;" src="../images/header_gare/'.$Header_logo.'">
<h2><articolo>'.$nome_competizione.'</articolo></h2>
<p></p>         
<table  class="tab_el schedina">
<tr>
	<th width="10%" >Rank</th>
	<th width="60%">Nome</th>
	<th width="30%" colspan="3" >Pronostici vinti</th>
</tr>';    
	
for($i=13;$i>=0;$i--){
	
	for($j=0;$j<count($posizione[$i]);$j++){//
		$riga=!$riga;				
		if ($riga){print '<tr class="pari">';} else {print '<tr class="dispari">';}	
		print '<td style="text-align:center">';
		/*if ($i==13) print '<img  class="gold" src="images/gold.png">'; 
		if ($i==12) print '<img  class="silver" src="images/silver.png">';
		if ($i==11) print '<img  class="bronze" src="images/bronze.png">';
		if ($i<11)*/ print $k."&deg;"; 
		print'</td><td>'.$posizione[$i][$j].'</td>';
		print '<td style="text-align:center">'.$i.'</td>';
		print'</tr>';
	}
	
	if (count($posizione[$i])>0 )$k+=count($posizione[$i]);
	$int_c=0;
	$int_conta;
	if ($int_conta>20) break;
}
print' </table><span class="commenti"><i>Lista dei primi 20 punteggi</i></span>';
?>