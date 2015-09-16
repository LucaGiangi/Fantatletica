<?php
$page_name = "Read_schedina";
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



//print $_GET['id'];
/* leggi dati schedina */
	$array_giocate = array();
	$array_risulati = array();
	$q="SELECT * FROM Competizione where Id_competizione='".$_GET['id']."'";
	$t=mysql_query($q,$connessione); 	
	while($r=mysql_fetch_object($t)){
		list ($data_inizio,$orario_inizio)=explode(' ',$r->Inizio_formazione);		
		list ($data_termine,$orario_termine)=explode(' ',$r->Termine_formazione);
		list($ora_inizio,$min_inizio,$sec_inizio)=explode(":",$orario_inizio);
		list($ora_termine,$min_termine,$sec_termine)=explode(":",$orario_termine);
		
		print'<h3>Inserisci / Modifica</h3>      	
            <h5>1) Inserisci la competizione che vale come scedina</h5>
            <form action="Admin_schedina.php"  style="width:100%;" method="post">
            	<table>
                    <tr><td><label>Nome</label></td><td><input type="text" name="nome" value="'.$r->Nome.'" placeholder="Nome schedina" required/></td><td></td></tr>
                    <tr><td><label>Sede</label></td><td><input type="text" name="luogo" value="'.$r->Sede.'" placeholder="Sede" required/></td><td></td></tr>
                    <tr><td><label>Data gara</label></td><td><input type="date" value="'.$r->Data_fine.'" name="data" required/></td><td></td></tr>
                    <tr><td><label>Abilita schedina</label></td><td><input type="date" value="'.$data_inizio.'" name="inizio" required/></td><td><input type="time" name="ora_inizio" value="'.$ora_inizio.':'.$min_inizio.'" required/></td></tr>
                     <tr><td><label>Disabilita schedina</label></td><td><input type="date" value="'.$data_termine.'"name="fine" required/></td><td><input type="time" name="ora_fine" value="'.$ora_termine.':'.$min_termine.'" required/></td></tr>
					 <tr><td><label>Logo</label></td><td><select style="width:100%;" name="logo">';
	
		$directory = "../../images/header_gare/";
		  //Apro l'oggetto directory
		if ($directory_handle = opendir($directory)) {
			//Scorro l'oggetto fino a quando non è termnato cioè false
			while (($file = readdir($directory_handle)) !== false) {
				//Se l'elemento trovato è diverso da una directory 
				//o dagli elementi . e .. lo visualizzo a schermo
				if((!is_dir($file))&($file!=".")&($file!=".."))
					print'<option ';if ($r->Header_link==$file)  print "selected"; print' value="'.$file.'">'.$file.'</option>';
				
			}
			//Chiudo la lettura della directory.
			closedir($directory_handle);
		}
    
    	print'</select></td></tr>
					 <tr><td><label>Stato risultati</label></td><td><select style="width:100%;" name="stato_ris">
					 			<option '; if ($r->Stato_classifica=="Ufficiosa") print "selected"; print ' value="Ufficiosa">Ufficiosi</option>
								<option '; if ($r->Stato_classifica=="Ufficiale") print "selected"; print ' value="Ufficiale">Ufficiali</option>
							</select></td>
                 </table>
				 <input type="hidden" name="Id_competizione" value="'.$_GET['id'].'"/>
                 <input type="submit" name="Modifica" value="Modifica schedina" />
             </form>
			  <span class="commenti"><i>ATTENZIONE!!! Ad ogni insserimento e modifica vengono aggiornati anche i dati riguardanti gli utenti attivi. Prestare attenzione qualora si faccia una modifica a schdina superata</i></span>';
	}
    
?>