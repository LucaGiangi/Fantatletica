<?php
$page_name = "Read_iscritti_punti_fanta";
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

$q="SELECT * FROM Iscritti JOIN Atleti ON Iscritti.Atleti_id_atleti = Atleti.Id_Atleta where (Competizione_Id_competizione='".$id_comp."' and (Gara_Gara1='".$gara."' or Gara_Gara2='".$gara."')) ORDER BY Risultato_punti,Risultato_classifica desc";


print '<table class="tab_el" id="0"><tbody><tr><th width="13%">Id</th><th>Naz.</th><th width="42%">Nome</th><th width="10%">Costo</th><th width="20%">Punti</th><th width="15%">Gara2</th></tr> ';	
							
$i=0; // contatore array avatar
$t=mysql_query($q,$connessione); 	
while($r=mysql_fetch_object($t)){
	
	if ($riga){print '<tr class="pari">';} else {print '<tr class="dispari">';}	 
	$i++;
	
	print'<td>'.$r->Id_iscritti.'</td>';
	print'<td><img src="../images/Flags/'.$r->Nationality.'.png" title="'.$r->Nationality.'" alt="'.$r->Nationality.'"/></td>';
	print'<td class="ath_name"><strong>'.$r->Cognome.'</strong> '.$r->Nome.'</td>';   //termina riga
		
	/* stampa gara con risultato punti */
	if (strcmp($gara,$r->Gara_Gara1)==0){
		print'<td style="text-align:right;">'.$r->Costo_gara1.'</td>';
		print'<td style="text-align:right;"><input type="text" onclick="reset_value('.$r->Id_iscritti.');" value="'.$r->Risultato_punti.'" id="'.$r->Id_iscritti.'" /><input type="button" value="Invia" name="Invia" onclick="Add_result(1,'.$r->Id_iscritti.');"/> </td>';
		print '<td>'.$r->Gara_Gara2.'</td>';
	}else{
		print'<td style="text-align:right;">'.$r->Costo_gara2.'</td>';
		print'<td style="text-align:right;"><input type="text" onclick="reset_value('.$r->Id_iscritti.');" value="'.$r->Risultato_classifica.'" id="'.$r->Id_iscritti.'"/><input type="button" value="Invia" name="Invia" onclick="Add_result(2,'.$r->Id_iscritti.');"/></td>';
		print '<td>'.$r->Gara_Gara1.'</td>';
	}
	//print '<td>'.$r->Gara_Gara2.'</td>';
	print'</tr>';

	$riga = !$riga;
}							
?>