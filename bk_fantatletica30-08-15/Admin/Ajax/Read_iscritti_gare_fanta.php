<?php
$page_name = "Read_iscritti_gara_fanta";
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

include '../../php/check_admin.php';

$n_letti="";
$c_letti="";
/* ripulisci nome gara da caratteri speciali */
$gara=str_replace("’","&rsquo;",$_GET['gara']);

$id_comp =$_GET['id'];
/*if ($_GET['id']!="") 
	$id_comp=$_GET['id'];*/

print'<h3>Controlla risultati</h3>
	<div style="width:100%;" >';
	
	$riga = false;
	$gara_prec = "";	
	$id_table=0;			
	//$q="SELECT * FROM Iscritti JOIN Atleti ON Iscritti.Atleti_id_atleti = Atleti.Id_Atleta where Competizione_Id_competizione='".$id_comp."' ORDER BY Atleti.sesso desc, Iscritti.Gara_Gara1,Atleti.Cognome"; /* modifica del 07/07/2015 campionati europei U23 anche in g-team_new*/
	
		$q="SELECT * FROM Iscritti JOIN Atleti ON Iscritti.Atleti_id_atleti = Atleti.Id_Atleta where Competizione_Id_competizione='".$id_comp."' ORDER BY Iscritti.Gara_Gara1,Atleti.sesso desc,Atleti.Cognome";
				
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
				print $r->Gara_Gara1."','".$id_comp;
				print "'";
				print')"><div class="titolo"> <hh3 class="cursore">'.$r->Gara_Gara1.'</hh3></div></div>    
					<div style="display:none;" name="no" id="'.$r->Gara_Gara1.'">';
			}//crea nuova tabella gara

	$riga = !$riga;	
	}
	//completa ultima tabella modifica 23/02/15
	print ' </div><br/> ';
	 	   
?>