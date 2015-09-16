<?php
$page_name = "Read_schedina_giocate";
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

print'<h3>Giocate schedina</h3>
        <table class="tab_el" width="100%"><th>N</th> <th>Giocatore</th><th>Giocata</th><th>Giorno-ora</th><th>View</th>';
         
$riga=false;
$i=1;
$q="SELECT * FROM Giocate left JOIN Giocatore on Giocatore.Id_giocatore=Giocate.Giocatore_Id_giocatore where Competizione_id_competizione='".$_GET['id']."' order by Nome_team";
$t=mysql_query($q,$connessione); 			
while($r=mysql_fetch_object($t)){	
	if ($riga) print '<tr class="pari">'; else print '<tr class="dispari">';
	$riga= !$riga;
	
	print '<td>'.$i.'</td><td>'.$r->Nome_team.$r->Mail.'</td><td>'.$r->Puntata.'</td><td>'.$r->Time.'</td><td><a href="Admin_view_schedina_personale.php?id='.$_GET['id'].'&id_giocatore='.$r->Giocatore_Id_giocatore.'" target="new">Guarda</a></td></tr>';
	$i++;	
}


	print'</table>';
?>