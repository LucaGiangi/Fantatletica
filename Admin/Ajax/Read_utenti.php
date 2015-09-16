<?php
$page_name = "Read_utenti";
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




		
		
		print'<h3>Lista utenti</h3>';
		
		print'<form action="Admin_home.php"  style="max-width:2000px;width:100%;" method="post">';
		print'<table class="tab_el img_schedina" >
				<tr><th width="10%">Id</th><th width="35%">Nick</th><th width="20%">Status</th><th width="20%">Partite_giocate</th><th width="15%">Punti anno</th></tr>';
		$q="SELECT * FROM Giocatore where Nome_team='".$_GET['id']."'";
		$t=mysql_query($q,$connessione); 	
		while($r=mysql_fetch_object($t)){
			print'<tr><td>'.$r->Id_giocatore.'</td><td>'.$r->Nome_team.'</td><td>
				<select onchange="this.form.submit();" name="Stato">
					<option '; if ($r->Status==1) print "selected"; print' value="1">Abilitato</option>
					<option '; if ($r->Status==0) print "selected"; print' value="0">Disabilitato</option>
				</select></td>';
				print'<td>'.$r->Partite_giocate.'</td><td>'.$r->Punti_anno.'</td></tr>';	
		}
		print'<input type="hidden" name="Conferma" value="OK" /></table></form>';
    
?>